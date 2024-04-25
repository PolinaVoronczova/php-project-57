
@extends('layouts.app')
@section('title', 'Создать статус')
@section('content')
{{ Form::model($task_status, ['route' => 'task_statuses.store']) }}
    @include('task_statuses.form')
    {{ Form::submit('Сохранить') }}
{{ Form::close() }}
@endsection