<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{

            $categories= Category::orderBy('id','desc')->get();
            if($categories){
                return response()->json([
                    'success'=>true,
                    'data'=>$categories,
                ]);
            }
        }catch(Exception $e){
            return response()->json([
                'success'=>false,
                'data'=>$e->getMessage(),
            ]);
        }

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'cat_name'=>['required','string','unique:categories'],
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'data'=>$validator->errors(), 422]);
            } else {
                $category= new Category;
                $category->cat_name=$request->cat_name;
                $category->cat_slug=Category::uniqueSlug($request->cat_name);
                $category->save();
                return response()->json([
                    'success'=>true,
                    'data'=>'Category Created Successfully !',
                ]);
            }

        } catch (Exception $e) {
            return response()->json([
                'success'=>false,
                'data'=>$e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
