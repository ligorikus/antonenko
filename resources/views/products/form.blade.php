@extends('layouts.app')
@section('content')
    <h1>{{ !isset($product) ? "Создать продукт" : "Обновить продукт"}}</h1>
    <product-form
        class="container"
        :product="{{$product ?? 'null'}}"
        :categories="{{json_encode($categories)}}"
    ></product-form>
@endsection
