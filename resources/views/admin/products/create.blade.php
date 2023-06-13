@extends('admin/layout')

@section('title', 'Create product')

@section('extra-scripts')
    <script>
        var page = 'products-create';
        var list = @json($listCategories);
    </script>

    @vite('resources/js/products.create.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="product-create-container">
            <form id="create-products-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-primary" id="add-product-create-form">+</button>
            <button class="btn btn-success" id="products-save">Save All</button>
        </div>
    </div>
@endsection
