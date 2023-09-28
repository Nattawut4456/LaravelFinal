@extends('master')
@section('title','My blog')
@section('content')

<div class="bg-primary rounded py-2 px-4 mb-3">
    <div style="display: inline-block"><h2 class="mt-3 mb-4 text-white">My Blogs</h2></div>
    <input type="text" class="form-control mt-4" style="width: 400px; float: right;" placeholder="Seach?">
</div>


<div class="" style=" width: 100%;">
    @foreach ($blogs as $blog)
    <div class="bg-white p-3 rounded-3 mt-3 mb-5 mx-auto" style="width: 60%; height: 810px; box-shadow: 0px 0px 5px #aaa">

        <div style="width: 100%; height: 450px; text-align: center">
            <img src="{{asset("storage/images/".$blog->image_name)}}" width="100%" height="400px" alt="">
        </div>

        <div class="p-3" style="width: 100%">
            <a href="{{url('/blog/delete/'.$blog->id)}}"
                style="float: right; font-size: 30px; color: #f00"
                id="delete-blog" data-id="{{$blog->id}}"><i class="bi-trash-fill"></i></a>
            <a href="{{url('/blog/edit/'.$blog->id)}}"
                style="float: right; font-size: 30px"><i class="bi-pencil mx-3"></i></a>

            <div style="max-height: 45px; overflow: hidden;">
                <h2 style="word-wrap: break-word;" class="mb-3 mr-4">{{$blog->topic}}</h2>
            </div>

            <div class="my-2">
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
<a role="button" href="{{url('/blog/create')}}" style="font-size: 20px; background-color: #22a" class="text-white text-decoration-none py-2 px-3 rounded">+ Write your blog</a>
@endsection
