<form action="{{ route('products.index') }}" method="GET">
    <div class="form-group">
        <label for="category_id">Select Category:</label>
        <select name="category_id" id="category_id" class="form-control">
            <option value="">All Categories</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Filter</button>
</form>

@foreach ($products as $product)
    <!-- Card markup -->
@endforeach
