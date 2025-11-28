<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = [
        'title',
        'description',
        'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // A project belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
