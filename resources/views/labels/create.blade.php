
@extends('layouts.app')
@section('title', 'Создать метку')
@section('content')
{{ Form::model($label, ['route' => 'labels.store']) }}
    @include('labels.form')
    {{ Form::submit('Сохранить') }}
{{ Form::close() }}
@endsection