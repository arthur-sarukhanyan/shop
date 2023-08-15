@extends('admin/layout')

@section('title', 'Edit filter group')

@section('extra-scripts')
    <script>
        var page = 'filter-groups-update';
        var item = @json($item);
    </script>

    @vite('resources/js/filter-groups/update.js')
@endsection

@section('content')
    <div class="col-md-9">

        <div id="filter-group-create-container">
            <form id="update-filter-group-form" enctype="multipart/form-data">
                @csrf
                {{--Form elements will be added dynamically by js--}}
            </form>

        </div>

        <div class="errors">

        </div>

        <div id="actions">
            <button class="btn btn-success" id="filter-group-save">Save</button>
        </div>
    </div>
@endsection
