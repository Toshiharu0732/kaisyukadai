<?php

namespace App\Models\Posts;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    const UPDATED_AT = null;

    protected $fillable = [
        'like_user_id',
        'like_post_id'
    ];

//いいね数の表示、リレーション先のモデルからカウントする方法↓（'like_user_id'指定）
    public function users(){
        return $this->belongsToMany('App\Models\Users\User', 'likes', 'like_post_id', 'like_user_id');
    }

//いいね数の表示、既存のLike.phpのlikeCounts($post_id)メソッドを使う方法。↓
    public function likeCounts($post_id){
        return $this->where('like_post_id', $post_id)->get()->count();
    }


      public function post(){
        return $this->belongsTo('App\Models\Posts\Post');
    }


}
