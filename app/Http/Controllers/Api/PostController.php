<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Post;
use App\Models\Media;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelpers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostDetailResource;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request){

        $query=Post::with('user','category','image')->orderByDesc('created_at');
        
        //for category filter
        if($request->category_id){

            $query->where('category_id',$request->category_id);
        }

        //for search
        $search=$request->search;
        if($request->search){

            $query->where('title','like','%'.$search.'%')
                  ->orWhere('description','like','%'.$search.'%');
        }

            
        $posts=$query->paginate(10);

        return PostResource::collection($posts)->additional(['message'=>'success']);
    }

    public function create(Request $request){
        //for validate
        $request->validate([
            'title'=>'required',
            'description'=>'required',
            'category_id'=>'required'
        ],
        [
            'category_id.required'=>'The category field is required',
        ]);

    DB::beginTransaction();
    
    try {

        //for image to upload if have
        if($request->hasFile('image')){
            $file=$request->file('image');
            $file_name=uniqid(time()).$file->getClientOriginalName();
            Storage::put('media/'.$file_name,file_get_contents($file));

        }
    
        $post=new Post();
        $post->title=$request->title;
        $post->description=$request->description;
        $post->category_id=$request->category_id;
        $post->save();
    
        // $post=Post::create([
        //     'titlee'=>$request->title,
        //     'description'=>$request->description,
        //     'category_id'=>$request->category_id
        // ]);

        Media::create([
            'file_name'=>$file_name,
            'file_type'=>'image',
            'model_id'=>$post->id,
            'model_type'=>Post::class,
        ]);

        DB::commit();

        return ResponseHelpers::success([],'Create Success!');
        
    } catch (Exception $e) {
        DB::rollBack();

        return ResponseHelpers::fail($e->getMessage());
    }
    
    }

    public function show($id){
        $post=Post::with('user','category','image')->where('id',$id)->first();
        return ResponseHelpers::success(new PostDetailResource($post));
    }
}