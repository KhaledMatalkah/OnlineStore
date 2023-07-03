<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function Product()
    {
        return $this->hasOne(Product::class);
    }
    public function Products()
    {
        return $this->hasMany(Product::class);
    }
}
