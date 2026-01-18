<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CityRequest;
use App\Http\Requests\CitiesRequest;
use App\Http\Requests\CountriesRequest;
use App\Models\City;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

/**
 * Class CitiesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CitiesCrudController extends CrudController
{

    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(City::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/cities');
        CRUD::setEntityNameStrings('cities', 'cities');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {

        CRUD::addColumn([
            'label' => 'City',
            'name' => 'name',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'label' => 'Country',
            'name' => 'country',
            'type' => 'relationship'
        ]);
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CitiesRequest::class);
        CRUD::addField([
            'label' => 'City name',
            'name' => 'name',
            'type' => 'text',
                'wrapper' =>[
                    'class'=>'form-group col-md-6',
                ],
        ]);
        CRUD::addField([
            'label' => 'Country',
            'name' => 'country',
            'type' => 'relationship',
            'wrapper' =>[
                'class'=>'form-group col-md-6',

            ],
        ]);

    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

         public function getCities()
        {
            $search = request('q');
            $countryId = request('country_id')
                ?? (request('form') ? request('main_fields')['country_id'] ?? null : null);

            $cities = City::when($countryId, fn($q) => $q->where('country_id', $countryId))
                ->when($search, fn($q) => $q->where('name', 'LIKE', "%{$search}%"))
                ->select('id', 'name', 'country_id')
                ->orderBy('name')
                ->orderBy('country_id')
                ->paginate(30);

            return response()->json($cities);
        }


}
