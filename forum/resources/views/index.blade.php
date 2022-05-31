@extends('layout.mainlayout', ["title" => env('MAIN_TITLE'), "description" => env('META_DESCRIPTION') ])
@section('content')

<div class=" d-md-none  d-lg-none">

@if(Request()->q && empty($category))
<div class="p-3 bg-info text-white">
        Search result : <b>{{Request()->q}}</b>
</div>
@elseif(!Request()->q && !empty($category))
<div class="p-3 bg-info text-white">
    Selected Category : <b>{{$category->name}}</b>
</div>
@elseif(Request()->q && !empty($category))
    <div class="p-3 bg-info text-white">
            Showing result of <b>{{Request()->q}}</b> in <b> {{$category->name}} </b>
    </div>
@endif

</div>
    
    <div class="container mt-3">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
            @include('layout.partials.sidebar')
            <!-- /Inner sidebar -->

            <!-- Inner main -->
            <div class="inner-main ">
                <!-- Inner main header -->
                <div class="d-none d-sm-block">
                    <div class="inner-main-header justify-content-between ">
                        <select id="order_by" class="custom-select custom-select-sm w-auto mr-1">
                            <option @if(Request()->order_by=='latest_question') selected @endif value="latest_question">Latest</option>
                            <option @if(Request()->order_by=='latest_activity' || Request()->order_by=='' || Request()->order_by==null) selected @endif value="latest_activity">Recent Activity</option>
                        </select>
                        <form>
                        <div class="input-group input-icon input-icon-sm ml-auto w-auto">
                            <input type="text" class="form-control" value="{{Request()->q}}" name="q" aria-label="" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary" type="submit">Search Question</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>


                <div class="d-md-none d-lg-none">
            
                    <form>
                        <div class="form-group">
                            <div class="input-group input-icon input-icon-sm ml-auto w-auto">
                                <input type="text" class="form-control" value="{{Request()->q}}" name="q" aria-label="" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-primary" type="submit"><i class="fa fa-search"></i></button>
                                    <a href="/ask_question" class="btn btn-outline-primary" type="submit">Ask</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="">
                            <label>Sort by :</label>
                            <select id="order_by_s" class="custom-select custom-select-sm w-auto mr-1">
                            <option @if(Request()->order_by=='latest_question') selected @endif value="latest_question">Latest</option>
                            <option @if(Request()->order_by=='latest_activity' || Request()->order_by=='' || Request()->order_by==null) selected @endif value="latest_activity">Recent Activity</option>
                            </select>
                        </div>

                        <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Categories
                        </button>
                        

                      
                        
                    </div>
                    
                    <hr>
                </div>


                <!-- /Inner main header -->

                <div class=" d-none d-sm-block">

                    @if(Request()->q && empty($category))
                    <div class="p-3 bg-info text-white">
                            Search result : <b>{{Request()->q}}</b>
                    </div>
                    @elseif(!Request()->q && !empty($category))
                    <div class="p-3 bg-info text-white">
                        Selected Category : <b>{{$category->name}}</b>
                    </div>
                    @elseif(Request()->q && !empty($category))
                        <div class="p-3 bg-info text-white">
                                Showing result of <b>{{Request()->q}}</b> in <b> {{$category->name}} </b>
                        </div>
                    @endif

                </div>

                <!-- Inner main body -->

                <div class="collapse" id="collapseExample">
                        <nav class="nav nav-pills nav-gap-y-1 flex-column">

                        
                            <a href="javascript:void(0)" class="nav-link nav-link-faded has-icon active mb-0">
                                Categories
                            </a>
                            <div class="nav-link nav-link-faded has-icon mt-0 p-2 pt-3">
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a href="/category/{{ $category->id }}/{{ $category->slug }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                            </div>

                            </optgroup>
                        </nav>
                </div>

                <!-- Forum List -->
                <div class=" p-0 p-sm-3 collapse forum-content show">

                
                @if($questions->count() == 0)
                    <div class="text-center p-5">
                        No Questions
                    </div>
                @endif
                @foreach ($questions as $question)
                    <div class="card mb-3 d-none d-sm-block">
                        <div class="card-body p-2 p-sm-3">
                            <div class="media forum-item">
                            
                                <div class="media-body">
                                    <h6><a  href='{{ URL::route("view_question_route", [ $question->id, $question->slug]) }}'> <span >{{$question->content}}</span></a></h6>
                                  
                                    
                                    <p class="text-muted">last reply <span class="text-secondary font-weight-bold">
                                        {{$question->updated_at->diffForHumans()}}
                                    </span></p>
                                </div>
                                <div class="text-muted small text-center align-self-center">
                                <span class="text-muted mr-2"><i class="fa fa-user mr-1"></i> {{$question->name}}</span>
                                <span class="badge badge-primary"><a href="/category/{{$question->category->slug}}/{{$question->category->id}}">{{$question->category->name}}</a></span>
                                    <span><i class="far fa-clock ml-2"></i> {{$question->created_at->diffForHumans()}}</span> 
                                    
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 d-md-none d-lg-none">
                        <div class="card-body p-2 p-sm-3">
                            <div class="media forum-item">
                            
                                <div class="media-body">
                                    <h6><a  href='{{ URL::route("view_question_route", [$question->slug, $question->id]) }}'> <span >{{$question->content}}</span></a></h6>
                                   
                                    
                                    <p class="text-muted">last reply <span class="text-secondary font-weight-bold">
                                        {{$question->updated_at->diffForHumans()}}
                                    </span></p>
                                </div>
                               
                            </div>
                            <div class="text-muted small align-self-center">
                            <span class="text-muted mr-2"><i class="fa fa-user mr-1"></i> {{$question->name}}</span>
                                <span class="badge badge-primary"><a href="/category/{{$question->category->slug}}/{{$question->category->id}}">{{$question->category->name}}</a></span>
                                    <span><i class="far fa-clock ml-2"></i> {{$question->created_at->diffForHumans()}}</span> 
                                </div>
                        </div>
                    </div>

                    
                    @endforeach
                    
                    <div class=" d-none d-sm-block">

                    <div class="d-flex justify-content-between">

                            

                            <span>Showing <b>{{$questions->currentPage()}}</b> of <b>{{$questions->lastPage()}}</b></span>
                        
                            <ul class="pagination pagination-sm pagination-circle mb-0">
                                    
                                    @if($questions->currentPage() == 1)
                                        <li class="page-item ">
                                            <a class="btn btn-primary disabled mr-3" href="#"><i class="fa fa-arrow-left mr-1"></i> Previous</a>
                                        </li>
                                    @else
                                        <li class="page-item ">
                                            <a class="btn btn-primary  mr-3" href="{{$questions->previousPageUrl()}}&q={{Request()->q}}&order_by={{Request()->order_by}}"> <i class="fa fa-arrow-left mr-1"></i> Previous</a>
                                        </li>
                                    @endif

                                    @if($questions->hasMorePages())
                                        <li class="page-item">
                                            <a class="btn btn-primary " href="{{$questions->nextPageUrl()}}&q={{Request()->q}}&order_by={{Request()->order_by}}">Next<i class="fa fa-arrow-right ml-1"></i></a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <a class="btn btn-primary  disabled" href="#">Next<i class="fa fa-arrow-right ml-1"></i></a>
                                        </li>
                                    @endif
                                    
                                
                            </ul>

                        </div>


                        </div>

