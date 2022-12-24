@extends('layouts.dashboard')

@section('title', 'Add Category')

@section('content')
    <form action="{{ route('dashboard.categories.store') }}" method="post" enctype="multipart/form-data">
        @include('dashboard.categories._form')
    </form>
@endsection