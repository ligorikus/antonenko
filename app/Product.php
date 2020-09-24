<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function category_options()
    {
        return $this->belongsToMany(CategoryOption::class, 'product_options', 'product_id', 'category_option_id');
    }
}
