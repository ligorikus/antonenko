<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function options()
    {
        return $this->hasMany(CategoryOption::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
