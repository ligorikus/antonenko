@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{route('products.create')}}" class="btn btn-primary">Создать продукт</a>
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Название</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>
                        <form action="{{route('products.destroy', compact('product'))}}" method="post" class="form-group row">
                            @method('delete')
                            @csrf
                            <a href="{{route('products.edit', compact('product'))}}" class="btn btn-warning col-md-2">Обновить</a>
                            <input type="submit" class="btn btn-danger col-md-2" value="Удалить">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
