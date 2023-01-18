<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelpers;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::orderBy('name')->get();
        return ResponseHelpers::success(CategoryResource::collection($categories));
    }
}