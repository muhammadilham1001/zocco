<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Kesalahan Server | Zocco</title>
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
        <div class="glass-effect rounded-[2.5rem] p-10 shadow-2xl text-center border-t border-white/10 text-white">
            <div class="mb-8">
                <h1 class="text-8xl font-serif text-yellow-zocco opacity-50">500</h1>
                <div class="relative -mt-12">
                    <i data-lucide="alert-triangle" class="w-16 h-16 text-red-500 mx-auto mb-4"></i>
                </div>
            </div>

            <h2 class="text-2xl font-serif mb-4">Mesin Sedang Bermasalah</h2>
            <p class="text-gray-400 text-sm leading-relaxed mb-8">
                Terjadi kesalahan internal pada server kami. Barista kami sedang memperbaikinya, silakan coba lagi
                nanti.
            </p>

            <button onclick="window.location.reload()"
                class="w-full bg-white/5 hover:bg-white/10 border border-white/10 text-white py-4 rounded-xl font-bold text-xs uppercase tracking-[0.2em] transition-all mb-4">
                Muat Ulang Halaman
            </button>

            <a href="{{ url('/dashboard') }}"
                class="text-yellow-zocco text-[10px] font-bold uppercase tracking-widest hover:underline">
                Atau Kembali ke Beranda
            </a>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
