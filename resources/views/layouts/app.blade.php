<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('includes.theme-init')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ $documentTitle ?? config('app.name', 'Laravel') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&display=swap" rel="stylesheet">
        <link rel="icon" type="image/png" href="{{ asset('ddmodelslogo.ico') }}" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="{{ asset('css/main.css') }}" rel="stylesheet">
        <link href="{{ asset('css/theme.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
        @stack('styles')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="site-wrapper">
            @include('includes.header')

            <aside class="sidebar-menu" id="mobileSidebar">
                <button class="sidebar-close" id="sidebarClose">&times;</button>
                @include('admin.includes.sidebar')
            </aside>

            <main class="site-main account-layout">
                <div class="layout-wrapper">
                    <div class="layout-container">
                        <div class="desktop-sidebar d-none d-md-block">
                            @include('admin.includes.sidebar')
                        </div>
                        <div class="layout-page" id="pageContent">
                            @yield('content')
                        </div>
                    </div>
                </div>
            </main>

            @include('includes.footer')

            <button type="button" id="scrollToTop" class="scroll-to-top">
                <i class="bi bi-arrow-up"></i>
            </button>
        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
        <script src="{{ asset('js/theme.js') }}"></script>
        <script src="{{ asset('js/menu.js') }}"></script>
        <script src="{{ asset('js/main.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebarToggle = document.getElementById('sidebarToggle');
                const sidebarClose = document.getElementById('sidebarClose');
                const mobileSidebar = document.getElementById('mobileSidebar');
                const pageContent = document.getElementById('pageContent');

                function openSidebar() {
                    mobileSidebar.classList.add('open');
                    document.body.classList.add('sidebar-open');
                    pageContent.classList.add('sidebar-open');
                }

                function closeSidebar() {
                    mobileSidebar.classList.remove('open');
                    document.body.classList.remove('sidebar-open');
                    pageContent.classList.remove('sidebar-open');
                }

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function(e) {
                        e.stopPropagation();
                        mobileSidebar.classList.contains('open') ? closeSidebar() : openSidebar();
                    });
                }

                if (sidebarClose) {
                    sidebarClose.addEventListener('click', function(e) {
                        e.stopPropagation();
                        closeSidebar();
                    });
                }

                document.addEventListener('click', function(e) {
                    if (mobileSidebar.classList.contains('open') &&
                        !mobileSidebar.contains(e.target) &&
                        e.target !== sidebarToggle) {
                        closeSidebar();
                    }
                });

                mobileSidebar.addEventListener('click', function(e) {
                    e.stopPropagation();
                });

                if (document.getElementById('languages')) {
                    $('#languages').select2({
                        placeholder: 'Choose languages',
                        allowClear: true,
                        closeOnSelect: false
                    });
                }

                const scrollBtn = document.getElementById('scrollToTop');
                if (scrollBtn) {
                    window.addEventListener('scroll', () => {
                        scrollBtn.style.display = window.scrollY > 200 ? 'flex' : 'none';
                    });
                    scrollBtn.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }
            });
        </script>
        @stack('scripts')
    </body>
</html>
