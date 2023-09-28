@php
    use Illuminate\Support\Facades\Auth;
    $titleValue = empty($titleValue) ? '' : $titleValue;
@endphp

@extends('master')
@section('title',$titleValue)

@section('content')

<div class="bg-primary rounded py-2 px-4 mb-3">
    <div style="display: inline-block"><h2 class="mt-3 mb-4 text-white">{{$title.' '.$titleValue}}</h2></div>
    <form action="{{url('blog/search/')}}" method="GET" class="d-inline-block" style="float: right">
        <input type="text" name="search" class="form-control mt-4 d-inline-block" style="width: 400px;" placeholder="Seach?"
            value="{{old('search',$text??"" )}}">
            @if (!empty($text))
                <a href="{{url('/')}}" class="d-inline-block" role="button" style="color: #aaa;font-size: 20px; margin-left: -35px">
                    <i class="bi-x-circle-fill"></i>
                </a>
            @endif
        <button type="submit" class="d-inline-block btn btn-link text-decoration-none text-white"
        style="font-size: 20px; margin-left: 1em">Search</button>
    </form>

</div>


<div class="bg-white rounded" style="display: flex; flex-wrap: wrap; width: 100%; ">
    @foreach ($blogs as $blog)
    <div class=" p-3 rounded-3 mb-5 mt-5 mx-2" style="width: 32%; height: 650px;">

        <div style="width: 100%; height: 250px; text-align: center">
            <img src="{{asset("storage/images/".$blog->image_name)}}" width="100%" height="230px" alt="">
        </div>

        <div class="p-3" style="width: 100%">
            <form action="{{url('favourite')}}" method="POST" style="float: right; ">
                @csrf
                <input type="hidden" name="blog_id" value="{{$blog->id}}"/>
                <button class=" btn btn-link" type="submit" ><i class="{{!empty(Auth::user()) && !$blog->favourites->where('user_id',Auth::user()->id)->isEmpty() ? 'bi-heart-fill' : 'bi-heart' }}" style="font-size: 30px;"></i></button>
            </form>

            <div style="max-height: 45px; overflow: hidden;">
                <h2 style="word-wrap: break-word;" class="mb-3 mr-4">{{$blog->topic}}</h2>
            </div>

            <div><i class="bi-person"></i> {{$blog->user->name}}</div>

            <div class="my-3" style="height: 30px">
                @foreach ($blog->blogCategories as $cat)
                    <a href="{{url('category/'.$cat->category_id)}}" role="button" class="border-0 text-decoration-none p-1" style="background-color: #eee; color: black">{{$cat->category->name}}</a>
                @endforeach
            </div>

            <div><i class="bi-clock"></i> <span> {{$blog->updated_at->format('d-M-Y H:i')}}</span></div>
            <div class="my-3 mx-3" style="font-size: 20px; color: #888; height: 120px; word-wrap: break-word; text-overflow: ellipsis; overflow: hidden;">{{$blog->content}}</div>
            <div class="mx-3"><a class="text-decoration-none" style="font-weight: bold" href="{{url('blog/'.$blog->id)}}">See more</a></div>
            <div class="mx-3" style="text-align: right"><span><i class="bi-chat-left-text"> {{$blog->comments->count()}} Comment</i></span></div>

        </div>
</div>
@endforeach
</div>


@endsection
@section('writeblog')
<a role="button" href="{{url('writeblog')}}" style="font-size: 20px; background-color: #22a" class="text-white text-decoration-none py-2 px-3 rounded">+ Write your blog</a>
@endsection
