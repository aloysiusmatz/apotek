@extends('layouts.app')

@section('body')
    <div class="flex">
        {{-- SIDEBAR --}}
        @include("developer.sidebar")
        {{-- END SIDEBAR --}}

        {{-- PAGES --}}
        {{-- @yield('content') --}}
        @livewire('companies-view')
        {{-- END PAGES --}}
    </div>
@endsection