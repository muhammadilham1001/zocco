    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
                    const body = document.body;
                    const themeToggleSidebar = document.getElementById("theme-toggle-sidebar");
                    const moonIconSidebar = document.getElementById("moon-icon-sidebar");
                    const sunIconSidebar = document.getElementById("sun-icon-sidebar");
                    const navLinks = document.querySelectorAll(".nav-link");
                    const mainContent = document.getElementById("main-content");

                    // Tombol dan view reservasi
                    const showListBtn = document.getElementById("show-list");
                    const showFormBtn = document.getElementById("show-form");
                    const reservationListView = document.getElementById("reservation-list-view");
                    const reservationFormView = document.getElementById("reservation-form-view");
                    const outletFilter = document.getElementById("outlet-filter");
                    const reservationsTableBody = document.getElementById("reservations-table-body");

                    // Data dummy reservasi
                    const dummyReservations = [{
                            id: '#R001',
                            name: 'Rizky Pratama',
                            outlet: 'zocco_elpico',
                            datetime: '25/09/2025, 19:00',
                            guests: 4,
                            status: 'Menunggu'
                        },
                        {
                            id: '#R002',
                            name: 'Siti Aminah',
                            outlet: 'zoccosulfat',
                            datetime: '25/09/2025, 20:30',
                            guests: 2,
                            status: 'Dikonfirmasi'
                        },
                        {
                            id: '#R003',
                            name: 'Budi Santoso',
                            outlet: 'zocco_heritage',
                            datetime: '26/09/2025, 12:00',
                            guests: 6,
                            status: 'Menunggu'
                        },
                        {
                            id: '#R004',
                            name: 'Dewi Lestari',
                            outlet: 'zocco_elpico',
                            datetime: '26/09/2025, 14:00',
                            guests: 3,
                            status: 'Dikonfirmasi'
                        },
                        {
                            id: '#R005',
                            name: 'Joko Susilo',
                            outlet: 'madbaker',
                            datetime: '27/09/2025, 10:00',
                            guests: 2,
                            status: 'Menunggu'
                        },
                        {
                            id: '#R006',
                            name: 'Fina Puspita',
                            outlet: 'zoccosulfat',
                            datetime: '27/09/2025, 18:00',
                            guests: 5,
                            status: 'Dibatalkan'
                        },
                        {
                            id: '#R007',
                            name: 'Agung Wicaksono',
                            outlet: 'zocco_elpico',
                            datetime: '28/09/2025, 11:30',
                            guests: 4,
                            status: 'Dikonfirmasi'
                        },
                    ];

                    // Render tabel reservasi
                    const renderReservations = (filter) => {
                        if (!reservationsTableBody) return;
                        reservationsTableBody.innerHTML = "";

                        const filtered = dummyReservations.filter(res => filter === "all" || res.outlet === filter);

                        filtered.forEach(res => {
                            const row = document.createElement("tr");
                            const statusColor = {
                                "Menunggu": "bg-yellow-100 text-yellow-800",
                                "Dikonfirmasi": "bg-green-100 text-green-800",
                                "Dibatalkan": "bg-red-100 text-red-800"
                            } [res.status] || "bg-gray-100 text-gray-800";

                            const outletName = {
                                "zocco_elpico": "Zocco Elpico",
                                "zoccosulfat": "Zocco Sulfat",
                                "zocco_heritage": "Zocco Heritage",
                                "madbaker": "Madbaker"
                            } [res.outlet] || res.outlet;

                            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">${res.id}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${res.name}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${outletName}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${res.datetime}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${res.guests} orang</td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${statusColor}">${res.status}</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <button class="text-green-600 hover:text-green-900">Konfirmasi</button>
                    <button class="ml-4 text-red-600 hover:text-red-900">Batal</button>
                </td>
            `;
                            reservationsTableBody.appendChild(row);
                        });
                    };

                    // Event tombol list / form
                    if (showListBtn && showFormBtn) {
                        showListBtn.addEventListener("click", () => {
                            reservationListView.classList.remove("hidden");
                            reservationFormView.classList.add("hidden");
                            renderReservations(outletFilter.value);
                        });
                        showFormBtn.addEventListener("click", () => {
                            reservationListView.classList.add("hidden");
                            reservationFormView.classList.remove("hidden");
                        });
                    }

                    // Event filter outlet
                    if (outletFilter) {
                        outletFilter.addEventListener("change", (e) => {
                            renderReservations(e.target.value);
                        });
                    }

                    // Navigasi sidebar
                    navLinks.forEach(link => {

                        // Logika tema
                        const toggleIcon = () => {
                            if (body.classList.contains("dark-mode")) {
                                moonIconSidebar.classList.add("hidden");
                                sunIconSidebar.classList.remove("hidden");
                            } else {
                                moonIconSidebar.classList.remove("hidden");
                                sunIconSidebar.classList.add("hidden");
                            }
                        };
                        const toggleTheme = () => {
                            body.classList.toggle("dark-mode");
                            localStorage.setItem("theme", body.classList.contains("dark-mode") ? "dark" :
                                "light");
                            toggleIcon();
                        };
                        const savedTheme = localStorage.getItem("theme");
                        if (savedTheme === "dark") body.classList.add("dark-mode");
                        toggleIcon();
                        themeToggleSidebar.addEventListener("click", toggleTheme);

                        // Load default
                        renderReservations("all");
                    });
    </script>
