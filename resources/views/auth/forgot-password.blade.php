@extends('layouts.auth')
@section('content')
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input id="email" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Email Password Reset Link</button>
    </form>
@endsection
