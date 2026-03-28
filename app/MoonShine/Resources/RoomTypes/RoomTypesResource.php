<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\RoomTypes;

use Illuminate\Database\Eloquent\Model;
use App\Models\RoomType;
use App\MoonShine\Resources\RoomTypes\Pages\RoomTypesIndexPage;
use App\MoonShine\Resources\RoomTypes\Pages\RoomTypesFormPage;
use App\MoonShine\Resources\RoomTypes\Pages\RoomTypesDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;

/**
 * @extends ModelResource<RoomType, RoomTypesIndexPage, RoomTypesFormPage, RoomTypesDetailPage>
 */
class RoomTypesResource extends ModelResource
{
    protected string $model = RoomType::class;

    protected string $title = 'RoomTypes';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            RoomTypesIndexPage::class,
            RoomTypesFormPage::class,
            RoomTypesDetailPage::class,
        ];
    }
}
