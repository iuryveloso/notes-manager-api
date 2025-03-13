<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    /** @use HasFactory<\Database\Factories\TodoFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**

     * The model's default values for attributes.

     *

     * @var array

     */

    protected $fillable = [
        'title',
        'body',
        'color',
        'favorited',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
