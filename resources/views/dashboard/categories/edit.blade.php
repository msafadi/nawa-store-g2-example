@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
        @method('put')
        @include('dashboard.categories._form')
    </form>
@endsection