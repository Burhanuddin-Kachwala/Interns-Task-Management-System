<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- summernote css --}}
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3.8.0/notyf.min.css">

    <title>Admin Module</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 text-gray-800 flex flex-col">

    <!-- Header -->
    <header class="bg-white shadow-md py-4 px-6 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600">
            <a href="{{ url('/admin') }}">Admin Dashboard</a>
        </h1>
        @auth
            <div class="flex items-center space-x-4">
                <span class="text-sm font-medium text-gray-600">Hello, {{ Auth::guard('admin')->user()->name ?? 'Admin User' }}</span>
                @can('chat')
                <a href="{{ route('admin.chat.index') }}" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">
                    Chat
                </a>
                @endcan
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="bg-indigo-500 text-white px-3 py-1 rounded hover:bg-indigo-600 text-sm" type="submit">Logout</button>
                </form>
            </div>
        @endauth
    </header>

    <!-- Main -->
    <main class="flex-grow container mx-auto px-4 py-8">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white text-center text-sm text-gray-500 py-4 shadow-inner">
        © {{ date('Y') }} Intern Tasks Management System. All rights reserved.
    </footer>
      <!-- Toastr JS -->
      <script src="https://cdn.jsdelivr.net/npm/notyf@3.8.0/notyf.min.js"></script>
    <!-- Summernote CSS and JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {            
            $('.summernote').summernote({
                // Set height of editor
                height: 200,               
            });
        });
    </script>
</body>
</html>
