<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Hotel;

use Illuminate\Database\Eloquent\Model;
use App\Models\Hotel;
use App\MoonShine\Resources\Hotel\Pages\HotelIndexPage;
use App\MoonShine\Resources\Hotel\Pages\HotelFormPage;
use App\MoonShine\Resources\Hotel\Pages\HotelDetailPage;

use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Select;


/**
 * @extends ModelResource<Hotel, HotelIndexPage, HotelFormPage, HotelDetailPage>
 */
class HotelResource extends ModelResource
{
    protected string $model = Hotel::class;

    protected string $title = 'Hotels';

    /**
     * @return list<class-string<PageContract>>
     */
    protected function pages(): array
    {
        return [
            HotelIndexPage::class,
            HotelFormPage::class,
            HotelDetailPage::class,
        ];
    }

    public function fields(): array
    {
        return [
            ID::make(),
            Text::make('Name')
                ->required(),
            Textarea::make('Description')
                ->required(),
        ];
    }
}
