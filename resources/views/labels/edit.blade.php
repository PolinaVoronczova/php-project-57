@extends('layouts.app')
@section('title', 'Изменить метку')
@section('content')
{{ Form::model($label, ['route' => ['labels.update', $label], 'method' => 'PATCH']) }}
    @include('labels.form')
    {{ Form::submit('Обновить') }}
{{ Form::close() }}
@endsection