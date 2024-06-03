@extends('admin.layout')

@section('title', 'Add Course')

@section('content')
    <h1>Add Course</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Create Course
    </h1>
    <form action="{{ route('admin.storecourse') }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name" required="">
            @error('name')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
            <input type="number" name="price" id="price" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Price" required="">
            @error('price')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="detail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail</label>
            <input type="text" name="detail" id="detail" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Detail" required="">
            @error('detail')
            <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Confirm</button>
    </form>
@endsection
