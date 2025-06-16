<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workplace extends Model
{
    protected $table = 'workplaces';
    protected $fillable = [
        "job_creator_id","job_title","employee_level","work_experience","working_hours","work_format"
    ];

    public function user()
    {
        return $this->belongsTo(User::class,"job_creator_id");
    }
}
