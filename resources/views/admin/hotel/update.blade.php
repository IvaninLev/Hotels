@extends(backpack_view('blank'))
@section('content')
    <div id="crud">
        <create-hotel :hotel="{{$hotel}}" :countries="{{$countries}}" :cities="{{$cities}}"/>
    </div>
@endsection
