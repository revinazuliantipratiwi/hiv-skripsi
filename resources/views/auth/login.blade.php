@extends('layouts.login')

@section('content')
<div class="bg-white shadow-xl rounded-xl w-full max-w-md p-8 space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold text-red-600">Peta Sebaran HIV</h2>
        <p class="text-gray-600 mt-2">Silakan login untuk melanjutkan</p>
    </div>

    {{-- ALERT JIKA LOGIN GAGAL --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Login gagal!</strong>
            <span class="block sm:inline"> Email atau kata sandi tidak sesuai.</span>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" required
                   class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-red-600 text-white py-2 rounded-lg hover:bg-red-700 transition">
                Masuk
            </button>
        </div>

        <div>
            <a href="{{ route('index') }}"
               class="w-full inline-block text-center bg-gray-200 text-gray-700 py-2 mt-2 rounded-lg hover:bg-gray-300 transition">
                Kembali
            </a>
        </div>
    </form>
</div>
@endsection
