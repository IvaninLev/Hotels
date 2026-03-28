<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\TourDeparture;

use App\Models\TourDeparture;
use Illuminate\Database\Eloquent\Model;
use App\MoonShine\Resources\TourDeparture\Pages\TourDeparturesIndexPage;
use App\MoonShine\Resources\TourDeparture\Pages\TourDeparturesFormPage;
use App\MoonShine\Resources\TourDeparture\Pages\TourDeparturesDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<TourDeparture, TourDeparturesIndexPage, TourDeparturesFormPage, TourDeparturesDetailPage>
 */
class TourDeparturesResource extends ModelResource
{
    protected string $model = TourDeparture::class;

    protected string $title = 'TourDepartures';

    /**'required|exists:tours,id'
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            TourDeparturesIndexPage::class,
            TourDeparturesFormPage::class,
            TourDeparturesDetailPage::class,
        ];
    }
}
