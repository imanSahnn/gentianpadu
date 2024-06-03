@extends('admin.layout')

@section('title', 'View Tutor')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        View Tutor
    </h1>

    <div class="space-y-4 md:space-y-6">
        <div class="flex justify-center">
            <div class="w-2 h-2 overflow-hidden border border-gray-30 rounded-full">
                @if ($tutor->picture)
                    <img src="{{ asset('storage/' . $tutor->picture) }}" alt="Profile Picture" class="w-full h-full object-cover">
                @else
                    <p class="text-gray-500 dark:text-gray-400 flex items-center justify-center w-full h-full bg-gray-200 dark:bg-gray-800">No picture available</p>
                @endif
            </div>
        </div>
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <p id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $tutor->name }}
            </p>
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
            <p id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $tutor->email }}
            </p>
        </div>
        <div>
            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">IC</label>
            <p id="ic" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $tutor->ic }}
            </p>
        </div>
        <div>
            <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
            <p id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $tutor->number }}
            </p>
        </div>
    </div>
@endsection
