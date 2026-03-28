<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Airport;

use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\MoonShine\Resources\Airport\Pages\AirportIndexPage;
use App\MoonShine\Resources\Airport\Pages\AirportFormPage;
use App\MoonShine\Resources\Airport\Pages\AirportDetailPage;

use MoonShine\Laravel\Fields\Relationships\BelongsTo;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Number;

/**
 * @extends ModelResource<Airport, AirportIndexPage, AirportFormPage, AirportDetailPage>
 */
class AirportResource extends ModelResource
{
    protected string $model = Airport::class;

    protected string $title = 'Airports';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            AirportIndexPage::class,
            AirportFormPage::class,
            AirportDetailPage::class,
        ];
    }

    public function fields(): array
    {
        return [
            Text::make('Airport', 'airport_name'),
            BelongsTo::make('City', 'city'),
            \MoonShine\UI\Fields\Number::make('Price diff', 'price_diff'),
        ];
    }
}
