<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function view_chat()
    {
        return view('chat.index');
    }
    public function index($user_id)
    {
        return view('chat.index', [
            'receiver' => $user_id
        ]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string',
        ]);

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'receiver_id' => $message->receiver_id,
                'receiver_name' => $message->receiver->name ?? 'Unknown',
                'message' => $message->message,
                'created_at' => $message->created_at->toDateTimeString(),
            ]
        ]);
    }

    public function getMessages(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $authId = auth()->id();
        $userId = $request->user_id;

        $messages = Message::where(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $authId)
                ->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($authId, $userId) {
            $query->where('sender_id', $userId)
                ->where('receiver_id', $authId);
        })->orderBy('created_at')->get();

        return $messages->map(function ($msg) {
            return [
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'sender_name' => $msg->sender->name ?? 'Unknown',
                'receiver_id' => $msg->receiver_id,
                'receiver_name' => $msg->receiver->name ?? 'Unknown',
                'created_at' => $msg->created_at->toDateTimeString(),
                'is_file' => $msg->is_file ?? false,
                'file_path' => $msg->file_path ?? null,
                'filename' => $msg->is_file ? basename($msg->file_path) : null,
            ];
        });
    }

    public function get_all_chat()
    {
        $sender_id = auth()->id();

        $sub = Message::selectRaw('MAX(id) as id')
            ->where(function($q) use ($sender_id) {
                $q->where('sender_id', $sender_id)
                    ->orWhere('receiver_id', $sender_id);
            })
            ->groupBy(DB::raw('LEAST(sender_id, receiver_id)'), DB::raw('GREATEST(sender_id, receiver_id)'));
        $messages = Message::whereIn('id', $sub)->orderBy('created_at', 'desc')->get();

        $all_chat = $messages->map(function ($message) use ($sender_id) {
            $chatPartnerId = $message->sender_id == $sender_id ? $message->receiver_id : $message->sender_id;
            $chatPartner = User::find($chatPartnerId);

            return [
                'id' => $message->id,
                'receiver_id' => $chatPartnerId,
                'receiver_name' => $chatPartner?->name ?? 'Unknown',
                'message' => $message->is_file ? '📎 File sent' : $message->message,
                'created_at' => $message->created_at->toDateTimeString(),
                'is_file' => $message->is_file ?? false,
            ];
        });

        return response()->json($all_chat);
    }



    public function sendFile(Request $request): JsonResponse
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'file' => 'required|file|max:5120',
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('chat_files', $filename, 'public');

        $message = Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => '📎 Sending file',
            'is_file' => true,
            'file_path' => $path,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'receiver_id' => $message->receiver_id,
                'receiver_name' => $message->receiver->name ?? 'Unknown',
                'file_link' => asset("storage/$path"),
                'filename' => $file->getClientOriginalName(),
                'message' => $message->message,
                'created_at' => $message->created_at->toDateTimeString(),
            ]
        ]);
    }
    // MessageController.php
    public function recentChats()
    {
        $userId = auth()->id();

        $recentChats = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->latest()
            ->get()
            ->groupBy(function ($msg) use ($userId) {
                return $msg->sender_id == $userId ? $msg->receiver_id : $msg->sender_id;
            })
            ->take(3)
            ->map(function ($messages, $otherUserId) {
                $lastMessage = $messages->first();
                $user = User::find($otherUserId);
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'avatar' => 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=3b82f6&color=fff&size=36',
                    'last_message' => $lastMessage->message,
                    'last_message_sender_id' => $lastMessage->sender_id,
                    'time' => $lastMessage->created_at->diffForHumans(),
                ];
            })
            ->values();

        return response()->json($recentChats);
    }

}
