@php
    $type = 'products';
@endphp

@extends('admin/layout')

@section('title', 'Products')

@section('extra-scripts')
    @vite('resources/js/products/delete.js')
@endsection

@section('content')
    <div class="col-md-10">
        <div id="actions">
            <a class="btn btn-success" href="{{route('products-create')}}">Add</a>
        </div>
        <table class="table table-dark">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Image</th>
                <th scope="col">Name <input type="text" class="form-control" id="filters-name" name="filters-name" data-type="LIKE"></th>
                <th scope="col">Description <input type="text" class="form-control" id="filters-description" name="filters-description" data-type="LIKE"></th>
                <th scope="col">Price  <input type="text" class="form-control" id="filters-price" name="filters-price"></th>
                <th scope="col">Created </th>
                <th scope="col">Updated </th>
                <th scope="col"><a class="btn btn-primary list-filter">Filter</a></th>
            </tr>
            </thead>
            <tbody>
            @foreach($list as $item)
                <tr>
                    <th scope="row" class="align-middle">{{$item->id}}</th>
                    <td>
                        <div class="img-container">
                            <img src="{{$item->image ? $item->image->path : '/images/no-image.jpg'}}" alt="">
                        </div>
                    </td>
                    <td class="align-middle">{{$item->name}}</td>
                    <td class="align-middle">{{$item->description}}</td>
                    <td class="align-middle">{{$item->price}}</td>
                    <td class="align-middle">{{$item->created_at}}</td>
                    <td class="align-middle">{{$item->updated_at}}</td>
                    <td class="align-middle">
                        <a href="{{route('products-update', $item->id)}}" class="edit actions">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"></path>
                            </svg>
                        </a>
                        <a class="delete actions" data-id="{{$item->id}}" data-name="{{$item->name}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                            </svg>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @include('admin.partials.pagination')
    </div>
@endsection

@include('admin.partials.delete-modal')
