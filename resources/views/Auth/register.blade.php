@extends('Layout.app')

@section('title', 'Register')

@section('content')
    <main class="flex-1 flex items-center justify-center transition-colors duration-300">
        <div class="w-full max-w-md bg-dark rounded-xl shadow-lg p-6">
            <h1 class="text-2xl font-semibold text-gray-300 mb-6 text-center">
                Register
            </h1>

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div class="mb-4">
                    <label class="block text-md text-gray-300 mb-1">Username</label>
                    <input 
                        type="username" 
                        id="username" 
                        name="username" 
                        class="w-full px-4 py-2 pr-10 border border-dark-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-300 bg-dark-4"
                        placeholder="Enter your username"
                    />
                </div>

                <div class="mb-4">
                    <label class="block text-md text-gray-300 mb-1">Password</label>
                    <div class="relative w-full">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="w-full px-4 py-2 pr-10 border border-dark-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-300 bg-dark-4"
                            placeholder="Enter your password"
                        />

                        <button 
                            type="button" 
                            id="togglePassword"
                            class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-md text-gray-300 mb-1">Confirm Password</label>
                    <div class="relative w-full">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            class="w-full px-4 py-2 pr-10 border border-dark-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-300 bg-dark-4"
                            placeholder="Enter your password again"
                        />

                        <button 
                            type="button" 
                            id="togglePasswordConfirmation"
                            class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="block text-md text-gray-300 mb-1">Referrable Code</label>
                    <div class="relative w-full">
                        <input 
                            type="password" 
                            id="reff" 
                            name="reff" 
                            class="w-full px-4 py-2 pr-10 border border-dark-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary text-gray-300 bg-dark-4"
                            placeholder="Enter your referrable code"
                        />

                        <button 
                            type="button" 
                            id="toggleReff"
                            class="absolute inset-y-0 right-2 flex items-center text-gray-400 hover:text-gray-200"
                        >
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="mb-4">
                    <button type="submit" 
                        class="w-auto p-3 bg-transparent border border-dark-3 hover:bg-secondary
                            text-gray-300 rounded-lg transition-colors duration-100">
                        <i class="bi bi-box-arrow-in-right"></i> Register
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-gray-300">
                        Already have an account? <a href="{{ route('login') }}" class="text-white underline">Login here</a>.
                    </p>
                </div>
            </form>
        </div>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const reffInput = document.getElementById('reff');
        const togglePassword = document.getElementById('togglePassword');
        const togglePasswordConfirm = document.getElementById('togglePasswordConfirmation');
        const toggleReff = document.getElementById('toggleReff');
        const eyeIcon = togglePassword.querySelector('i');
        const eyeIcon2 = togglePasswordConfirm.querySelector('i');
        const eyeIcon3 = toggleReff.querySelector('i');

        togglePassword.addEventListener('click', () => {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');
            }
        });

        togglePasswordConfirm.addEventListener('click', () => {
            if (passwordConfirmInput.type === 'password') {
                passwordConfirmInput.type = 'text';
                eyeIcon2.classList.remove('bi-eye');
                eyeIcon2.classList.add('bi-eye-slash');
            } else {
                passwordConfirmInput.type = 'password';
                eyeIcon2.classList.remove('bi-eye-slash');
                eyeIcon2.classList.add('bi-eye');
            }
        });

        toggleReff.addEventListener('click', () => {
            if (reffInput.type === 'password') {
                reffInput.type = 'text';
                eyeIcon3.classList.remove('bi-eye');
                eyeIcon3.classList.add('bi-eye-slash');
            } else {
                reffInput.type = 'password';
                eyeIcon3.classList.remove('bi-eye-slash');
                eyeIcon3.classList.add('bi-eye');
            }
        });
    </script>
@endsection