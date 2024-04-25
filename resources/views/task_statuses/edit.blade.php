@extends('layouts.app')
@section('title', __("Изменить статус"))
@section('content')
{{ Form::model($task_status, ['route' => ['task_statuses.update', $task_status], 'method' => 'PATCH']) }}
    @include('task_statuses.form')
    {{ Form::submit(__("Обновить")) }}
{{ Form::close() }}
@endsection