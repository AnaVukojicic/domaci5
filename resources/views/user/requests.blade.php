@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h4>Moji zahtjevi</h4></div>

                    <div class="card-body table-responsive">
                        <table class="table table-hover align-middle text-center">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Ime i prezime</th>
                                <th>Prihvati</th>
                                <th>Odbij</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($requests as $request)
                                <tr>
                                    <td><img src="{{Storage::url($request->user_who_sent->image_path)}}" class="img-fluid img-thumbnail" style="width:50px;"></td>
                                    <td>{{$request->user_who_sent->name}}</td>
                                    <td>
                                        <form action="{{route('request.accept',['request'=>$request])}}" method="POST">
                                            @csrf
                                            @method("PUT")
                                            <button class="btn btn-success">Prihvati</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{route('request.decline',['request'=>$request])}}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <button class="btn btn-danger">Odbij</button>
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
