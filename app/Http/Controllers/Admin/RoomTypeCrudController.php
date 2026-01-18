<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RoomTypeRequest;
use App\Models\RoomType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RoomTypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class RoomTypeCrudController extends CrudController
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
        CRUD::setModel(\App\Models\RoomType::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/room-type');
        CRUD::setEntityNameStrings('room type', 'room types');
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
            'label' => 'Type',
            'name' => 'name',
            'type' => 'text'
        ]);

        CRUD::addColumn([
            'label' => 'Beds',
            'name' => 'beds',
            'type' => 'number'
        ]);

        CRUD::addColumn([
            'label' => 'Price',
            'name' => 'price',
            'type' => 'number',
            'prefix' => '$'
        ]);

        CRUD::addColumn([
            'label' => 'Area',
            'name' => 'area',
            'type' => 'number',
            'suffix' => ' m²'
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
        CRUD::setValidation(RoomTypeRequest::class);

        CRUD::addField([
            'label' => 'Type',
            'name' => 'name',
            'type' => 'text',
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'label' => 'Beds',
            'name' => 'beds',
            'type' => 'number',
            'attributes' => ['min' => 1],
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'label' => 'Price',
            'name' => 'price',
            'type' => 'number',
            'prefix' => '$',
            'attributes' => ['min' => 0, 'step' => '0.01'],
            'wrapper' => ['class' => 'form-group col-md-6']
        ]);

        CRUD::addField([
            'label' => 'Area',
            'name' => 'area',
            'type' => 'number',
            'suffix' => ' m²',
            'attributes' => ['min' => 0, 'step' => '0.1'],
            'wrapper' => ['class' => 'form-group col-md-6']
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

    public function store(RoomTypeRequest $request)
    {
        $data = $request->validated();
        $roomType = RoomType::create([
            'name' => $data['name'],
            'beds' => $data['beds'],
            'area' => $data['area'],
            'price' => $data['price'],
        ]);
        if (!$roomType) {
            return response()->json([
                'success' => false,
                'message' => 'Room Type not created'
            ]);
        }
        return response()->json(([
            'success' => true,
            'redirect_ur' => backpack_url('room-type')
        ]));
    }

    public function getRoomTypes()
    {
        $roomTypes = \App\Models\RoomType::all(['id', 'name', 'beds', 'price', 'area']);

        return response()->json($roomTypes);
    }

}
