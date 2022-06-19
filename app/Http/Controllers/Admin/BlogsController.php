<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin\blogCategories;
use App\Models\Admin\blogs;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $blogs= blogs::orderBy('created_at','desc')->with('category')->get();
            if($blogs){
                return response()->json([
                    'success'=>true,
                    'data'=>$blogs,
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
                'title'=>['required','string','unique:blogs'],
                'description'=>['required','string'],
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'data'=>$validator->errors(), 422]);
            } else {
                $blogs= new blogs;
                $blogs->title=$request->title;
                $blogs->description=$request->description;
                $blogs->created_by=Auth()->user()->id;
                $blogs->slug=blogs::uniqueSlug($request->title);
                $blogs->save();
                $cat_id= substr($request->cat_id, 0, -1);
                $blogCatArr=explode(',', $cat_id);
                $blogs->category()->attach($blogCatArr);
                // foreach ($blogCatArr as $key => $id) {
                //     $blogCategories= new blogCategories;
                //     $blogCategories->cat_id=$id;
                //     $blogCategories->blog_id=$blogs->id;
                //     $blogCategories->save();
                // }
                return response()->json([
                    'success'=>true,
                    'data'=>'Post Created Successfully !',
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
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function show(blogs $blogs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(blogs $blogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, blogs $blogs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(blogs $blogs)
    {
        //
    }
}
