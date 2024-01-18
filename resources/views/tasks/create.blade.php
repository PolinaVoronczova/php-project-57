
@extends('layouts.app')

@section('content')
{{ Form::model($task, ['route' => 'tasks.store', $task]) }}
    @include('tasks.form')
    {{ Form::submit('Сохранить') }}
{{ Form::close() }}
@endsection