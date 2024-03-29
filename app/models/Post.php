<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use SoftDeletes;


    protected $fillable = [
        'title', 'description', 'post_content', 'image', 'published_at', 'category_id'
    ];


    /*
     * Delete post image from storage
     *
     * @return void
     * */
    public function deleteImage()
    {
        Storage::delete($this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class); //or
        //return $this->belongsTo('App\Category');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * check if post has pags
     * @return bool
     */
    public function hasTag($tagId)
    {
        return in_array($tagId, $this->tags->pluck('id')->toArray());
    }
}
