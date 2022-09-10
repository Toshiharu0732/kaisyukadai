<?php

namespace App\Models\Categories;

use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    const UPDATED_AT = null;
    const CREATED_AT = null;
    protected $fillable = [
        'main_category'
    ];

    public function subCategories(){
    return $this->belongsToMany
     ('App\Models\Categories\SubCategory','sub_categories','main_category_id','id')->withPivot('id');// リレーションの定義
    }

}
