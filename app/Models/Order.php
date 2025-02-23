<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total', 'statut', 'methode_paiement', 'adresse_livraison', 'numero_commande'];

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
