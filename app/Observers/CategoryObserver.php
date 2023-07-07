<?php

namespace App\Observers;

use App\Facades\CategoryFacade;
use App\Models\Category as Model;

class CategoryObserver
{
    public function created(Model $model): void
    {
        CategoryFacade::setCategoryPath($model->id);
    }

    public function updated(Model $model): void
    {
        CategoryFacade::setCategoryPath($model->id);
    }
}
