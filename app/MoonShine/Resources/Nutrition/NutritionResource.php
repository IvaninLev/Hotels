<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Nutrition;

use Illuminate\Database\Eloquent\Model;
use App\Models\Nutrition;
use App\MoonShine\Resources\Nutrition\Pages\NutritionIndexPage;
use App\MoonShine\Resources\Nutrition\Pages\NutritionFormPage;
use App\MoonShine\Resources\Nutrition\Pages\NutritionDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<Nutrition, NutritionIndexPage, NutritionFormPage, NutritionDetailPage>
 */
class NutritionResource extends ModelResource
{
    protected string $model = Nutrition::class;

    protected string $title = 'Nutrition';
    
    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            NutritionIndexPage::class,
            NutritionFormPage::class,
            NutritionDetailPage::class,
        ];
    }
}
