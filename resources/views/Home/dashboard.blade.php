@extends('Layout.app')

@section('title', 'Dashboard')

@section('content')
    <div class="flex min-h-screen">
        <aside class="w-64 bg-white shadow-md p-4 hidden md:flex flex-col">
            @include('Layout.sidebar')
        </aside>

        <div x-show="sidebarOpen" x-transition x-cloak class="fixed inset-0 z-50 flex md:hidden">
            <aside class="relative bg-white h-full w-full shadow-md p-4 flex flex-col">
                <button @click="sidebarOpen = false" class="mb-4 p-2 rounded hover:bg-gray-100 self-end">
                    <i class="bi bi-x-lg text-lg"></i>
                </button>

                @include('Layout.sidebar')
            </aside>
        </div>

        <main class="flex-1 p-6">
            <div x-show="activePage==='home'">
                home
            </div>

            <div x-show="activePage==='licenses'">
                licenses
            </div>

            <div x-show="activePage==='users'">
                users
            </div>

            <div x-show="activePage==='settings'">
                settings
            </div>
        </main>
    </div>
@endsection