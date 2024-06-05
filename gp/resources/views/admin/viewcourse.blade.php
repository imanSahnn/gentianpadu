@extends('admin.layout')

@section('title', 'View course')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
        View course
    </h1>

    <div class="space-y-4 md:space-y-6">
        <div>
            <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
            <p id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $course->name }}
            </p>
        </div>
        <div>
            <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Price</label>
            <p id="price" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $course->price }}
            </p>
        </div>
        <div>
            <label for="detail" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Detail</label>
            <p id="detail" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                {{ $course->detail }}
            </p>
        </div>
        <div>
            <label for="skills" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Skills</label>
            <ul id="skills" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                @if($course->skills->isEmpty())
                    <li>No skills found for this course.</li>
                @else
                    @foreach ($course->skills as $skill)
                        <li>{{ $skill->skill_name }}</li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
@endsection
