@extends('admin/layout')

@section('title', 'Edit product')

@section('extra-scripts')
    <script>
        var page = 'products-edit';
        var list = @json($listCategories);
        var item = @json($item);
    </script>

    @vite('resources/js/products/update.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="product-create-container">
            <form id="update-product-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>
        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-success" id="product-save">Save</button>
        </div>
    </div>
@endsection
