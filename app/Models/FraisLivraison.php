<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FraisLivraison extends Model
{
    use HasFactory;

    protected $table = 'frais_livraison';

    protected $fillable = ['pays', 'frais'];
}
