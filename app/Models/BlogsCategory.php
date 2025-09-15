<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogsCategory extends Model
{
    protected $table = 'blogs_categories';

    protected $fillable = ['name', 'blogs_category_title'];

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'blogs_category_id');
    }
}
