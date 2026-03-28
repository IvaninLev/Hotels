<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\TourDeparture\Pages;

use App\Models\Airport;
use App\Models\Tour;
use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FormBuilderContract;
use MoonShine\UI\Components\FormBuilder;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use App\MoonShine\Resources\TourDeparture\TourDeparturesResource;
use MoonShine\Support\ListOf;
use MoonShine\UI\Fields\Date;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Components\Layout\Box;
use MoonShine\UI\Fields\Number;
use MoonShine\UI\Fields\Select;
use Throwable;


/**
 * @extends FormPage<TourDeparturesResource>
 */
class TourDeparturesFormPage extends FormPage
{
    /**
     * @return list<ComponentContract|FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Box::make([
                ID::make(),

                Select::make('Tour', 'tour_id')
                    ->options(\App\Models\Tour::pluck('name', 'id')->toArray())
                    ->required(),

                Select::make('Airport', 'airport_id')
                    ->options(
                        Airport::query()
                            ->with('city.country')
                            ->get()
                            ->mapWithKeys(function ($airport) {
                                $label = $airport->airport_name;
                                if ($airport->city && $airport->city->country) {
                                    $label .= " ({$airport->city->name}, {$airport->city->country->name})";
                                } elseif ($airport->city) {
                                    $label .= " ({$airport->city->name})";
                                }
                                return [$airport->id => $label];
                            })
                            ->toArray()
                    )
                    ->nullable()
                    ->required(),

                Date::make('Departure date', 'departure_date')
                    ->withTime()
                    ->required(),

                Number::make('Extra price', 'extra_price')
                    ->prefix('$')
                    ->buttons('-')
                    ->required(),
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
