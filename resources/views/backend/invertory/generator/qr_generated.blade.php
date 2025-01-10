<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>QR Codes</title>
    <style>
        @page {
            size: 108mm 108mm; /* Размер для принтера Proton */
            margin: 20px; /* Без полей */
        }
        body {
            margin-left: 38px;
            margin-right: 38px;
            justify-content: center;
            align-items: center;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        .qr-code {
            width: 78mm; /* Ширина QR-кода 54 мм */
            height: 78mm; /* Высота QR-кода 54 мм */
        }
    </style>
</head>
<body>
@foreach ($products as $product)
    <div>
        <img class="qr-code" src="data:image/png;base64,{{ $product->qr_code_base64 }}" alt="QR Code">
        <p style="text-align: center !important; font-size: 20px !important">{{ $product->inv_number }}</p>
    </div>
@endforeach
</body>
</html>
