<?php

namespace App\Listeners;

use App\Events\CategorySyncEvent;
use App\Facades\ProductCategoryFacade;

class CategorySyncListener
{
    /**
     * Handle the event.
     */
    public function handle(CategorySyncEvent $event): void
    {
        $entity = $event->getEntity();
        ProductCategoryFacade::setCategoryPath($entity->id);
    }
}
