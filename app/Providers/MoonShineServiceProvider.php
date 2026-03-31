<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use MoonShine\Contracts\Core\DependencyInjection\CoreContract;
use MoonShine\Laravel\DependencyInjection\MoonShine;
use MoonShine\Laravel\DependencyInjection\MoonShineConfigurator;
use App\MoonShine\Resources\MoonShineUser\MoonShineUserResource;
use App\MoonShine\Resources\MoonShineUserRole\MoonShineUserRoleResource;
use App\MoonShine\Resources\User\UserResource;
use App\MoonShine\Resources\Post\PostResource;
use App\MoonShine\Resources\Hotel\HotelResource;
use App\MoonShine\Resources\Airport\AirportResource;
use App\MoonShine\Resources\Tour\TourResource;
use App\MoonShine\Resources\RoomTypes\RoomTypesResource;
use App\MoonShine\Resources\Nutrition\NutritionResource;
use App\MoonShine\Resources\Reviews\ReviewsResource;
use App\MoonShine\Resources\TourDeparture\TourDeparturesResource;
use App\MoonShine\Resources\HotelFeatures\HotelFeaturesResource;
use App\MoonShine\Resources\News\NewsResource;

class MoonShineServiceProvider extends ServiceProvider
{
    /**
     * @param  CoreContract<MoonShineConfigurator>  $core
     */
    public function boot(CoreContract $core): void
    {
        $core
            ->getConfig()->layout(\App\MoonShine\Layouts\MoonShineLayout::class);

        $core
            ->resources([
                MoonShineUserResource::class,
                MoonShineUserRoleResource::class,
                UserResource::class,
                PostResource::class,
                HotelResource::class,
                AirportResource::class,
                TourResource::class,
                RoomTypesResource::class,
                NutritionResource::class,
                ReviewsResource::class,
                TourDeparturesResource::class,
                HotelFeaturesResource::class,
                NewsResource::class,
            ])
            ->pages([
                ...$core->getConfig()->getPages(),
            ])
        ;
    }
}
