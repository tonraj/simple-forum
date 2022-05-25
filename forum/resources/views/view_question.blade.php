@extends('layout.mainlayout', ["title" => "Question"])
@section('content')
<div class="d-md-none  d-lg-none bg-primary p-2">
    <div class="d-flex align-items-center justify-content-between">
        <span class="text-white item-self-center"><b class="text-white"> <a class="text-white" href="/"> <i class="fa fa-home ml-2"></i> </a>  </b> </span>
        <a href="/ask_question" class="btn btn-outline-white" type="submit">Ask Question</a>
    </div>
</div>
    <div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
            @include('layout.partials.sidebar')
            <!-- /Inner sidebar -->

            <!-- Inner main -->
               
            <div class="inner-main">
                <!-- Inner main header -->
                <div class="d-none d-sm-block">
                    <div class="inner-main-header  justify-content-between">
                        Question
                        <form action="/">
                        <div class="input-group input-icon input-icon-sm ml-auto w-auto">
                            <input type="text" class="form-control" value="{{Request()->q}}" name="q" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">Search Question</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class=" p-2 p-sm-3">

                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @isset($success)
                            <div class="alert alert-success">
                                {{$success}}
                            </div>
                        @endisset


                            <h2 class="mt-2" > {{$question->subject}} </h2>
                            <p>{{$question->content}}</p>

                            <small class="mr-2"> <span class="text-muted"><i class="fa fa-user mr-1"></i> {{$question->name}}</span></small>
                            <small class="mr-2"> <span class="text-muted"><i class="fa fa-clock mr-1"></i> {{$question->created_at->diffForHumans()}}</span></small>
                            <small> <span class="badge badge-primary mb-4"><a href="/category/{{$question->category->slug}}/{{$question->category->id}}">{{$question->category->name}}</a></span></small>
                            <form  method="post">
                                <input type="text" class="form-control form-control-lg mb-2" name="name" placeholder="Your Name">
                                <textarea name="comment" class="form-control form-control-lg" placeholder="Write reply"></textarea>
                                {!! csrf_field() !!}
                                <button name="submit_comment" type="submit" class="mt-2 btn btn-success">
                                    Save Answer
                                </button>
                            </form>

                            <div class=" my-3">

            <div class="row  d-flex justify-content-center">

                <div class="m-0">

                    <div class="headings d-flex  mb-3">
                        <h5><span>Showing <b>{{$replies->currentPage()}}</b> of <b>{{$replies->lastPage()}}</b> page.</span></h5>
                    </div>

                    @if($replies->count() == 0)
                    <div class="text-center p-5">
                        Post your first comment!
                    </div>
                    @endif
                    @foreach ($replies as $reply)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="media forum-item">
                                        <a href="javascript:void(0)" class="card-link">
                                            <img src="https://bootdey.com/img/Content/avatar/avatar2.png" class="rounded-circle" width="50" alt="User" />
                                        </a>
                                        <div class="media-body ml-3">
                                            <a href="javascript:void(0)" class="text-secondary">{{$reply->name}}</a>
                                            <small class="text-muted ml-2">{{$reply->created_at->diffForHumans()}}</small>
                                            <div class="mt-3 font-size-sm">
                                                {{$reply->content}}
                                            </div>

                                            <div class="mt-3 small">
                                                <ul class="list-group">
                                                    @foreach ($reply->replies as $reply_reply)
                                                       <li class="list-group-item"> <i class="fa fa-reply mr-2"></i> <span class="text-muted"> {{$reply_reply->name}} </span> wrote  {{$reply_reply->content}} <small class="text-muted ml-2">{{$reply_reply->created_at->diffForHumans()}}</small> </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            <br>
                                            <form method="post">
                                            <input type="text" class="form-control mb-2" name="name" placeholder="Your Name">
                                                <div class="input-group input-group-lg">
                                                    <input type="text" class="form-control form-control-lg" name="comment" placeholder="Reply" aria-label="Write your reply!" aria-describedby="basic-addon2">
                                                    <input type="hidden" name="comment_id" value="{{$reply->id}}">
                                                    
                                                    {!! csrf_field() !!}
                                                    <div class="input-group-append">
                                                        <button name="reply" class="btn btn-outline-info" style="line-height: 0.5;" type="submit">Reply</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    

                    <ul class="pagination pagination-sm pagination-circle my-3">
                            
                            @if($replies->currentPage() == 1)
                                <li class="page-item ">
                                    <a class="btn btn-primary disabled mr-3" href="#"><span class="material-icons"><i class="fa fa-arrow-left mr-1"></i> Previous</span></a>
                                </li>
                            @else
                                <li class="page-item ">
                                    <a class="btn btn-primary mr-3" href="{{$replies->previousPageUrl()}}"><i class="fa fa-arrow-left mr-1"></i> Previous</a>
                                </li>
                            @endif

                            @if($replies->hasMorePages())
                                <li class="page-item">
                                    <a class="btn btn-primary" href="{{$replies->nextPageUrl()}}">Next<i class="fa fa-arrow-right ml-1"></i></a>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="btn btn-primary disabled"  href="#">Next <i class="fa fa-arrow-right ml-1"></i> </a>
                                </li>
                            @endif
                            
                        
                    </ul>


                </div>
                <!-- /Forum Detail -->

                <!-- /Inner main body -->
            </div>
            <!-- /Inner main -->
        </div>

        
    </div>
    </div>
@endsection