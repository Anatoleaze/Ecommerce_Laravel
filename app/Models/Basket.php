<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    // Indiquer la table associée
    protected $table = 'baskets';

    // Désactiver les timestamps si la table ne contient pas `created_at` et `updated_at`
    public $timestamps = false;

    // Définir les colonnes modifiables
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'price'
    ];

    // Définir les relations avec User et Product
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
