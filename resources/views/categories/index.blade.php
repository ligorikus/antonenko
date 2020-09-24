@extends('layouts.app')
@section('content')
    <div class="container">
        <a href="{{route('categories.create')}}" class="btn btn-primary">Создать категорию</a>
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Название</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $category)
                <tr>
                    <td>{{$category->id}}</td>
                    <td>{{$category->name}}</td>
                    <td>
                        <form action="{{route('categories.destroy', compact('category'))}}" method="post" class="form-group row">
                            @method('delete')
                            @csrf
                            <a href="{{route('categories.edit', compact('category'))}}" class="btn btn-warning col-md-2">Обновить</a>
                            <input type="submit" class="btn btn-danger col-md-2" value="Удалить">
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@endsection
