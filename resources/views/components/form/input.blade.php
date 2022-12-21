@props([
    'id', 'name', 'type' => 'text', 'value' => '', 'label' => ''
])

@if($label)
<label for="{{ $id }}" class="form-label">{{ $label }}</label>
@endif
<input type="{{ $type }}" 
       name="{{ $name }}" 
       id="{{ $id }}" 
       value="{{ old($name, $value) }}"
       {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
       >
<x-form.error :name="$name" />