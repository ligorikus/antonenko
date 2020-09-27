@extends('layouts.app')
@section('content')
    <h1>{{ !isset($product) ? "Создать товар" : "Обновить товар"}}</h1>
    <product-form
        class="container"
        :product="{{$product ?? 'null'}}"
        :categories="{{json_encode($categories)}}"
    ></product-form>
@endsection
