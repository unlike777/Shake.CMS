@extends('layouts.main')

@section('content')
	<div style="background: #808080;">
		<h1>{{ $item->title }}</h1>
    	
    	<div>
    		{{ $item->content }}
    	</div>
	</div>
@stop