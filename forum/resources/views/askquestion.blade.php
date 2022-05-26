@extends('layout.mainlayout', ['title' => "Ask Question", 'description' => "Desfription here"])
@section('content')
<div class="d-md-none  d-lg-none bg-primary p-2">
    <div class="d-flex align-items-center justify-content-between">
        <span class="text-white item-self-center"><b class="text-white"> <a class="text-white" href="/"> <i class="fa fa-home ml-2"></i> </a>  </b> </span>
    </div>
</div>
    <div class="container">
    <div class="main-body p-0">
        <div class="inner-wrapper">
            <!-- Inner sidebar -->
           
            @include('layout.partials.sidebar')

            <!-- Inner main -->
            <div class="inner-main">
                <!-- Inner main header -->
                <div class="inner-main-header d-none d-sm-block">
                    <span class="lead mb-2"><b> Ask Question </b> </span>
                </div>
                <div class="p-md-5 my-3">
                    
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

                @if(!empty($custom_error))
                    <div class="alert alert-danger ">
                        {{$error}}
                    </div>
                @endif
                
        

                <form method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Your Name</label>
                        <input  type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">Title</label>
                        <input  type="text" class="form-control" name="title" id="subject" aria-describedby="emailHelp">
                    </div>
                    
                    <div id="suggested" style="display:none" class="my-3">
                        <b>Similar Questions</b>
                        <ul id="suggested_item"></ul>
                    </div>
                    
                    {!! csrf_field() !!}
                    
                    <div class="form-group">
                        <label for="exampleInputEmail1">Question Category</label>
                        <select type="text" class="form-control" name="category" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
                            <option value=""></option>
                            @foreach ($categories as $name => $value)
                                <optgroup label="{{$name}}">
                                    @foreach ($value as $subcat)
                                        <option value="{{ $subcat[0] }}">{{ $subcat[1] }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                           
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Question</label>
                        <textarea name="question" class="form-control" ></textarea>
                    </div>

                    <div class="g-recaptcha" data-sitekey="6LdwXBQgAAAAAHt5nJRomucHKxA8AQSFq_yMM5m2"></div>

                    <button type="submit" class="btn btn-primary mt-2">Submit</button>
                    </form>
                </div>
            </div>
            <!-- /Inner main -->

            
        </div>

   
    </div>
@endsection