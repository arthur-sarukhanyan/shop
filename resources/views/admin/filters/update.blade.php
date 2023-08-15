@extends('admin/layout')

@section('title', 'Edit filter')

@section('extra-scripts')
    <script>
        var page = 'filters-update';
        var list = @json($list);
        var item = @json($item);
    </script>

    @vite('resources/js/filters/update.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="filter-create-container">
            <form id="update-filter-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-success" id="filter-save">Save</button>
        </div>
    </div>
@endsection
