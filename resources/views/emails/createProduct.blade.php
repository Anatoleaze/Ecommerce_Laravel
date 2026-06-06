@extends('emails.layout')

@section('title', 'Nouveautés dans notre boutique')

@section('content')
    <h2 style="margin-top:0; font-size:22px;">Bonjour {{ $contactData['nom'] }} {{ $contactData['prenom'] }},</h2>
    <p>Nous avons le plaisir de vous annoncer l'arrivée de nouveaux produits dans notre boutique.</p>
    <p>Découvrez les derniers ajouts qui enrichissent notre sélection et offrent de nouvelles possibilités pour vos achats.</p>
    <div style="margin:24px 0; text-align:center;">
        <a href="{{ $contactData['link'] }}" style="display:inline-block; background-color:#2f64e9; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:8px; font-weight:600;">Voir les nouveautés</a>
    </div>
    <p>Nous espérons que ces nouveautés vous plairont. Notre équipe reste à votre disposition si vous avez des questions.</p>
@endsection
