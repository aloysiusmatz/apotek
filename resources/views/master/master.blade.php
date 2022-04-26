@extends('layouts.app')

@section('body')
    
    {{-- SIDEBAR --}}
    @include("master.sidebar")
    {{-- END SIDEBAR --}}

    {{-- SIDEBAR --}}
    @include("master.mobile-sidebar")
    {{-- END SIDEBAR --}}

    <div class="page-content h-screen overflow-auto  z-0">
        
        @yield('content')
    </div>
@endsection