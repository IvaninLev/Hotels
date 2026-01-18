<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CountriesRequest;
use App\Models\City;
use App\Models\Country;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class CountriesCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CountriesCrudController extends CrudController
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
        CRUD::setModel(Country::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/countries');
        CRUD::setEntityNameStrings('countries', 'countries');
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
            'label' => 'Country',
            'name' => 'name',
            'type' => 'text'
        ]);
        CRUD::addColumn([
            'label' => 'ISO code',
            'name' => 'iso_code',
            'type' => 'text'
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
        CRUD::setValidation(CountriesRequest::class);
        CRUD::addField([
            'label' => 'Country name',
            'name' => 'name',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',

            ],
        ]);
        CRUD::addField([
            'label' => 'ISO code',
            'name' => 'iso_code',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',

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

    public function getCities(Request $request)
    {
        $cities = City::where('country_id', $request->input('countryId'))->get();
        return response()->json($cities);
    }
}
