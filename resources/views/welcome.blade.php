@extends('layouts.app')
@section('content')
    <div class="container">
        <dashboard class="row"
            :categories="{{json_encode($categories)}}"
        ></dashboard>
    </div>
@endsection
