<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'body', 'thread_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function admin()
    {
        return $this->belongsTo('App\Models\Admin');
    }

    public function images()
    {
        return $this->hasMany('App\Models\Image');
    }
}
