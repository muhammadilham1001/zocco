<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - Zocco</title>
    <link rel="icon" type="image/png" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
        }

        .bg-slate-dark {
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

        .input-zocco {
            background: #0f172a;
            border: 1px solid #1e293b;
            color: white;
            transition: all 0.3s ease;
        }

        .input-zocco:focus {
            border-color: #ca8a04;
            box-shadow: 0 0 0 2px rgba(202, 138, 4, 0.2);
            outline: none;
        }
    </style>
</head>

<body class="bg-slate-dark flex items-center justify-center min-h-screen p-4 relative overflow-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-yellow-600/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-blue-600/5 rounded-full blur-[120px]"></div>

    <main
        class="w-full max-w-4xl glass-effect rounded-[2.5rem] overflow-hidden shadow-2xl flex flex-col md:flex-row min-h-[550px] z-10">
        {{-- Sisi Kiri --}}
        <div
            class="hidden md:flex md:w-1/2 relative items-center justify-center p-12 overflow-hidden border-r border-white/5">
            <img src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?q=80&w=800"
                class="absolute inset-0 w-full h-full object-cover opacity-40" alt="Coffee Background">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>

            <div class="relative z-10 text-center">
                <div
                    class="w-32 h-32 rounded-2xl flex items-center justify-center mb-2 mx-auto shadow-lg rotate-3 overflow-hidden">
                    <img src="{{ asset('icon.png') }}" alt="Logo Zocco" class="w-28 h-28 object-contain">
                </div>

                <h2 class="font-serif text-4xl text-white mb-4 italic uppercase tracking-tighter">Zocco Coffee.</h2>
                <p class="text-gray-400 text-sm font-light italic tracking-wide">
                    "Satu langkah lagi untuk memulihkan akun Anda."
                </p>
            </div>
        </div>

        {{-- Sisi Kanan --}}
        <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-slate-900/50">
            <div class="mb-10">
                <h1 class="font-serif text-3xl text-white italic mb-2">Verifikasi OTP</h1>
                <p class="text-gray-400 text-xs uppercase tracking-[0.2em]">Masukkan kode 6 digit dari email Anda</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-500 text-xs italic">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('password.verify.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label
                        class="block text-[10px] font-bold uppercase tracking-widest text-yellow-zocco mb-2 text-center">Kode
                        Verifikasi</label>
                    <input type="text" name="otp" maxlength="6" required
                        class="input-zocco w-full px-4 py-4 rounded-xl text-center text-3xl tracking-[0.5em] font-bold text-white placeholder-gray-700"
                        placeholder="000000">
                </div>

                <button type="submit"
                    class="bg-yellow-zocco hover:bg-yellow-700 text-white w-full py-4 rounded-xl font-bold text-xs uppercase tracking-[0.2em] transition-all transform active:scale-95 shadow-xl shadow-yellow-900/20">
                    Verifikasi Kode
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-[10px] text-gray-500 font-bold uppercase tracking-widest">
                    Tidak menerima kode?
                    <a href="{{ route('password.request') }}" class="text-yellow-zocco hover:underline">Kirim Ulang</a>
                </p>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
