<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use App\Http\Requests\BlogRequest;
use App\Http\Requests\BlogRequest_edit;
use App\Models\BlogCategory;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Favourite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ContentController extends Controller
{
    public function index(){
        $blogs = Blog::get();
        if(!empty(Auth::user())){
            $blogs = $blogs->where('user_id','!=',Auth::user()->id);
        }
        $blogs = $blogs->sortByDesc('updated_at');
        return view('content.home',['title'=>'All Blogs','blogs'=>$blogs]);
    }
    public function search(Request $request){
        $text = $request->search;
        $blogs = Blog::get();
        if(!empty(Auth::user())){
            $blogs = $blogs->where('user_id','!=',Auth::user()->id);
        }
        if($text != ''){
            $blogs = $blogs->filter(function($blog) use($text){
                return Str::contains($blog->topic,$text,true);
            });
        }
        $blogs = $blogs->sortByDesc('updated_at');
        return view('content.home',['title'=>'Search for ','blogs'=>$blogs,'titleValue'=>$text,'text'=>$text]);
    }
    public function myBlog(){
        $blogs = Auth::user()->blogs->sortByDesc('updated_at');
        return view('content.myBlog',['blogs'=>$blogs]);
    }
    public function viewCategory($id){
        $blogCats = BlogCategory::whereRelation('blog','user_id','!=',Auth::user()->id)->where('category_id',$id)->get();
        $blogs = $blogCats->map(function ($item){
            return $item->blog;
        });
        $blogs = $blogs->sortByDesc('updated_at');
        $cat = Category::findOrFail($id);
        return view('content.home',['title'=>'Category','blogs'=>$blogs,'titleValue'=>$cat->name]);
    }
    public function showFavourite(){
        $favs = Favourite::where('user_id',Auth::user()->id)->get();
        $blogs = $favs->map(function($item){
            return $item->blog;
        });
        $blogs = $blogs->sortByDesc('updated_at');
        return view('content.home',['title'=>'Favourite','blogs'=>$blogs]);
    }

    public function createBlog(){
        $blog = new Blog();
        $cats = Category::all();
        return view('content.write_blog',['blog'=>$blog,'cats'=>$cats]);
    }
    public function storeBlog(BlogRequest $request){
        $blog = new Blog();
        $this->saveBlog($blog,$request);
        return redirect('/myblog');
    }

    public function editBlog($id){
        $blog = Blog::findOrFail($id);
        $cats = Category::all();
        return view('content.write_blog',['blog'=>$blog,'cats'=>$cats]);
    }
    public function updateBlog(BlogRequest_edit $request, $id){
        $blog = Blog::findOrFail($id);
        $this->saveBlog($blog,$request);
        return redirect('/myblog');
    }
    public function saveBlog($blog,$value){
        date_default_timezone_set("Asia/Bangkok");
        $blog->user_id = Auth::user()->id;
        $blog->topic = $value->topic;
        $blog->content = $value->content;
        if(empty($blog->image_name)){
            $name = $value->file('image')->hashName();
            $value->file('image')->storeAs('public/images/',$name);
            $blog->image_name = $name;
        }else{
            if($value->hasFile('image')){
                $oldImage = $blog->image_name;;
                unlink(storage_path('app/public/images/'.$oldImage));
                $name = $value->file('image')->hashName();
                $value->file('image')->storeAs('public/images/',$name);
                $blog->image_name = $name;
            }
        }
        $blog->save();

        $this->addCategories($blog->id,$value->cats);
    }
    public function addCategories($blog_id,$values){
        if(!empty($values)){
            $blog = Blog::findOrFail($blog_id);
            if(!$blog->blogCategories->isEmpty()){
                $blog->blogCategories()->delete();

            }
            foreach($values as $value){
                $cat = new BlogCategory();
                $cat->blog_id = $blog_id;
                $cat->category_id = $value;
                $cat->save();
            }
        }
    }
    public function deleteBlog($id){
        $blog = Blog::findOrFail($id);
        $blog->favourites()->delete();
        $blog->comments()->delete();
        $blog->blogCategories()->delete();
        unlink(storage_path('app/public/images/'.$blog->image_name));
        $blog->delete();
        return back();
    }



    public function favourite(Request $request){
        $userid = Auth::user()->id;
        $id = $request->blog_id;
        $fav = Favourite::where('blog_id',$id)->where('user_id',$userid)->get();
        if($fav->isEmpty()){
            $favourite = new Favourite();
            $favourite->user_id = $userid;
            $favourite->blog_id = $id;
            $favourite->save();
        }else{
            $fav->first()->delete();
        }
        return back();

    }

    public function showBlog($id){
        $blog = Blog::findOrFail($id);
        return view('content.blog',['blog'=>$blog]);
    }

    public function createComment(Request $request){
        $request->validate([
            'comment' => 'required'
        ]);

        $comment = new Comment();
        $comment->user_id = Auth::user()->id;
        $comment->blog_id = $request->blog_id;
        $comment->message = $request->comment;
        $comment->save();
        return redirect('/blog/'.$request->blog_id);
    }
    public function deleteComment($blog_id,$comm_id){
        $comment = Comment::findOrFail($comm_id);
        $comment->delete();
        return redirect('/blog/'.$blog_id);
    }

}