</div>

                        <div class=" d-md-none d-lg-none">

                        

                            <span class="text-center">Showing <b>{{$questions->currentPage()}}</b> of <b>{{$questions->lastPage()}}</b></span>
                        
                                <ul class="pagination pagination-sm pagination-circle mt-3">
                                        
                                        @if($questions->currentPage() == 1)
                                            <li class="page-item ">
                                                <a class="btn btn-primary disabled mr-3" href="#"><i class="fa fa-arrow-left mr-1"></i> Previous</a>
                                            </li>
                                        @else
                                            <li class="page-item ">
                                                <a class="btn btn-primary  mr-3" href="{{$questions->previousPageUrl()}}&q={{Request()->q}}&order_by={{Request()->order_by}}"> <i class="fa fa-arrow-left mr-1"></i> Previous</a>
                                            </li>
                                        @endif

                                        @if($questions->hasMorePages())
                                            <li class="page-item">
                                                <a class="btn btn-primary " href="{{$questions->nextPageUrl()}}&q={{Request()->q}}&order_by={{Request()->order_by}}">Next<i class="fa fa-arrow-right ml-1"></i></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <a class="btn btn-primary  disabled" href="#">Next<i class="fa fa-arrow-right ml-1"></i></a>
                                            </li>
                                        @endif
                                        
                                    
                                </ul>

                        </div>


                        </div>


                <!-- /Forum List -->


                <!-- /Inner main body -->
            </div>
            <!-- /Inner main -->
        </div>

  
    </div>
    </div>
@endsection