<!DOCTYPE html>
<html lang="id">
<head>
    @include('dosen.partials.start')
</head>
<body class="bg-light">
    @include('dosen.partials.header')
    @include('dosen.partials.sidebar')

    <!-- Main Content Area -->
    <div class="main-content" style="margin-left: 0; transition: margin-left 0.3s ease;">
        <main class="container-fluid" style="padding-top: 5rem; padding-left: 1.5rem; padding-right: 1.5rem;">
            @yield('container')
        </main>
    </div>

    @include('sweetalert::alert')
    @stack('scripts')

    <!-- JavaScript untuk Sidebar Toggle -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebarClose = document.getElementById('sidebar-close');
            const sidebarOverlay = document.getElementById('sidebar-overlay');
            const mainContent = document.querySelector('.main-content');

            // Fungsi untuk toggle sidebar mobile
            function toggleSidebar() {
                if (sidebar && sidebarOverlay) {
                    sidebar.classList.add('show');
                    sidebarOverlay.classList.remove('d-none');
                }
            }

            // Fungsi untuk close sidebar
            function closeSidebar() {
                if (sidebar && sidebarOverlay) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.add('d-none');
                }
            }

            // Event listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarClose) {
                sidebarClose.addEventListener('click', closeSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Fungsi untuk adjust layout berdasarkan ukuran layar
            function adjustLayout() {
                if (!mainContent || !sidebar) return;

                if (window.innerWidth >= 992) { // lg breakpoint
                    sidebar.classList.remove('show');
                    if (sidebarOverlay) {
                        sidebarOverlay.classList.add('d-none');
                    }
                } else {
                    sidebar.classList.remove('show');
                }
            }

            // Initial adjustment dan resize listener
            adjustLayout();
            window.addEventListener('resize', adjustLayout);
        });
    </script>

    @include('dosen.partials.end')

