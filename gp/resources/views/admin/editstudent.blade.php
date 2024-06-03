@extends('admin.layout')

@section('title', 'Edit student')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        Edit student
    </h1>
    <form action="{{ route('admin.supdate', $student->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4 md:space-y-6">
        @csrf
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your name</label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name" required="">
            @error('name')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your email</label>
            <input type="email" name="email" value="{{ old('email', $student->email) }}" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required="">
            @error('email')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="ic" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your IC</label>
            <input type="text" name="ic" value="{{ old('ic', $student->ic) }}" id="ic" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="020700012033" required="">
            @error('ic')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="number" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your phone number</label>
            <input type="text" name="number" value="{{ old('number', $student->number) }}" id="number" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="01139144048" required="">
            @error('number')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="course" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Course</label>
            <select name="course" id="course" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" required="">
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course', $student->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>
            @error('course')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="picture" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profile Picture</label>
            <input type="file" name="picture" id="picture" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            @error('picture')
                <span class="text-red-600">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Update student</button>
    </form>
@endsection
