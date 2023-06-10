<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            @if(auth()->user()->level === 1)
                <li class="nav-item">
                    <a href="{{route('users-list')}}" class="nav-link align-middle px-0">
                        <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Users</span>
                    </a>
                </li>
            @endif
            <li>
                <a href="#" class="nav-link px-0 align-middle">
                    <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Orders</span></a>
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
