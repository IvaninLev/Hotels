<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\HotelsRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\Hotel;
use App\Models\RoomType;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HotelCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;

    public function setup()
    {
        CRUD::setModel(\App\Models\Hotel::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/hotel');
        CRUD::setEntityNameStrings('hotel', 'hotels');
    }

    protected function setupListOperation()
    {
        CRUD::addColumn(['label' => 'Name', 'name' => 'name', 'type' => 'text']);
        CRUD::addColumn(['label' => 'Description', 'name' => 'description', 'type' => 'text']);
        CRUD::addColumn(['label' => 'Room types', 'name' => 'roomType', 'type' => 'text']);

        CRUD::button('createButton')
            ->stack('top')
            ->view('crud::buttons.quick')
            ->meta(['access' => true, 'label' => 'Create Hotel',
                'wrapper' => [
                    'element' => 'a',
                    'href' => backpack_url('hotel/create'),
                ]]);

        CRUD::button('editButton')
            ->stack('line')
            ->view('crud::buttons.quick')
            ->meta([
                'access' => true,
                'label' => 'Edit',
                'wrapper' => [
                    'element' => 'a',
                    'href' => function ($entry, $crud) {
                        return backpack_url('hotel/' . $entry->getKey() . '/edit');
                    },
                ],
            ]);

    }

    public function create()
    {
        $countries = Country::all();
        $roomTypes = RoomType::all();
        return view('admin.hotel.create', compact('countries', 'roomTypes'));
    }


    public function store(HotelsRequest $request)
    {
        $data = $request->validated();

        $hotel = Hotel::create([
            'name'        => $data['name'],
            'description' => $data['description'],
            'country_id'  => $data['country'],
            'city_id'     => $data['city'],
        ]);

        if (!$hotel) {
            return response()->json([
                'success' => false,
                'message' => 'Hotel not created'
            ], 500);
        }

        $images = [];
        if ($request->has('images')) {
            $path = 'uploads/hotels/' . $hotel->hotel_key;
            foreach ($data['images'] as $image) {
                if (preg_match('/^data:image\/(\w+);base64,(.+)$/', $image, $matches)) {
                    $extension = $matches[1];
                    $imageData = base64_decode($matches[2]);
                    $fileName  = Str::random() . '.' . $extension;
                    $imagePath = "$path/$fileName";
                    Storage::disk('public')->put($imagePath, $imageData);
                    $images[] = $imagePath;
                }
            }
            $hotel->images = $images;
            $hotel->save();
        }

        if ($request->has('roomTypes')) {
            $roomTypes = json_decode($request->roomTypes, true);

            foreach ($roomTypes as $rt) {
                $hotel->hotelRoomTypes()->create([
                    'room_type_id' => $rt['room_type_id'],
                    'beds'         => $rt['beds'],
                    'area'         => $rt['area'],
                    'price'        => $rt['price'],
                    'total_rooms'  => $rt['total_rooms'],
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'redirect_url' => backpack_url('hotel')
        ]);
    }



    public function edit(Hotel $hotel)
    {
        $countries = Country::all();
        $cities = City::where('country_id', $hotel->country_id)->get();
        return view('admin.hotel.update', compact('hotel', 'countries', 'cities'));
    }

    public function update(HotelsRequest $request, Hotel $hotel)
    {
        $data = $request->validated();
        if ($request->has('images')) {
            $savedImages = $hotel->images;
            $path = 'uploads/hotels/' . $hotel->hotel_key;
            foreach ($data['images'] as $image) {
                if (preg_match('/^data:image\/(\w+);base64,(.+)$/', $image, $matches)) {
                    $extension = $matches[1];
                    $imageData = base64_decode($matches[2]);
                    $fileName = Str::random() . '.' . $extension;
                    $imagePath = "$path/$fileName";
                    Storage::disk('public')->put($imagePath, $imageData);
                    $images[] = $imagePath;
                } elseif (filter_var($image, FILTER_VALIDATE_URL)) {
                    $images[] = ltrim(str_replace(url('storage/'), '', $image), '/');
                }
            }
            $toDelete = array_diff($savedImages, $images);
            foreach ($toDelete as $item) {
                Storage::disk('public')->delete($item);
            }
            $hotel->images = $images;
            $hotel->save();
            $hotel->refresh();
        }
        return response()->json([
            'success' => true,
            'redirect_url' => backpack_url('hotel')
        ]);
    }


}
