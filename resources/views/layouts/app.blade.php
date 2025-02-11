<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">
    <x-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show d-flex align-items-center m-2"
                    role="alert">
                    <i class="fa fa-check-circle me-2"></i>
                    <strong>Success: </strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show d-flex align-items-center m-2"
                    role="alert">
                    <i class="fa fa-exclamation-triangle me-2"></i>
                    <strong>Error: </strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (isset($slot))
                {{ $slot }}
            @else
                @yield('content')
            @endif
        </main>
    </div>

    @stack('modals')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll("input[required], select[required], textarea[required]").forEach(function(
                element) {
                let label = document.querySelector(`label[for='${element.id}']`);
                if (label && !label.querySelector(".required-asterisk")) {
                    let asterisk = document.createElement("span");
                    asterisk.innerHTML = " *";
                    asterisk.style.color = "red";
                    asterisk.classList.add("required-asterisk");
                    label.appendChild(asterisk);
                }
            });

            // Gray out readonly fields
            document.querySelectorAll("input[readonly], textarea[readonly], select[readonly]").forEach(function(
                element) {
                element.style.backgroundColor = "#e9ecef"; // Light gray background
                element.style.cursor = "not-allowed"; // Change cursor to indicate non-editable
                element.style.opacity = "0.8"; // Slight transparency to indicate disabled look
            });
        });
    </script>
    @livewireScripts
</body>

</html>
