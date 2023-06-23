@if($pagination['total'] > 1)
    <div>
        <nav aria-label="...">
            <ul class="pagination">
                @if ($pagination['current'] !== 1)
                    <li class="page-item">
                        <a class="page-link list-pagination" data-page="1" aria-label="First">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link list-pagination" data-page="{{$pagination['previous']}}" aria-label="Previous">
                            <span aria-hidden="true">&lt;</span>
                        </a>
                    </li>
                @endif

                @for($i = 0; $i < $pagination['total']; $i++)
                    <li class="page-item">
                        <a class="page-link list-pagination" data-page="{{$i + 1}}">{{$i + 1}}</a>
                    </li>
                @endfor

                @if ($pagination['current'] !== $pagination['total'])
                    <li class="page-item">
                        <a class="page-link list-pagination" data-page="{{$pagination['next']}}" aria-label="Next">
                            <span aria-hidden="true">&gt;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link list-pagination" data-page={{$pagination['total']}} aria-label="Last">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
@endif

