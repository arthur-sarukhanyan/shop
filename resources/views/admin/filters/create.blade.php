@extends('admin/layout')

@section('title', 'Create filter')

@section('extra-scripts')
    <script>
        var page = 'filters-create';
        var list = @json($list);
    </script>

    @vite('resources/js/filters/create.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="filter-create-container">
            <form id="create-filters-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-primary" id="add-filter-create-form">+</button>
            <button class="btn btn-success" id="filters-save">Save All</button>
        </div>
    </div>
@endsection
