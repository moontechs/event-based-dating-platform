@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
<!-- Card -->
<div class="bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-gray-800 dark:border-gray-700">
    <div class="p-4 sm:p-7">
        <div class="text-center">
            <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Sign in</h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                Enter your email to receive a login code
            </p>
        </div>

        <div class="mt-5">
            <!-- Alert for success messages -->
            @if (session('status'))
                <div class="bg-teal-50 border border-teal-200 rounded-md p-4 mb-4" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-4 w-4 text-teal-400 mt-0.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.061L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-teal-800">
                                {{ session('status') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

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
            <form action="{{ route('magic-link.send') }}" method="POST">
                @csrf
                <div class="grid gap-y-4">
                    <!-- Form Group -->
                    <div>
                        <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
                        <div class="relative">
                            <input type="email" id="email" name="email" 
                                   class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-slate-900 dark:border-gray-700 dark:text-gray-400 dark:focus:ring-gray-600" 
                                   required aria-describedby="email-error" placeholder="Enter your email"
                                   value="{{ old('email', request('email')) }}" autofocus>
                            <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                                <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                    <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <!-- End Form Group -->

                    <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600 cursor-pointer">
                        Send Login Code
                    </button>
                </div>
            </form>
            <!-- End Form -->

            <!-- Help text -->
            <div class="text-center mt-4">
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    You'll receive an email with a 6-digit code and a login button
                </p>
            </div>
        </div>
    </div>
</div>
<!-- End Card -->
@endsection