<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\Tour\Pages;

use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\Airport;
use App\Models\Nutrition;
use App\Models\RoomType;
use App\Models\TourDeparture;
use Illuminate\Database\Eloquent\Model;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Tour\TourResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use MoonShine\UI\Fields\Date;
use Throwable;


/**
 * @extends FormPage<TourResource>
 */
class TourFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                Text::make('Name', 'name')
                    ->required(),

                Textarea::make('Description', 'description')
                    ->required(),

                Image::make('Images', 'images')
                    ->multiple()
                    ->disk('public')
                    ->dir('tours')
                    ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

                Date::make('Active from', 'active_from')
                    ->withTime()
                    ->required(),

                Date::make('Active to', 'active_to')
                    ->withTime()
                    ->required(),

                Select::make('Hotel', 'hotel_id')
                    ->options(\App\Models\Hotel::pluck('name', 'id')->toArray())
                    ->searchable()
                    ->required(),

                Number::make('Base price', 'base_price')
                    ->prefix('$')
                    ->buttons('-')
                    ->required(),

                Number::make('Persons', 'persons')
                    ->min(1)
                    ->required(),

                Select::make('Country', 'country_id')
                    ->options(
                        Country::query()
                            ->pluck('name', 'id')
                            ->toArray()
                    )
                    ->required()
                    ->nullable()
                    ->searchable()
                    ->reactive(),


                Select::make('City', 'city_id')
                    ->options(function () {
                        $countryId = request()->input('values.country_id');

                        if (!$countryId) {
                            return [];
                        }

                        return City::query()
                            ->where('country_id', $countryId)
                            ->pluck('name', 'id')
                            ->toArray();
                    })
                    ->searchable()
                    ->nullable()
                    ->reactive(),

            ]),

        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }

    protected function formButtons(): ListOf
    {
        return parent::formButtons();
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
        ];
    }

    /**
     * @param FormBuilder $component
     *
     * @return FormBuilder
     */
    protected function modifyFormComponent(FormBuilderContract $component): FormBuilderContract
    {
        return $component;
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function topLayer(): array
    {
        return [
            ...parent::topLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function mainLayer(): array
    {
        return [
            ...parent::mainLayer()
        ];
    }

    /**
     * @return list<ComponentContract>
     * @throws Throwable
     */
    protected function bottomLayer(): array
    {
        return [
            ...parent::bottomLayer()
        ];
    }
}
