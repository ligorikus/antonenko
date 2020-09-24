@extends('layouts.app')
@section('content')
    <h1>{{ !isset($product) ? "Создать продукт" : "Обновить продукт"}}</h1>
    <product-form
        class="container"
        :category="{{$product ?? '{}'}}"
    ></product-form>
@endsection
