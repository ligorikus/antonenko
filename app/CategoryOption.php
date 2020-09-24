<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryOption extends Model
{
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_options', 'category_option_id', 'product_id');
    }
}
