<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color:#222; }
        h1 { font-size: 20px; }
        .box { border:1px solid #ccc; padding:12px; margin-top:10px; }
        .total { font-size:16px; font-weight:bold; margin-top:12px; }
    </style>
</head>
<body>
    <h1>Distribuciones Santa S.L.</h1>
    <p>CIF B-00000000 · Polígono Norte, nave 25 · uso de laboratorio</p>

    <div class="box">
        <p><strong>Factura:</strong> {{ $factura->numero }}</p>
        <p><strong>Fecha:</strong> {{ optional($factura->created_at)->format('d/m/Y') }}</p>
        <p><strong>Cliente:</strong> #{{ $factura->user_id }}</p>
        <p><strong>Concepto:</strong> {{ $factura->concepto }}</p>
    </div>

    <p class="total">Total: {{ number_format($factura->importe, 2, ',', '.') }} €</p>
</body>
</html>
