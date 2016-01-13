@extends('layouts.main')

@section('content')
	
	<h1>{{ $item->title }}</h1>
	
	<div>
		{{ $item->content }}
	</div>
@stop