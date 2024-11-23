<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
    ];

    /**
     * Relationship with Borrow.
     * A member can have many borrow records.
     */
    public function borrows()
    {
        return $this->hasMany(Borrow::class);
    }

    /**
     * Get borrows by status.
     */
    public function ongoingBorrows()
    {
        return $this->borrows()->where('status', 'OnGoing');
    }

    public function onTimeBorrows()
    {
        return $this->borrows()->where('status', 'OnTime');
    }

    public function lateBorrows()
    {
        return $this->borrows()->where('status', 'Late');
    }
}