<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FilterGroupObserver
{
    public function created(): void
    {
        Cache::forget('filter-groups-list');
    }

    public function updated(): void
    {
        Cache::forget('filter-groups-list');
    }

    public function deleted(): void
    {
        Cache::forget('filter-groups-list');
    }
}
