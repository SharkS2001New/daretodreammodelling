<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">

        <!-- Styles -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('fonts/iconify-icons.css') }}" rel="stylesheet">
        <!-- Select2 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('includes.header')
            
            <!-- Sidebar menu (for mobile) -->
            <aside class="sidebar-menu" id="mobileSidebar">
                <button class="sidebar-close" id="sidebarClose">&times;</button>
                @include('admin.includes.sidebar')
            </aside>

            <!-- Page Content -->
            <main>
                <div class="layout-wrapper">
                    <div class="layout-container">
                        <!-- Desktop sidebar (always visible on desktop) -->
                        <div class="desktop-sidebar d-none d-md-block">
                            @include('admin.includes.sidebar')
                        </div>

                        <!-- Layout container -->
                        <div class="layout-page" id="pageContent">
                            @yield('content')  
                        </div>
                    </div>
                </div>
            </main>

            @include('includes.footer')
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
        <script src="{{ asset('js/menu.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        <script>
            // Mobile sidebar functionality
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarClose = document.getElementById('sidebarClose');
                const mobileSidebar = document.getElementById('mobileSidebar');
                const pageContent = document.getElementById('pageContent');
                
                // Function to open sidebar
                function openSidebar() {
                    mobileSidebar.classList.add('open');
                    document.body.classList.add('sidebar-open');
                    pageContent.classList.add('sidebar-open');
                }
                
                // Function to close sidebar
                function closeSidebar() {
                    mobileSidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                    pageContent.classList.remove('sidebar-open');
                }
                
                // Toggle sidebar when hamburger is clicked
                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (mobileSidebar.classList.contains('open')) {
                            closeSidebar();
                        } else {
                            openSidebar();
                        }
                    });
                }
                
                // Close sidebar when close button is clicked
                if (sidebarClose) {
                    sidebarClose.addEventListener('click', function(e) {
                        e.stopPropagation();
                        closeSidebar();
                    });
                }
                
                // Close sidebar when clicking outside of it
                document.addEventListener('click', function(e) {
                    if (mobileSidebar.classList.contains('open') && 
                        !mobileSidebar.contains(e.target) && 
                        e.target !== sidebarToggle) {
                        closeSidebar();
                    }
                });
                
                // Prevent clicks inside sidebar from closing it
                mobileSidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                });
            });
        </script>
        <!-- jQuery + Select2 JS -->
        {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#languages').select2({
                    placeholder: "Choose languages",
                    allowClear: true,
                    closeOnSelect: false
                });
            });
        </script>

    </body>
</html>