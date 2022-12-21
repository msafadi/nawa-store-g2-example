@extends('layouts.dashboard')

@section('title', 'Edit Category')

@section('content')
    <form action="{{ route('dashboard.categories.update', $category->id) }}" method="post">
        @method('put')
        @include('dashboard.categories._form')
    </form>
@endsection