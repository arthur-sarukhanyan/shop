<?php

namespace App\Observers;

use Illuminate\Support\Facades\Cache;

class FilterObserver
{
    public function created(): void
    {
        Cache::forget('filters-list');
    }

    public function updated(): void
    {
        Cache::forget('filters-list');
    }

    public function deleted(): void
    {
        Cache::forget('filters-list');
    }
}
