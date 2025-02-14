<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>QR Codes</title>
    <style>
        @page {
            size: 600mm 600mm; /* Размер для принтера Proton */
        }
        body {
            justify-content: center;
            align-items: center;
            height: 100%;
            font-family: Arial, sans-serif;
        }
        .qr-code {
            margin-top: 10mm;
            width: 390mm; /* Ширина QR-кода */
            height: 390mm; /* Высота QR-кода */
        }
    </style>
</head>
<body>
    @foreach ($products as $product)
        <div style="text-align: center !important">
            <img class="qr-code" src="data:image/png;base64,{{ $product->qr_code_base64 }}" alt="QR Code">
            <p style="font-size: 200px !important; font-weight: bolder">{{ $product->inv_number }}</p>
        </div>
    @endforeach
</body>
</html>
