@php
    use Illuminate\Support\Facades\Auth;
@endphp

@extends('master')
@section('title',$blog->topic)
@section('content')
    <div class="bg-primary text-white p-3 rounded-3">
        <h3 class="mx-5">{{$blog->topic}}</h3>
    </div>
    <div class="bg-white p-3">
        <div style="width: 100%; height: 500px; overflow: hidden;; text-align: center">
            <img src="{{asset("storage/images/".$blog->image_name)}}" height="100%" alt="">
        </div>
        <div class="mt-5">
            <h2 style="color: #555"><i class="bi-person"></i> {{$blog->user->name}}</h2>
            <h6 class="px-3 mt-3"  style="color: #555"><i class="bi-clock"></i> {{$blog->updated_at}}</h6>
        </div>
        <div class="mt-3 mb-5 rounded" style="background-color: #555; height: 3px;"></div>
        <div>
            <div class="d-inline-block" style="box-sizing: border-box; width: 75%; vertical-align: top">

                <div class="bg-white p-3 rounded-3" style=" font-size: 26px; box-shadow: 0 0 10px #ccc">
                    {{$blog->content}} Lorem ipsum dolor sit amet consectetur adipisicing elit. Maiores nulla explicabo magni at maxime aperiam doloremque, vel officiis ipsam tempore optio esse impedit non velit eveniet quisquam? Pariatur magni ipsum esse fuga nulla consectetur perferendis eos autem adipisci deserunt mollitia maiores consequatur provident, voluptatibus dolore hic ratione voluptates officia enim? Repellendus quibusdam ducimus natus nesciunt. Temporibus alias quisquam quos! Deserunt quam alias facilis fugiat ullam vitae voluptate quis qui! Possimus laudantium quisquam laborum provident id adipisci amet itaque, mollitia necessitatibus quos unde facilis dignissimos libero voluptatum illum, non ad! Neque dicta rem debitis nihil tenetur quos, quo commodi aliquam odit.
                </div>
            </div>
            <div class="d-inline-block" style="width: 23%; margin-left: 1em">
                <div class="" style="box-sizing: border-box; width: 100%;text-align: center">
                    <h3 class="mb-5">Categories</h3>
                        @foreach ($blog->blogCategories as $blogCat)
                            <a href="{{url('category/'.$blogCat->category_id)}}" role="button" class="d-block btn mb-4" style="background-color: #eee;">
                                {{$blogCat->category->name}}
                            </a>
                        @endforeach
                </div>
            </div>
        </div>
    </div>
    @if (Auth::check())
    <div class="px-4" style="margin-top: 100px">
        <h4>Comment this blog</h4>
        <form action="{{url('blog/comment')}}" method="POST">
            @csrf
            <div class="d-inline-block w-75">
                <input type="hidden" name="blog_id" value="{{$blog->id}}">
                <textarea class="form-control shadow-sm" type="text" name="comment"
                style="height: 150px; font-size: 20px"></textarea>
                @error('comment')
                <div class="d-block invalid-feedback">{{$errors->first('comment')}}</div>
                @enderror
            </div>
            <div class="d-inline-block ps-1 pb-3" style="vertical-align: bottom">
                <button class="btn btn-primary" style="width: 100px" type="submit">Send</button>
            </div>
        </form>
    </div>
    @endif

    <div class="p-3" style="margin-top: 50px">
        <h5>Comments <span style="color: #888">({{$blog->comments->count()}})</span></h5>
        <div>
            {{$cms = $blog->comments()->orderBy('updated_at','desc')->paginate(10)}}
            @foreach ($cms as $cm)
                <div class="bg-white rounded shadow-sm p-3 mb-3" style="min-width: 300px; width: fit-content;">
                    @if (!empty(Auth::user()) && $cm->user_id == Auth::user()->id)
                    <a href="{{url('blog/comment/delete/'.$blog->id.'/'.$cm->id)}}" class="d-inline-block" style="float: right">
                        <i class="text-danger bi-trash-fill"></i>
                    </a>
                    @endif
                    <div style="font-size: 20px; font-weight: bold">
                        <i class="bi-person"></i><span class="ms-3">{{$cm->user->name}}</span>
                    </div>
                    <div>
                        <i class="bi-clock"></i><span class="ms-3">{{$cm->updated_at->format('d-M-Y H:i')}}</span>
                    </div>
                    <div class="pt-3 px-5 pb-1" style="color: #888">{{$cm->message}}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('writeblog')
    <a role="button" href="{{url('/blog/create')}}"
    style="font-size: 20px; background-color: #22a"
    class="text-white text-decoration-none py-2 px-3 rounded">+ Write your blog</a>
@endsection
