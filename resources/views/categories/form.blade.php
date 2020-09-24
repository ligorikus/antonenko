@extends('layouts.app')
@section('content')
    <h1>{{ !isset($category) ? "Создать категорию" : "Обновить категорию"}}</h1>
    <category-form
        class="container"
        :category="{{$category ?? '{}'}}"
    ></category-form>
@endsection
