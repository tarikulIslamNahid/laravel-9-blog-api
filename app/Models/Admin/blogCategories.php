<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\Category;

class blogCategories extends Model
{
    use HasFactory;
    public function cat()
    {
        return $this->hasMany(Category::class,'id', 'cat_id');
    }
}
