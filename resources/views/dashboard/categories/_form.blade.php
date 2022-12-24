@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>
@endif

@csrf

<div class="row">
    <div class="col-md-8">
        <div class="mb-3">
            <x-form.input placeholder="Name..." class="form-control-lg" id="name" name="name" label="Category Name" :value="$category->name" />
        </div>

        <div class="mb-3">
            <x-form.input id="slug" name="slug" label="URL Slug" :value="$category->slug" />
        </div>
        <div class="mb-3">
            <x-form.select name="parent_id" id="parent_id" label="Parent" :value="$category->parent_id" :options="$parents" />
        </div>
        <div class="mb-3">
            <x-form.input type="file" id="image" name="image" label="Image" />
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
    <div class="col-md-4">
        <a href="{{ $category->image_url }}">
            <img class="img-fluid" src="{{ $category->image_url }}" alt="">
        </a>
    </div>
</div>