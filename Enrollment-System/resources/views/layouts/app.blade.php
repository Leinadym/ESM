<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('images/logos/logo.png') }}" type="image/png">
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('styles/layouts/app.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('styles')
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar">
        <a href="/" class="navbar-logo">
            <img src="{{ asset('images/logos/logo.png') }}" alt="Logo">
            <span class="navbar-text">SRSHS Enrollment System</span>
        </a>

        <div class="navbar-links">
            @if (Auth::check())
                <!-- Check if the user is authenticated -->
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log Out</a>

                <!-- Include a form to handle logout -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <a href="{{ route('login') }}">Log In</a>
            @endif
        </div>
    </nav>



    <!-- Sidebar -->
    @auth()
        <div class="sidebar">
            <div class="logo">
                <img src="{{ asset('images/logos/admin-logo.png') }}" alt="Logo">
                <h3>
                    Admin
                    @auth
                        {{ Auth::user()->first_name }} {{ Auth::user()->name ?? 'Admin' }}
                    @endauth
                </h3>
            </div>
            <div class="menu">
                <a href="{{ route('dashboard') }}">Dashboard</a>
                <a href="{{ route('class-schedules.index') }}">Class Schedules</a>
                <a href="{{ route('enrollments.create') }}">Enrollments</a>
                <a href="{{ route('instructors.index') }}">Teachers</a>
                <a href="{{ route('subjects.index') }}">Subjects</a>
                <a href="{{ route('students.index') }}">Students</a>
            </div>
        </div>
    @endauth

    <!-- Main Content -->
    <main>
        @yield('main-content')
    </main>


    <!-- Modals -->
    @if (session('success'))
        <div id="successModal" class="modal" style="display: none;">
            <div class="modal-content">
                <h2>Success</h2>
                <p>{{ session('success') }}</p>
                <button onclick="closeModal('successModal')">Close</button>
            </div>
        </div>
    @endif

    @if (session('failed'))
        <div id="failedModal" class="modal">
            <div class="modal-content">
                <h2>Error</h2>
                @if (is_array(session('failed')))
                    <ul>
                        @foreach (session('failed') as $field => $errors)
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        @endforeach
                    </ul>
                @endif
                <button onclick="closeModal('failedModal')">Close</button>
            </div>
        </div>
    @endif


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const successModal = document.getElementById('successModal');
            const failedModal = document.getElementById('failedModal');

            if (successModal) successModal.style.display = 'flex'; // Show success modal
            if (failedModal) failedModal.style.display = 'flex'; // Show failed modal
        });

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) modal.style.display = 'none';
        }
    </script>
    @yield('scripts')
</body>

</html>
