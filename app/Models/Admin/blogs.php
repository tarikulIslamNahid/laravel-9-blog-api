<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'thumb','created_by'
    ];
    public function cat(){
        return $this->belongsToMany('App\Admin\Category', 'blogCategories');
    }
    public static function uniqueSlug($title){
        $slug = Str::slug($title, '-');
        $count = blogs::where('slug', 'LIKE', "{$slug}%")->count();
        $newCount = $count > 0 ? ++$count : '';
        return $newCount > 0 ? "$slug-$newCount" : $slug;
    }
}
