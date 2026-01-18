<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TourRequest;
use App\Models\Airport;
use App\Models\Country;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Tour;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TourCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TourCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Tour::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/tour');
        CRUD::setEntityNameStrings('tour', 'tours');
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
            'label' => 'Tour Name',
            'name' => 'name',
            'type' => 'text'
        ]);


        CRUD::addColumn([
            'label' => 'Hotel',
            'name' => 'hotel_id',
            'type' => 'relationship',
            'attribute' => 'name',
            'entity' => 'hotel'
        ]);

        CRUD::addColumn([
            'label' => 'Price',
            'name' => 'price',
            'type' => 'number',
            'prefix' => '$',
            'decimals' => 2
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
        CRUD::setValidation(TourRequest::class);

        CRUD::addField([
            'label' => 'Tour Name',
            'name' => 'name',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Enter tour name'
            ],
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::addField([
            'label' => 'Price',
            'name' => 'price',
            'type' => 'number',
            'prefix' => '$',
            'attributes' => [
                'min' => 0, 'step' => '0.01'
            ],
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);


        CRUD::addField([
            'label' => 'Hotel',
            'name' => 'hotel_id',
            'type' => 'select',
            'entity' => 'hotel',
            'model' => Hotel::class,
            'attribute' => 'name',
            'dependencies' => ['city_id'],
            'options' => (function ($query) {
                if (request()->city_id) {
                    return $query->where('city_id', request()->city_id)
                        ->orderBy('name', 'ASC')
                        ->get();
                }
                return $query->orderBy('name', 'ASC')->get();
            }),
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::addField([
            'label' => 'Airport',
            'name' => 'airport_id',
            'type' => 'select',
            'entity' => 'airport',
            'model' => Airport::class,
            'attribute' => 'name',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);


        CRUD::addField([
            'label' => 'Active from',
            'name' => 'active_from',
            'type' => 'date',
            'placeholder' => 'when tour starts',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::addField([
            'label' => 'Active to',
            'name' => 'active_to',
            'type' => 'date',
            'placeholder' => 'when tour ends',
            'wrapper' => [
                'class' => 'form-group col-md-6'
            ]
        ]);

        CRUD::addField([
            'label' => 'Description',
            'name' => 'description',
            'type' => 'text',
            'attributes' => [
                'placeholder' => 'Enter tour description',
                'rows' => 5
            ]
        ]);




    }

    private function handleTourSave(Tour $tour)
    {

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
}
