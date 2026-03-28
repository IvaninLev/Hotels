<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;
use App\MoonShine\Resources\Tour\Pages\TourIndexPage;
use App\MoonShine\Resources\Tour\Pages\TourFormPage;
use App\MoonShine\Resources\Tour\Pages\TourDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Tour, TourIndexPage, TourFormPage, TourDetailPage>
 */
class TourResource extends ModelResource
{
    protected string $model = Tour::class;

    protected string $title = 'Tours';
    
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TourIndexPage::class,
            TourFormPage::class,
            TourDetailPage::class,
        ];
    }
}
