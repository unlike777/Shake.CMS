@extends('cms::layouts.main')

@section('content')

<h1>Информация о сервере</h1>

<br>

<style>
	iframe{border: 0; width: 100%; height: 750px;}
</style>

<iframe id="iframe" src="{{ route('infoPhpAdmin') }}" scrolling="no">></iframe>

<script>
	$('#iframe').load(function() {
		var $iframe = $(this);
		var $iframe_body = $iframe.contents().find('body');
		$iframe.height($iframe_body[0].scrollHeight);
	});
</script>

@stop