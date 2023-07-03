<!-- create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Product</h1>
        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{$product->name}}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <input type="text" name="description" id="description" class="form-control" value="{{$product->description}}">
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="number" name="price" id="price" class="form-control" value="{{$product->price}}">
            </div>
            <div class="form-group">
                <label for="quantity">quantity</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="{{$product->quantity}}">
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="images">Images</label>
                <input type="file" name="images" id="images" class="form-control" multiple>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Create Product</button>
        </form>
    </div>
@endsection
