import "./bootstrap";
import Alpine from "alpinejs";
import ScrollReveal from "scrollreveal";

// Inisialisasi Alpine
window.Alpine = Alpine;
Alpine.start();

// Inisialisasi ScrollReveal
const sr = ScrollReveal({
    distance: "20px",
    duration: 800,
    easing: "ease-out",
});

sr.reveal(".reveal", { interval: 200 });

document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const themeToggleSidebar = document.getElementById("theme-toggle-sidebar");
    const moonIconSidebar = document.getElementById("moon-icon-sidebar");
    const sunIconSidebar = document.getElementById("sun-icon-sidebar");
    const navLinks = document.querySelectorAll(".nav-link");
    const mainContent = document.getElementById("main-content");

    // Function untuk memuat konten dinamis
    const loadContent = async (targetFile) => {
        try {
            const response = await fetch(targetFile);
            const html = await response.text();
            mainContent.innerHTML = html;

            // Re-attach scripts jika ada di dalam konten yang dimuat
            const scripts = mainContent.querySelectorAll("script");
            scripts.forEach((script) => {
                const newScript = document.createElement("script");
                newScript.textContent = script.textContent;
                document.head
                    .appendChild(newScript)
                    .parentNode.removeChild(newScript);
            });
        } catch (error) {
            console.error("Error loading content:", error);
            mainContent.innerHTML =
                '<p class="text-center text-red-500">Gagal memuat konten. Silakan coba lagi.</p>';
        }
    };

    // Atur event listener untuk setiap link navigasi
    navLinks.forEach((link) => {
        link.addEventListener("click", (e) => {
            e.preventDefault();
            const targetFile = link.getAttribute("data-target");

            // Atur class aktif
            navLinks.forEach((l) => l.classList.remove("active-link"));
            link.classList.add("active-link");

            // Muat konten yang sesuai
            loadContent(targetFile);
        });
    });

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
        localStorage.setItem(
            "theme",
            body.classList.contains("dark-mode") ? "dark" : "light"
        );
        toggleIcon();
    };

    const savedTheme = localStorage.getItem("theme");
    if (savedTheme === "dark") {
        body.classList.add("dark-mode");
    }
    toggleIcon();

    themeToggleSidebar.addEventListener("click", toggleTheme);

    // Muat konten dashboard secara default saat halaman dimuat pertama kali
    // loadContent('dashboard.html');
});
