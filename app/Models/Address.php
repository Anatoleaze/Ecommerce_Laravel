<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * Champs autorisés en mass assignment
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'street',
        'additional_address',
        'postal_code',
        'city',
        'country',
        'phone',
        'is_default',
    ];

    /**
     * Casts Laravel
     */
    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Relation : une adresse appartient à un user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}