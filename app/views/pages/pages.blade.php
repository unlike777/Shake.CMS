@extends('layouts.main')

@section('content')
	
	@foreach(Page::all() as $item)
	
		<a href="{{ $item->url() }}">{{ $item->title }}</a> <br>
	
	@endforeach
	
@stop