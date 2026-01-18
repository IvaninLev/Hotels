@extends(backpack_view('blank'))
@section('content')
    <div id="crud">
        <create-hotel :countries="{{$countries}}" :room-types="{{$roomTypes}}"/>
    </div>
@endsection
