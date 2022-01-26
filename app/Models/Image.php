<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'message_id', 's3_file_path'
    ];

    public function message()
    {
        return $this->belongsTo('App\Models\Message');
    }
}
