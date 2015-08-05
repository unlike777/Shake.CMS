@extends('cms::layouts.main')

@section('content')

<h1>Пользователи → Список пользователей</h1>

<br>

<a class="btn btn-default" href="{{ route($module.'CreateAdmin') }}">Создать</a>
<br><br>

<?

$table = new ShakeTable($model);

$table->setModule($module);
$table->add('email', 'Эл. почта', 0);
$table->add('created_at', 'Дата регистрации', 0, function($val, $obj) {
	return Date::parse($val)->format('j mm Y H:i:s'); 
});
$table->add('updated_at', 'Дата обновления', 0, function($val, $obj) {
	return Date::parse($val)->format('j mm Y H:i:s');
});
	
echo $table->html();

?>



<div class="clear"></div>
<a class="btn btn-default" href="{{ route($module.'CreateAdmin') }}">Создать</a>

@stop