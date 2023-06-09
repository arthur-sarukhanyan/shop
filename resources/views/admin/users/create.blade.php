@extends('admin/layout')

@section('title', 'Create user')

@section('extra-scripts')
    <script>
        var page = 'users-create';
    </script>
@endsection

@section('content')
    <div class="col-md-9">

        <div id="product-create-container">
            <form id="create-products-form">
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
