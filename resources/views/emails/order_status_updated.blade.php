<!DOCTYPE html>
<html>
<head>
    <title>Votre commande a été mise à jour</title>
</head>
<body>
    <h1>Bonjour,</h1>
    <p>Le statut de votre commande <strong>#{{ $order->numero_commande }}</strong> a changé.</p>
    <p>Nouveau statut : <strong>{{ $order->statut }}</strong></p>
    <p>Merci de votre confiance !</p>
</body>
</html>
