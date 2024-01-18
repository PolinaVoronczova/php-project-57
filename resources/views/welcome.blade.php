
@extends('layouts.app')
@section('title', __("Привет от Хекслета!"))
@section('content')
    <div class="mr-auto place-self-center lg:col-span-7">
        
        <p class="max-w-2xl mb-6 font-light text-gray-500 lg:mb-8 md:text-lg lg:text-xl dark:text-gray-400">
        {{ __("Это простой менеджер задач на Laravel") }}</p>
    </div>
@endsection