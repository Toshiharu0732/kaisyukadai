<?php

namespace App\Http\Controllers\Authenticated\BulletinBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categories\MainCategory;
use App\Models\Categories\SubCategory;
use App\Models\Posts\Post;
use App\Models\Posts\PostComment;
use App\Models\Posts\Like;
use App\Models\Users\User;
use App\Http\Requests\BulletinBoard\PostFormRequest;
use App\Http\Requests\BulletinBoard\PostEditFormRequest;
use App\Http\Requests\BulletinBoard\MainCategoryFormRequest;
use App\Http\Requests\BulletinBoard\SubCategoryFormRequest;
use Auth;

class PostsController extends Controller
{
    public function show(Request $request){
        //いいね数の表示、PostsController.phpにてwithCountメソッドを使用する方法↓
        $posts = Post::with('user', 'postComments')->withCount('likes')->get();
        $categories = MainCategory::get();
        $sub_categories = SubCategory::get();
        $like = new Like;
        $post_comment = new Post;
        if(!empty($request->keyword)){
            $posts = Post::with('user', 'postComments')->withCount('likes')
            ->where('post_title', 'like', '%'.$request->keyword.'%')
            ->orWhere('post', 'like', '%'.$request->keyword.'%')->get();
        }else if($request->category_word){
            $sub_category =
            $request->category_word;
            $posts = Post::with('user', 'postComments')->withCount('likes')->get();
        }else if($request->like_posts){
            $likes = Auth::user()->likePostId()->get('like_post_id');
            $posts = Post::with('user', 'postComments')->withCount('likes')
            ->whereIn('id', $likes)->get();
        }else if($request->my_posts){
            $posts = Post::with('user', 'postComments')->withCount('likes')
            ->where('user_id', Auth::id())->get();
        }
        return view('authenticated.bulletinboard.posts', compact('posts', 'categories', 'like', 'post_comment','sub_categories'));
    }

    public function postDetail($post_id){
        $post = Post::with('user', 'postComments')->findOrFail($post_id);
        return view('authenticated.bulletinboard.post_detail', compact('post'));
    }

    public function postInput(){
        $main_categories = MainCategory::get();
        $main_categories_id =MainCategory::get()->pluck('id');
        $sub_categories = SubCategory::with('mainCategory')->whereIn('main_category_id',$main_categories_id)->get();
        //$sub_categories = SubCategory::get();
        return view('authenticated.bulletinboard.post_create',compact('main_categories','sub_categories'));
    }

    public function postCreate(PostFormRequest $request){
        $post = Post::create([
            'user_id' => Auth::id(),
            'post_title' => $request->post_title,
            'post' => $request->post_body
        ]);
        return redirect()->route('post.show');
    }

    public function postEdit(PostEditFormRequest $request){
        Post::where('id', $request->post_id)->update([
            'post_title' => $request->post_title,
            'post' => $request->post_body,
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function postDelete($id){
        Post::findOrFail($id)->delete();
        return redirect()->route('post.show');
    }
    public function mainCategoryCreate(MainCategoryFormRequest $request){
        MainCategory::create(['main_category' => $request->main_category_name]);
        return redirect()->route('post.input');
    }

    public function subCategoryCreate(SubCategoryFormRequest $request){
        //↓save()を使った登録方法

        //$sub= new SubCategory;
        //$sub-> main_category_id=$request->main_category_id;
       // $sub->sub_category=$request->sub_category_name;
        //$sub->save();

        SubCategory::create([
            'main_category_id' => $request->main_category_id,
            'sub_category'=>$request->sub_category_name]);
        return redirect()->route('post.input');
    }

    public function commentCreate(Request $request){
        PostComment::create([
            'post_id' => $request->post_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);
        return redirect()->route('post.detail', ['id' => $request->post_id]);
    }

    public function myBulletinBoard(){
        $posts = Auth::user()->posts()->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_myself', compact('posts', 'like'));
    }

    public function likeBulletinBoard(){
        $like_post_id = Like::with('users')->where('like_user_id', Auth::id())->get('like_post_id')->toArray();
        $posts = Post::with('user')->whereIn('id', $like_post_id)->get();
        $like = new Like;
        return view('authenticated.bulletinboard.post_like', compact('posts', 'like'));
    }

    public function postLike(Request $request){
        Auth::user()->likes()->attach($request->post_id);
        return response()->json();
    }

    public function postUnLike(Request $request){
        Auth::user()->likes()->detach($request->post_id);
        return response()->json();
    }
}
