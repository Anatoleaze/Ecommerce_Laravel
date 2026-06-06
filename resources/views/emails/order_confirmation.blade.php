@extends('emails.layout')

@section('title', 'Confirmation de votre commande')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Merci pour votre commande !</h2>
    <p>Votre commande <strong>#{{ $order->numero_commande }}</strong> a bien été enregistrée et sera traitée dans les meilleurs délais.</p>
    <div style="margin:24px 0; padding:16px; background-color:#f6f8fb; border-radius:8px;">
        <p style="margin:0;"><strong>Total :</strong> {{ $order->total }} €</p>
        <p style="margin:8px 0 0;"><strong>Statut :</strong> {{ $order->statut }}</p>
    </div>
    <p>Nous vous livrerons à l'adresse suivante :</p>
    <p style="margin-top:8px; font-weight:600;">{{ $order->adresse_livraison }}</p>
    <p>Nous vous remercions de votre confiance.</p>
@endsection
