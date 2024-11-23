<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCategory extends Model
{
    use HasFactory;

    // Specify the table name (optional, since it matches the default naming convention)
    protected $table = 'book_categories';

    // Define fillable fields for mass assignment
    protected $fillable = [
        'book_id',
        'category_id',
    ];

    // Timestamps are enabled by default, no need to specify $timestamps = true
    /**
     * Define the relationship with the Book model.
     */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Define the relationship with the Category model.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}