@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="form-group">
            <label for="category">Category</label>
            <input type="text" class="form-control" id="category" name="category" value="{{ old('category') }}" required>
        </div>

        <div class="form-group">
            <label for="starting_price">Starting Price (BDT)</label>
            <input type="text" class="form-control" id="starting_price" name="starting_price" value="{{ old('starting_price') }}" required>
        </div>

        <div class="form-group">
            <label for="images">Images</label>
            <input type="file" class="form-control-file" id="images" name="images[]" multiple>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="status" name="status" required>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Sold</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Product</button>
    </form>
</div>
@endsection