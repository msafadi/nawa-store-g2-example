@props([
    'id', 'name', 'options', 'value' => '', 'label' => ''
])

@if($label)
<label for="{{ $id }}" class="form-label">{{ $label }}</label>
@endif
<select name="{{ $name }}" 
       id="{{ $id }}" 
       {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
       >
    <option value=""></option>
    @foreach ($options as $option_value => $option_text)
    <option value="{{ $option_value }}" @selected($option_value == old($name, $value)) >{{ $option_text }}</option>
    @endforeach
</select>
<x-form.error :name="$name" />