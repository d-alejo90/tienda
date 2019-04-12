@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>id</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Weight</th>
                            <th>Qty</th>
                            <th>Type</th>
                            <th>State</th>
                        </tr>
                        @foreach($data as $row)
                            <tr>
                                <td>{{$row->id}}</td>
                                <td>{{$row->name}}</td>
                                <td>{{$row->category_id}}</td>
                                <td>{{$row->price}}</td>
                                <td>{{$row->weight}}</td>
                                <td>{{$row->qty}}</td>
                                <td>{{$row->post_type}}</td>
                                <td>{{$row->state}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection