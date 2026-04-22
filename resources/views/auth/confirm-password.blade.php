@extends('layouts.auth')
@section('content')
    <div class="mb-4 text-sm text-gray-600">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>
    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="mb-4">
            <label for="password" class="block text-gray-700">Password</label>
            <input id="password" class="mt-1 block w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="current-password">
            @error('password')<div class="text-red-600 text-sm mt-2">{{ $message }}</div>@enderror
        </div>
        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700 transition">Confirm</button>
    </form>
@endsection
