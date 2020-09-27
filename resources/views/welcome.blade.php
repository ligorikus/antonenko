@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <dashboard class="col"
                :categories="{{json_encode($categories)}}"
            ></dashboard>
        </div>
    </div>
@endsection
