@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card" style="height: 500px;">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-12">
                                <img src="{{Storage::url($user->image_path)}}" class="img-thumbnail img-fluid" style="width:50px;">
                                <h4>{{$user->name}}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="card-body overflow-auto">
                        <div id="messages-body">
                            @foreach($messages as $message)
                                @if($message->user_send_id==auth()->user()->id)
                                    <div class="row my-3">
                                        <div class="text-end"><span class="rounded-start rounded-top p-2 text-light bg-info">{{$message->message_content}}</span></div>
                                    </div>
                                @else
                                    <div class="row my-3">
                                        <div class="text-start"><span class="rounded-end rounded-top p-2 text-dark bg-secondary">{{$message->message_content}}</span></div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <form id="newMsgForm" action="{{route('messages.save',['user'=>$user])}}" method="POST">
                            @csrf
                            <div class="row mt-5">
                                <div class="col-10">
                                    <input type="text" id="message_content" name="message_content" placeholder="Vasa poruka..." class="form-control">
                                </div>
                                <div class="col-2">
                                    <button class="rounded-5 btn btn-primary btn-block">Posalji</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('additional_scripts')
    <script>
        let userId={{$user->id}};
        let currentUserId={{auth()->user()->id}};

        document.getElementById('newMsgForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const payload = new FormData(document.getElementById('newMsgForm'));
            let res=await fetch('http://127.0.0.1:8000/messages/save/'+userId, {
                method: 'POST',
                body: payload,
            });
            document.getElementById('message_content').value='';
        });

        setInterval(async()=>{
            let response=await fetch('/messages/new-messages/'+userId);
            let messages=await response.json();
            if(messages!=[]){
                let appends='';
                //console.log(messages);
                messages.forEach(message=>{
                    let classes='';
                    let divClass='';
                    if(message.user_send_id==currentUserId){
                        classes='rounded-start rounded-top p-2 text-light bg-info';
                        divClass='text-end';
                    }else{
                        classes='rounded-end rounded-top p-2 text-dark bg-secondary';
                        divClass='text-start';
                    }
                    appends+=`<div class="row my-3">
                                <div class='${divClass}'>
                                    <span class='${classes}'>
                                        ${message.message_content}
                                    </span>
                                </div>
                            </div>`;
                });
                document.getElementById('messages-body').innerHTML+=appends;
            }
        },2000);
    </script>
@endsection
