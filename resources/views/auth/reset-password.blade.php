@extends('layouts.auth')
@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div class="mb-4">
            <label for="email" class="block text-gray-700">Email</label>
            <input id="email" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
            @error('email')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input id="password" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password">
            @error('password')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-gray-700">Confirm Password</label>
            <input id="password_confirmation" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Reset Password</button>
    </form>
@endsection
