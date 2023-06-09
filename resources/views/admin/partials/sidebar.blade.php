<div class="col-auto col-md-2 px-0 min-vh-100">
    <div class="d-flex flex-column align-items-center align-items-sm-start pt-2 text-white bg-dark sidebar">
        <ul class="nav flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            @if(auth()->user()->level === 1)
                <li class="nav-item">
                    <a href="{{route('users-list')}}" class="nav-link align-middle px-0">
                        <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="{{route('filter-groups-list')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Filter Groups</span>
                </a>
            </li>
                <li>
                    <a href="{{route('filters-list')}}" class="nav-link px-0 align-middle">
                        <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Filters</span>
                    </a>
                </li>
            <li class="nav-item">
                <a href="{{route('products-list')}}" class="nav-link align-middle px-0">
                    <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Products</span>
                </a>
            </li>
            <li>
                <a href="{{route('categories-list')}}" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline">Categories</span> </a>
            </li>
        </ul>
        <hr>
    </div>
</div>
