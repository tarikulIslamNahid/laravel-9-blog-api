<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Admin\Category;

class blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'thumb','created_by'
    ];

    public function category()
    {
        // return $this->hasMany(blogCategories::class,'blog_id', 'id');
        return $this->belongsToMany(Category::class,'blog_categories','blog_id','cat_id');
    }
  
    public static function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = blogs::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
}
