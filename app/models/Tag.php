<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];


    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
}

