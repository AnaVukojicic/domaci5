@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Moji prijatelji</h4></div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Ime i prezime</th>
                                    <th>Pogledaj konverzaciju</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($friends as $friend)
                                    <tr>
                                        <td><img src="{{Storage::url($friend->image_path)}}" class="img-fluid img-thumbnail" style="width:50px;"></td>
                                        <td>{{$friend->name}}</td>
                                        <td><a href="{{route('messages.show',['user'=>$friend])}}" class="text-center btn btn-primary rounded-5">+</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
