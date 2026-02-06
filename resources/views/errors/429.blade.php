<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terlalu Banyak Permintaan - Zocco</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@1,700&family=Poppins:wght@400;600&display=swap"
        rel="stylesheet">
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #020617;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-6 relative overflow-hidden">
    {{-- Efek Dekorasi --}}
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-yellow-600/10 rounded-full blur-[120px]"></div>

    <div class="glass-effect p-10 rounded-[2.5rem] max-w-md w-full text-center z-10 shadow-2xl">
        <h1 class="font-serif text-5xl text-yellow-600 italic mb-6">Sabar...</h1>
        <p class="text-white text-sm mb-8 leading-relaxed">
            Anda melakukan terlalu banyak percobaan. <br>
            Demi keamanan, silakan tunggu <span class="text-yellow-600 font-bold">1 menit</span> lagi sebelum mencoba
            kembali.
        </p>
        <a href="{{ url()->previous() }}"
            class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-8 py-3 rounded-xl font-bold text-xs uppercase tracking-widest transition-all">
            Kembali
        </a>
    </div>
</body>

</html>
