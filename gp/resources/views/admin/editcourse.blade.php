@extends('admin.layout')

@section('title', 'Edit course')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Edit course
    </h1>
    <form action="{{ route('admin.cupdate', $course->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
            <input type="text" name="name" value="{{ old('name', $course->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name" required="">
            @error('name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
            <input type="number" name="price" value="{{ old('price', $course->price) }}" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
            @error('number')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="detail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail</label>
            <input type="text" name="detail" value="{{ old('detail', $course->detail) }}" id="detail" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="020700012033" required="">
            @error('detail')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
    </form>
@endsection
