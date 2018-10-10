<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\User;

class Post extends Model
{
    protected $fillable = [
        'category_id', 'user_id', 'name', 'content', 'tags', 'image'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function form()
    {
        return [
            'category_id'=> '',
            'user_id' => '',
            'name' => '',
            'content' => '',
            'tags' => '',
            'image' => ''
        ];
    }
}
