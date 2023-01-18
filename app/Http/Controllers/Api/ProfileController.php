<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProfileResource;

class ProfileController extends Controller
{
    public function profile(){
        $user=Auth::user();
        
        return ResponseHelpers::success(new ProfileResource($user));
    }

    public function posts(Request $request){

        $query=Post::with('user','category','image')->orderByDesc('created_at')->where('user_id',auth()->user()->id);
        
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
}