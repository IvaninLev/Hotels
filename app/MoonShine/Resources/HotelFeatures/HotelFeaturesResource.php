<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\HotelFeatures;

use App\Models\HotelFeature;
use Illuminate\Database\Eloquent\Model;
use App\Models\HotelFeatures;
use App\MoonShine\Resources\HotelFeatures\Pages\HotelFeaturesIndexPage;
use App\MoonShine\Resources\HotelFeatures\Pages\HotelFeaturesFormPage;
use App\MoonShine\Resources\HotelFeatures\Pages\HotelFeaturesDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<HotelFeature, HotelFeaturesIndexPage, HotelFeaturesFormPage, HotelFeaturesDetailPage>
 */
class HotelFeaturesResource extends ModelResource
{
    protected string $model = HotelFeature::class;

    protected string $title = 'HotelFeatures';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            HotelFeaturesIndexPage::class,
            HotelFeaturesFormPage::class,
            HotelFeaturesDetailPage::class,
        ];
    }
}
