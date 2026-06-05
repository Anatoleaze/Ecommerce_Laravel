<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }}</title>
    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:description" content="{{ Str::limit(strip_tags($product->description), 200) }}" />
    <meta property="og:image" content="{{ $product->image_name ? url($product->image_name) : url('/images/default.png') }}" />
</head>
<body>
    <div style="max-width:900px;margin:40px auto;font-family:Arial,Helvetica,sans-serif">
        <h1>{{ $product->name }}</h1>
        <img src="{{ $product->image_name ? url($product->image_name) : url('/images/default.png') }}" alt="{{ $product->name }}" style="max-width:100%;height:auto;"/>
        <p style="font-size:18px;color:#333">{{ $product->price }} €</p>
        <div style="margin-top:20px;color:#444">{!! nl2br(e($product->description)) !!}</div>
    </div>
</body>
</html>
