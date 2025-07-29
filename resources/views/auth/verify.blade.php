@extends('layouts.auth')

@section('title', 'Verify Code')

@section('content')
<!-- Card -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="p-4 sm:p-7">
        <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Enter Verification Code</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Enter the 6-digit code sent to <span class="font-medium">{{ $email }}</span>
            </p>
        </div>

        <div class="mt-5">
            <!-- Alert for error messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-4" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-red-400 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293 5.354 4.646z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm text-red-800">
                                @foreach ($errors->all() as $error)
                                    <p>{{ $error }}</p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('magic-link.verify') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                
                <div class="grid gap-y-4">
                    <!-- Verification Code Input -->
                    <div>
                        <label for="token" class="block text-sm mb-2 dark:text-white">Verification Code</label>
                        <div class="relative">
                            <input type="text" id="token" name="token" maxlength="6" required
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-center text-2xl tracking-widest font-mono focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" 
                                   placeholder="000000" pattern="[0-9]{6}" inputmode="numeric" 
                                   autocomplete="one-time-code" autofocus>
                            <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-gray-600 mt-2 dark:text-gray-400">
                            Code expires in 15 minutes
                        </p>
                    </div>
                    <!-- End Verification Code Input -->

                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                        <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                        Verify Code
                    </button>
                </div>
            </form>
            <!-- End Form -->

            <div class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-[1_1_0%] before:border-t before:border-gray-200 before:me-6 after:flex-[1_1_0%] after:border-t after:border-gray-200 after:ms-6 dark:text-gray-500 dark:before:border-gray-600 dark:after:border-gray-600">Need help?</div>

            <!-- Back to login link -->
            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                    ← Back to login
                </a>
            </div>

            <!-- Resend option -->
            <div class="text-center mt-3">
                <p class="text-xs text-gray-600 dark:text-gray-400">
                    Didn't receive the email? 
                    <a href="{{ route('login') }}?email={{ urlencode($email) }}" class="text-blue-600 decoration-2 hover:underline font-medium cursor-pointer">
                        Send a new code
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- End Card -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tokenInput = document.getElementById('token');
        
        // Auto-format the input to only allow numbers
        tokenInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) value = value.substr(0, 6);
            e.target.value = value;
            
            // Auto-submit when 6 digits are entered
            if (value.length === 6) {
                setTimeout(() => {
                    e.target.form.submit();
                }, 100);
            }
        });

        // Focus the input on page load
        tokenInput.focus();
        
        // Handle paste event
        tokenInput.addEventListener('paste', function(e) {
            e.preventDefault();
            let paste = (e.clipboardData || window.clipboardData).getData('text');
            let value = paste.replace(/\D/g, '').substr(0, 6);
            e.target.value = value;
            
            if (value.length === 6) {
                setTimeout(() => {
                    e.target.form.submit();
                }, 100);
            }
        });
    });
</script>
@endsection