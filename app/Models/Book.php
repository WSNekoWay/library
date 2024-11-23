<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'author',
        'published_year',
        'status',
    ];

    /**
     * Relationship with the Borrow model.
     * A book can have many borrows.
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Relationship with the Category model (many-to-many).
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories', 'book_id', 'category_id');
    }
}