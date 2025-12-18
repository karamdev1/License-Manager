@extends('Layout.app')

@section('title', 'Login')

@section('content')
    <div class="w-full max-w-md bg-white dark:bg-dark rounded-xl shadow-lg p-6">
        <h1 class="text-2xl font-semibold text-dark dark:text-gray-300 mb-6 text-center">
            Login
        </h1>

        <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-secondary dark:text-gray-300 mb-1">Username</label>
                <input type="username" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <div class="mb-4">
                <label class="block text-sm text-secondary dark:text-gray-300 mb-1">Password</label>
                <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary">
            </div>

            <button type="submit" class="w-full py-2 bg-primary text-white rounded-lg hover:opacity-90 transition">
                Sign in
            </button>
        </form>
    </div>
@endsection