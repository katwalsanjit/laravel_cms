@extends('layouts.app')


@section('content')
    <div class="container">
        <br />
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-6">
                <div class="row">
                    <form action="{{url('items/import')}}" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                            {{csrf_field()}}
                            <input type="file" name="imported-file"/>
                        </div>
                        <div class="col-md-6">
                            <button class="btn btn-primary" type="submit">Import</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2">
                <form action="{{url('items/export')}}" enctype="multipart/form-data">
                    <button class="btn btn-success" type="submit">Export</button>
                </form>
            </div>
        </div>
        <div class="row">
            @if(count($items))
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <td>item_name</td>
                        <td>item_code</td>
                        <td>item_price</td>
                        <td>item_qty</td>
                        <td>item_tax</td>
                        <td>item_status</td>
                    </tr>
                    </thead>
                    @foreach($items as $item)
                        <tr>
                            <td>{{$item->item_name}}</td>
                            <td>{{$item->item_code}}</td>
                            <td>{{$item->item_price}}</td>
                            <td>{{$item->item_qty}}</td>
                            <td>{{$item->item_tax}}</td>
                            <td>{{$item->item_status}}</td>
                        </tr>
                    @endforeach
                </table>
            @endif
        </div>
    </div>
@endsection()


