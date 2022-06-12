<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogs extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'description', 'thumb','created_by'
    ];
    public function cat(){
        return $this->belongsToMany('App\Admin\Category', 'blogCategories');
    }
}
