@extends('cms::layouts.main')

@section('content')

<h1>Информация о сервере</h1>

<br>

<style>
	iframe{border: 0; width: 100%; height: 750px;}
</style>

<iframe src="{{ route('InfoPhpAdmin') }}"></iframe>

@stop