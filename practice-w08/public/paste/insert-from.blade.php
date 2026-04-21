@extends('base.base')
 
@section('content')
    <h1>Insert New Product</h1>
    <form action="" class="row g-3"  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-md-6">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name">
        </div>
        <div class="col-md-6">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price">
        </div>
        <div class="col-12">
            <label for="details" class="form-label">Product Details</label>
            <input type="text" class="form-control" id="details" name="details" placeholder="Input product details here...">
        </div>
        <div class="col-md-6">
            <label for="product_category" class="form-label">Product Category</label>
            <select id="product_category" name="product_category" class="form-select">
              <option selected>Choose...</option>
            </select>
        </div>
        <div class="col-md-6">
            <label for="stock" class="form-label">Initial Stock</label>
            <input type="number" class="form-control" id="stock" name="stock">
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Product Image (jpg, jpeg, png)</label>
            <input type="file" class="form-control" id="image" name="image" accept=".jpg,.jpeg,.png">
        </div>
        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Add Product</button>
        </div>
    </form>
@endsection