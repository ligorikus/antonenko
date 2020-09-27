@extends('layouts.app')

@section('content')
    <h1>{{$product->name}}</h1>
    <h7>{{$product->description}}</h7>
    @foreach ($product->category_options as $option)
        <div>
            {{$option->title}}: {{$option->pivot->value}}
        </div>
    @endforeach
    <a href="/" class="btn btn-primary">Назад</a>
@endsection
