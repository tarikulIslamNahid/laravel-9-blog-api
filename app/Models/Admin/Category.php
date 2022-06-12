<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'cat_name', 'district', 'area_name',
    ];
    public function blogs(){
        return $this->hasMany(blogCategories::class);
    }
}
