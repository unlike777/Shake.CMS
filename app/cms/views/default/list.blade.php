@extends('cms::layouts.main')

@section('content')

<h1>{{ mb_ucfirst($decls['section'], 'utf-8') }} → Список {{ $decls['many'] }}</h1>

<br>

<a class="btn btn-default" href="{{ route($module.'CreateAdmin') }}">Создать</a>
<br><br>

{{ $table->html() }}

<div class="clear"></div>
<a class="btn btn-default" href="{{ route($module.'CreateAdmin') }}">Создать</a>

@stop
