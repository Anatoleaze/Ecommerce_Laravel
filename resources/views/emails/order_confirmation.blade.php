<!DOCTYPE html>
<html>
<head>
    <title>Merci pour votre commande !</title>    
</head>
<body>
    <h1>Merci pour votre commande !</h1>
    <br>
    <p>Votre commande n°{{ $order->numero_commande }} a bien été prise en compte. Elle sera traitée dans les meilleurs délais.</p>
    <p>Total : {{ $order->total }} €</p>
    <p>Statut : {{ $order->statut }}</p>
    
    <p>Nous vous livrerons à l'adresse suivante :</p>
    <p>{{ $order->adresse_livraison }}</p>
    <br>
    <p>Cordialement,</p>
    <p>L'équipe de {{$site_name}}</p>
</body>
</html>