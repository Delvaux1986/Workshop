
@extends('layouts.app')
    
@section('title',' Topic')
@section('extra-js')
    
    {{-- SCRIPT FOR TOGGLE REPLYCOMMENT FROM ID OF COMMENT --}}
    <script>
        let toggleReplyComment = (id) => {
            let element = document.getElementById('replyComment-' + id);
            element.classList.toggle('d-none');
        }
    </script>
@endsection

@section('content')
{{-- SHOW THE TOPIC SELECTED --}}
<div class="container d-flex justify-content-center ">
    <div class="row">
        <div class="shadow-lg card text-center m-5 col-md-10 offset-md-3">
            <div class="card-header pt-4">
                <h4 class="card-title ">{{ $topic->title }}</h4>
            </div>
            <div class="card-body pr-0 pl-0 pb-0">
                <p class="card-text">{{$topic->content}}</p>
                <div class="d-flex justify-content-around ">
                    <div class="p-4  ">
                        @can('update', $topic)
                        <a href="{{ route('topics.edit' , $topic)}}" class="btn btn-outline-secondary font-weight-bolder">Editer le Topic</a>
                        @endcan
                    </div>
                    <div class="p-4">
                        @can('delete', $topic)
                        <form action="{{ route('topics.destroy' , $topic->id)}}" method="POST">
                         @csrf
                            @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger font-weight-bolder">Supprimer le Topic</button>
                     </form>
                     @endcan
                    </div>
                </div>
            <div class=" card-footer d-flex justify-content-between">
            
                Posté le {{ $topic->created_at->format('d/m/Y à H:m')}} <h5><span class="badge badge-info">{{ $topic->user->name }}</span>  </h5>  
            </div>
        </div>
    </div>
    {{-- FOR ELSE DES COMMS --}}
    @forelse ($topic->comments as $comment)
        <div class="container">
        <div class="card">
            <div class="card-body">
                {{ $comment->content }}
            </div>
            <div class=" card-footer d-flex justify-content-between">
            
                Posté le {{ $topic->created_at->format('d/m/Y à H:m')}} <h5><span class="badge badge-info">{{ $comment->user->name }}</span>  </h5>  
            </div>
        </div>
    </div>
    @foreach ($comment->comments as $reply)
        <div class="container">
        <div class="card mb-2 ml-5">
            <div class="card-bod">
                <small>{{$reply->content}}</small>
            </div>
        </div>
    </div>
    @endforeach
    @auth 
        <button class="btn btn-info mb-3" onclick="toggleReplyComment({{$comment->id}})">Réponde</button>
        <div class="container">
        <form action="{{ route('comment.storeReply' , $comment)}}" class="ml-3 d-none" method="POST" id="replyComment-{{$comment->id}}">
            @csrf 
            <div class="form-group">
                <label for="replyComment">Ma réponse</label>
                <textarea name="replyComment" class="form-control" id="replyComment" rows="5"></textarea>
            </div>
            <button class="btn btn-outline-info mt-2 mb-2">Répondre</button>
        </form>
    </div>
    @endauth 
    @empty
    <div class="alert alert-info">Aucun commentaire pour ce topic</div>
    @endforelse
    
    {{-- FORM COMMS --}}
    <div class="container">
    <form action="{{ route('comments.store' , $topic)}}" method="POST" class="mt-3">
        @csrf
        <div class="form-group">
            <label for="content" id="content" class="text-light">Votre commentaire</label>
            <textarea name="content" rows="3" class="form-control @error('content') is-invalid @enderror"></textarea>
                @error('content')
                <div class="invalid-feedback">{{$errors->first('content')}} </div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Envoi</button>
        </form>
    </div>

    {{-- COMMENT SECTION  --}}
   
                {{-- SHOW REPLY OF THIS COMMENT  --}}
               
                
                {{-- FORM REPLY ON COMMENTS  ONLT AUTH --}}
                
        {{-- FORM FOR COMMENTS --}}
        
    

</div>

        @endsection