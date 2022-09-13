@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Predlozeni prijatelji</h4></div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Ime i prezime</th>
                                <th>Dodaj prijatelja</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($not_friends as $not_friend)
                                    <tr>
                                        <td><img src="{{Storage::url($not_friend->image_path)}}" class="img-fluid img-thumbnail" style="width:50px;"></td>
                                        <td>{{$not_friend->name}}</td>
                                        <td>
                                            <form action="{{route('user.add',['user'=>$not_friend])}}" method="POST">
                                                @csrf
                                                <button class="btn btn-outline-primary">Posalji zahtjev</button>
                                            </form>
                                        </td>
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
