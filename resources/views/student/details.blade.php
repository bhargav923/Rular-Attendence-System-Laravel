<!DOCTYPE html>
<html lang="gu">
<head>
    <meta charset="UTF-8">
    <title>વિદ્યાર્થી વિગતો</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

<div class="bg-white p-6 rounded shadow max-w-md mx-auto">
    <h2 class="text-2xl font-bold mb-4">{{ $student->name }} ની વિગતો</h2>

    <p><strong>કક્ષા:</strong> {{ $student->class }}</p>
    <p><strong>ડિવિઝન:</strong> {{ $student->division }}</p>
    <p><strong>ઉંમર:</strong> {{ $student->age }}</p>
    <p><strong>આધાર:</strong> {{ $student->aadhar }}</p>
    <p><strong>ગામ:</strong> {{ $student->village }}</p>
    <p><strong>જન્મતારીખ:</strong> {{ $student->dob }}</p>
    \
    <div class="mt-4">
        <h3 class="font-bold mb-2">QR Code</h3>
        {!! $qr !!}
    </div>

    <button onclick="window.print()" class="mt-4 bg-green-600 text-white py-2 px-4 rounded hover:bg-green-700">Print QR</button>
</div>

</body>
</html>
