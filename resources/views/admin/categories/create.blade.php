@extends('admin/layout')

@section('title', 'Create category')

@section('extra-scripts')
    <script>
        var page = 'categories-create';
        var list = @json($list);
    </script>

    @vite('resources/js/categories.create.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="category-create-container">
            <form id="create-categories-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-primary" id="add-category-create-form">+</button>
            <button class="btn btn-success" id="categories-save">Save All</button>
        </div>
    </div>
@endsection
