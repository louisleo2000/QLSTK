<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head-style')
    @livewireStyles
</head>

<body class="">
    @include('layouts.dashboard.navbar')
    <div class="main-content">
        <!-- Navbar -->
        @include('layouts.dashboard.top-nav')
        
        <!-- End Navbar -->
        <!-- Header -->
        <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
            {{-- @include('layouts.dashboard.header') --}}
            <livewire:top-nav />
        </div>
        <div class="container-fluid mt--7">
            @yield('content')
            
            @include('layouts.dashboard.footer')
        </div>
        
    </div>

    @livewireScripts
</body>

@include('layouts.script-app')

</html>
