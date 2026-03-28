<?php

declare(strict_types=1);

namespace App\MoonShine\Layouts;

use App\MoonShine\Resources\Hotel\HotelResource;
use MoonShine\Laravel\Layouts\AppLayout;
use MoonShine\ColorManager\Palettes\PurplePalette;
use MoonShine\ColorManager\ColorManager;
use MoonShine\Contracts\ColorManager\ColorManagerContract;
use MoonShine\Contracts\ColorManager\PaletteContract;
use App\MoonShine\Resources\Airport\AirportResource;
use MoonShine\MenuManager\MenuItem;
use App\MoonShine\Resources\Tour\TourResource;
use App\MoonShine\Resources\RoomTypes\RoomTypesResource;
use App\MoonShine\Resources\Nutrition\NutritionResource;
use App\MoonShine\Resources\Reviews\ReviewsResource;
use App\MoonShine\Resources\DeparturePoint\DeparturesResource;
use App\MoonShine\Resources\TourDeparture\TourDeparturesResource;
use App\MoonShine\Resources\HotelFeatures\HotelFeaturesResource;
use App\MoonShine\Resources\News\NewsResource;

final class MoonShineLayout extends AppLayout
{
    /**
     * @var null|class-string<PaletteContract>
     */
    protected ?string $palette = PurplePalette::class;

    protected function assets(): array
    {
        return [
            ...parent::assets(),
        ];
    }

    protected function menu(): array
    {
        return [
            ...parent::menu(),
            MenuItem::make(AirportResource::class, 'Airports'),
            MenuItem::make(HotelResource::class, 'Hotels'),
            MenuItem::make(TourResource::class, 'Tours'),
            MenuItem::make(RoomTypesResource::class, 'RoomTypes'),
            MenuItem::make(NutritionResource::class, 'Nutrition'),
            MenuItem::make(ReviewsResource::class, 'Reviews'),
            MenuItem::make(TourDeparturesResource::class, 'TourDepartures'),
            MenuItem::make(HotelFeaturesResource::class, 'HotelFeatures'),
            MenuItem::make(NewsResource::class, 'News'),
        ];
    }

    /**
     * @param ColorManager $colorManager
     */
    protected function colors(ColorManagerContract $colorManager): void
    {
        parent::colors($colorManager);

        // $colorManager->primary('#00000');
    }
}
