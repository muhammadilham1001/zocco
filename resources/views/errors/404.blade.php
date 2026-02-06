<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Zocco</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Poppins:wght@300;400;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .font-serif {
            font-family: 'Playfair Display', serif;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #020617;
        }

        .text-yellow-zocco {
            color: #ca8a04;
        }

        .bg-yellow-zocco {
            background-color: #ca8a04;
        }

        .glass-effect {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">
    <main class="w-full max-w-md">
        <div class="glass-effect rounded-[2.5rem] p-10 shadow-2xl text-center border-t border-white/10">
            <div class="mb-8">
                <h1 class="text-8xl font-serif text-yellow-zocco opacity-50">404</h1>
                <div class="relative -mt-12">
                    <i data-lucide="coffee" class="w-16 h-16 text-white mx-auto mb-4"></i>
                </div>
            </div>

            <h2 class="text-2xl font-serif text-white mb-4">Cangkir Kosong!</h2>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                Halaman yang Anda cari sudah habis atau mungkin tidak pernah ada di menu kami.
            </p>

            <a href="{{ url('/dashboard') }}"
                class="inline-block bg-yellow-zocco hover:bg-yellow-700 text-white px-8 py-4 rounded-xl font-bold text-xs uppercase tracking-[0.2em] transition-all transform active:scale-95 shadow-xl shadow-yellow-900/20">
                Kembali ke Beranda
            </a>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
