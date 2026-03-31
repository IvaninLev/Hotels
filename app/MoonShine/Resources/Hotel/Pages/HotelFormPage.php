<?php


namespace App\MoonShine\Resources\Hotel\Pages;

use App\Models\City;
use App\Models\Country;
use App\Models\RoomType;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\Hotel\HotelResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Image;
use MoonShine\UI\Fields\Json;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Position;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Textarea;
use PHPUnit\Framework\Constraint\Count;
use Throwable;
use function Laravel\Prompts\search;


/**
 * @extends FormPage<HotelResource>
 */
class HotelFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make('id'),

            Text::make('Name', 'name')
                ->required(),


            Text::make('Rating', 'rating')
                ->required()
                ->mask('9.9'),


            Image::make('Images', 'images')
                ->multiple()
                ->disk('public')
                ->dir('hotels')
                ->allowedExtensions(['jpg', 'png', 'jpeg', 'gif']),

            Text::make('Address', 'address')
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







            Textarea::make('Description', 'description')
                ->required(),


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
