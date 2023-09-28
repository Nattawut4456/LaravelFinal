<?php
    $isCreate = empty($blog->id);
    $title = $isCreate ? 'Write your Blog' : 'Edit Blog';
?>
@extends('master')
@section('title',$title)

@section('content')
<h2>{{$title}}</h2>
<div class="bg-white p-3 mt-5 rounded" style="box-shadow: 0px 0px 5px #aaa">

    <form action="{{ $isCreate ? url('/blog/store') : url('/blog/update/'.$blog->id)}}" method="POST" enctype="multipart/form-data">
        @if (!$isCreate)
            @method('put')
        @endif
        @csrf
        @if (!$isCreate)
            <div class="mb-5" style="text-align: center">
                <img class="mb-3" src="{{asset('storage/images/'.$blog->image_name)}}" height="300px"/>
                <div style="text-align: center">
                    <div>
                        <h5>Select image to change</h5>
                        <input type="file" name="image"/>
                    </div>
                    
                </div>
            </div>
        @else
        <div style="float: right">
            <h5>Add cover image</h5>
            <input type="file" name="image"/>
            @error('image')
            <div class="invalid-feedback d-block"><h6>{{ $errors->first('image') }}</h6></div>
            @enderror
        </div>
        @endif
        
        <div class="d-flex flex-row w-100">
            <div style="width: 75%; margin-right: 20px">
                
                <h5>Topic</h5>
                <input type="text" name="topic" class="form-control w-50 mb-3" style="font-size: 25px" value="{{old('topic',$blog->topic)}}">
                @error('topic')
                    <div class="invalid-feedback d-block"><h6>{{ $errors->first('topic') }}</h6></div>
                @enderror
                <h5 class="mt-3">Content</h5>
                <textarea class="form-control w-100" style="min-height: 500px; font-size: 20px" name="content" >{{old('content',$blog->content)}}</textarea>
                @error('content')
                    <div class="invalid-feedback d-block"><h6>{{ $errors->first('content') }}</h6></div>
                @enderror
            </div>
            <div style="padding-top: 155px;width: 25%">
                <h5>Category</h5>
                @error('cats')
                    <div class="invalid-feedback d-block"><h6>you must select at least 1 category</h6> </div>
                @enderror
                <div class="border p-3" style="height: 500px ;width: 100%; overflow-y: scroll; scrollbar">
                    @foreach ($cats as $i=>$cat)
                    <div class="m-2" style="font-size: 20px">
                        <input class="form-check-input" type="checkbox" name="cats[]" id="{{'category-'.$cat->id}}" value="{{$cat->id}}" 
                        @if(is_array(old('cats',$blog->blogCategories->pluck('category_id')->toArray())) 
                        && in_array($cat->id,old('cats',$blog->blogCategories->pluck('category_id')->toArray()))) 
                        checked 
                        @endif />
                        <label class="form-check-label" for="{{'category-'.$cat->id}}">{{$cat->name}}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button class="d-block mx-auto mt-3 btn btn-primary btn-lg" type="submit">{{$isCreate ? 'Create Blog' : 'Save'}}</button>
        
    </form>
</div>
@endsection
