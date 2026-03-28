<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\RoomTypes\Pages;

use App\Models\Hotel;
use App\Models\Nutrition;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\RoomTypes\RoomTypesResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Components\Layout\Column;
use MoonShine\UI\Components\Layout\Grid;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use MoonShine\UI\Fields\Switcher;
use MoonShine\UI\Fields\Text;
use Throwable;


/**
 * @extends FormPage<RoomTypesResource>
 */
class RoomTypesFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Grid::make([
                Column::make([
                    Text::make('Room Type', 'room_type')
                        ->required(),
                ])->columnSpan(6),

                Column::make([
                    Number::make('Price per person', 'price_per_person')
                        ->prefix('$')
                        ->buttons('+')
                        ->required(),
                ])->columnSpan(6),

                Column::make([
                    Number::make('max persons', 'max_persons'),
                ])->columnSpan(6),

                Column::make([
                    Select::make('hotel', 'hotel_id')
                        ->options([
                            Hotel::query()
                                ->pluck('name', 'id')
                                ->toArray()
                        ])
                        ->required()
                        ->nullable(),
                ])
                    ->columnSpan(6),
                Column::make([
                    Switcher::make('Base Room', 'is_base')
                        ->hint('Mark as base room type')
                ])->columnSpan(6),
            ])


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
        return [];
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
