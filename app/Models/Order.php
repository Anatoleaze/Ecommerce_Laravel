<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'numero_commande',
        'total',
        'methode_paiement',
        'payment_intent_id',
        'adresse_livraison',
        'statut',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($commande) {
            do {
                $numero = 'CMD-' . date('Ymd') . '-' . str_pad(rand(1, 999999), 6, '0', STR_PAD_LEFT);
            } while (Order::where('numero_commande', $numero)->exists());

            $commande->numero_commande = $numero;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
