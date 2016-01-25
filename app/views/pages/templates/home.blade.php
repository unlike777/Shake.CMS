@extends('layouts.main')

@section('content')
	
	<h1 style="position: fixed; top: 50%; left: 0; width: 100%;  margin-top: -46px; font-size: 28px; font-weight: lighter; font-family: Arial, sans-serif; text-transform: uppercase; letter-spacing: 5px; text-align: center;">
		Shake.CMS<br>{{ $item->title }}
	</h1>
	
	<div style="display: none;">
		{{ $item->content }}
	</div>
@stop
