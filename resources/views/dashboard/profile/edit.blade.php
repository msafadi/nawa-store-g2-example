@extends('layouts.dashboard')

@section('content')

<form action="{{ route('dashboard.profile.edit') }}" method="post">
    @csrf
    @method('patch')

    <x-flash-message />
    
    <div class="row g-5">
        <div class="col-6">
            <x-form.input name="first_name" id="first_name" label="First Name" :value="$user->profile->first_name" />
        </div>
        <div class="col-6">
            <x-form.input name="last_name" id="last_name" label="Last Name" :value="$user->profile->last_name" />
        </div>
        <div class="col-6">
            <x-form.input type="date" name="birthday" id="birthday" label="Birthday" :value="$user->profile->birthday" />
        </div>
        <div class="col-6">
            <x-form.select name="gender" id="gender" label="Gender" :value="$user->profile->gender" :options="['male' => 'Male', 'female' => 'Female']" />
        </div>
        <div class="col-6">
            <x-form.select name="country" id="country" label="Country" :value="$user->profile->country" :options="$countries" />
        </div>
        
    </div>
    <button type="submit" class="btn btn-primary">Save</button>

</form>

@endsection