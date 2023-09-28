@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('master')
@section('title','Favourite Blogs')

@section('content')

<div class="bg-primary rounded py-2 px-4 mb-3">
    <div style="display: inline-block"><h2 class="mt-3 mb-4 text-white">Favourite Blogs</h2></div>
    <input type="text" class="form-control mt-4" style="width: 400px; float: right;" placeholder="Seach?">
</div>


<div class="bg-white" style="display: flex; flex-wrap: wrap; width: 100%;">
    @foreach ($favs as $fav)
    <div class=" p-3 rounded-3 mb-5 mt-5 mx-2" style="width: 32%; height: 600px;">

        <div style="width: 100%; height: 250px; text-align: center">
            <img src="{{asset("storage/images/".$fav->blog->image_name)}}" width="100%" height="230px" alt="">
        </div>
        
        <div class="p-3" style="width: 100%">
            <form action="{{url('favourite')}}" method="POST" style="float: right; ">
                @csrf
                <input type="hidden" name="blog_id" value="{{$fav->blog->id}}"/>
                <button class=" btn btn-link" type="submit" ><i class="{{ $fav->blog->favourites->where('user_id',Auth::user()->id)->isEmpty() ? 'bi-heart' : 'bi-heart-fill' }}" style="font-size: 30px;"></i></button>
            </form>

            <div style="max-height: 45px; overflow: hidden;">
                <h2 style="word-wrap: break-word;" class="mb-3 mr-4">{{$fav->blog->topic}}</h2>
            </div>

            <div><i class="bi-person"></i> {{$fav->blog->user->name}}</div>

            <div class="my-3" style="height: 30px">
                @foreach ($fav->blog->blogCategories as $cat)
                    <a href="{{url('category/'.$cat->category_id)}}" role="button" class="border-0 text-decoration-none p-1" style="background-color: #eee; color: black">{{$cat->category->name}}</a>
                @endforeach
            </div>

            <div><i class="bi-clock"></i> <span> {{$fav->blog->updated_at->format('d-M-Y H:i')}}</span></div>
            <div class="my-3 mx-3" style="font-size: 20px; color: #888; height: 120px; word-wrap: break-word; text-overflow: ellipsis; overflow: hidden;">{{$fav->blog->content}}</div>
            <div class="mx-3"><a class="text-decoration-none" style="font-weight: bold" href="#">See more</a></div>
            <div class="mx-3" style="text-align: right"><span><i class="bi-chat-left-text"> 0 Comment</i></span></div>
            
        </div>
</div>
@endforeach
</div>


@endsection
@section('writeblog')
<a role="button" href="{{url('/create')}}" style="font-size: 20px; background-color: #22a" class="text-white text-decoration-none py-2 px-3 rounded">+ Write your blog</a>
@endsection
