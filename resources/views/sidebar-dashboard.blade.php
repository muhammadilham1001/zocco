<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Zocco Coffee - Dashboard Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .dark-mode {
            background-color: #1a202c;
            color: #e2e8f0;
        }

        .dark-mode .bg-white {
            background-color: #2d3748;
            color: #e2e8f0;
        }

        .dark-mode .bg-gray-100 {
            background-color: #1a202c;
        }

        .dark-mode .bg-gray-200 {
            background-color: #2d3748;
        }

        .dark-mode .border-gray-200 {
            border-color: #4a5568;
        }

        .dark-mode .text-gray-500 {
            color: #a0aec0;
        }

        .dark-mode .text-gray-700 {
            color: #cbd5e0;
        }

        .dark-mode .text-gray-900 {
            color: #e2e8f0;
        }

        .active-link {
            background-color: #fefcbf;
            color: #ca8a04;
        }

        .dark-mode .active-link {
            background-color: #4a5568;
            color: #fcd34d;
        }
    </style>
</head>

<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-500 ease-in-out font-poppins">
    <div class="flex h-screen">
        @include('SidebarDashboard')

        <main id="main-content" class="flex-1 p-8 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const body = document.body;
            const themeToggleSidebar = document.getElementById('theme-toggle-sidebar');
            const moonIconSidebar = document.getElementById('moon-icon-sidebar');
            const sunIconSidebar = document.getElementById('sun-icon-sidebar');
            const navLinks = document.querySelectorAll('.nav-link');

            // Logika tema
            const toggleIcon = () => {
                if (body.classList.contains('dark-mode')) {
                    moonIconSidebar.classList.add('hidden');
                    sunIconSidebar.classList.remove('hidden');
                } else {
                    moonIconSidebar.classList.remove('hidden');
                    sunIconSidebar.classList.add('hidden');
                }
            };

            const toggleTheme = () => {
                body.classList.toggle('dark-mode');
                localStorage.setItem('theme', body.classList.contains('dark-mode') ? 'dark' : 'light');
                toggleIcon();
            };

            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                body.classList.add('dark-mode');
            }
            toggleIcon();

            themeToggleSidebar.addEventListener('click', toggleTheme);

            // Logika untuk mengaktifkan link di sidebar
            const activeLink = document.querySelector(`.nav-link[href="${window.location.pathname}"]`);
            if (activeLink) {
                activeLink.classList.add('active-link');
            }
        });
    </script>

    @yield('scripts')
</body>

</html>
