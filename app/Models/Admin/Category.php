<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Admin\blogs;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        'cat_name'
    ];
    public function blogs(){
        return $this->belongsToMany(blogs::class,'blog_categories','cat_id','blog_id');

    }
    public static function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = Category::where('cat_slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
}
