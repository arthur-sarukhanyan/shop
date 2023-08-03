<?php

namespace App\Observers;

use App\Facades\CategoryFacade;
use App\Models\Category as Model;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    public function created(Model $model): void
    {
        CategoryFacade::setCategoryPath($model->id);
        Cache::forget('categories-list');
    }

    public function updated(Model $model): void
    {
        CategoryFacade::setCategoryPath($model->id);
        Cache::forget('categories-list');
    }

    public function deleted(): void
    {
        Cache::forget('categories-list');
    }
}
