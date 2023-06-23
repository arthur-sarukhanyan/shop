@extends('admin/layout')

@section('title', 'Create category')

@section('extra-scripts')
    <script>
        var page = 'categories-update';
        var list = @json($list);
        var item = @json($item);
    </script>

    @vite('resources/js/categories/update.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="category-create-container">
            <form id="update-category-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-success" id="category-save">Save</button>
        </div>
    </div>
@endsection
