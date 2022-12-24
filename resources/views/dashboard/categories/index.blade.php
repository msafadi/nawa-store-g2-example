@extends('layouts.dashboard')

@section('title', 'Categories')

@section('content')

<x-flash-message />

<div class="mb-4">
    <a href="{{ route('dashboard.categories.create') }}" class="btn btn-outline-primary">
        <i class="fas fa-plus"></i> Add New</a>
    <a href="{{ route('dashboard.categories.trash') }}" class="btn btn-outline-dark">
        <i class="fas fa-trash"></i> View Trash</a>
</div>

<form action="{{ URL::current() }}" method="get" class="d-flex mb-5">
    <div class="">
        <x-form.input name="search" id="search" :value="request('search')" placeholder="Search..." />
    </div>
    <div class="ml-2">
        <x-form.select name="p" id="p" :value="request('p')" :options="$parents" />
    </div>
    <div class="ml-2">
        <button type="submit" class="btn btn-dark">Find</button>
    </div>
</form>

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Parent</th>
            <th>Created At</th>
            <th>Updated At</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
        <tr>
            <td><img class="img-fluid" src="{{ $category->image_url }}" width="80" alt=""></td>
            <td><strong>{{ $category->name }}</strong><br>
            <span class="text-muted">{{ $category->slug }}</span></td>
            <td>{{ $category->parent_name }}</td>
            <td>{{ $category->created_at }}</td>
            <td>{{ $category->updated_at ?? 'No updates' }}</td>
            <td><a href="{{ route('dashboard.categories.edit', $category->id) }}" class="btn btn-sm btn-outline-primary">
                <i class="fas fa-edit"></i> Edit
            </a></td>
            <td>
                <form action="{{ route('dashboard.categories.destroy', $category->id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection