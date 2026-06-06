@extends('emails.layout')

@section('title', 'Mise à jour du statut de votre commande')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Bonjour,</h2>
    <p>Le statut de votre commande <strong>#{{ $order->numero_commande }}</strong> a été mis à jour.</p>
    <p style="margin:20px 0; padding:16px; background-color:#f6f8fb; border-radius:8px;">
        <strong>Nouveau statut :</strong> {{ $order->statut }}
    </p>
    <p>Nous vous remercions de votre confiance et restons à votre disposition pour toute question.</p>
@endsection
