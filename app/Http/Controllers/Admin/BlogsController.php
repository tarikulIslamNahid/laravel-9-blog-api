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
    public function WebPosts()
    {
        try{
            $blogs= blogs::where('status',1)->orderBy('created_at','desc')->with('category')->get();
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
    public function show($slug)
    {
        try{
            $blogs= blogs::where('slug',$slug)->with('category')->get();
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
    public function webPostShow($slug)
    {
        try{
            $blogs= blogs::where(['slug'=>$slug,'status'=>1])->with('category')->get();
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, blogs $blogs)
    {
        try {
            $validator = Validator::make($request->all(), [
                'title'=>['required','string'],
                'description'=>['required','string'],
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'data'=>$validator->errors(), 422]);
            } else {
       $blogs= blogs::findOrFail($request->id);
       if($blogs){
        if($request->title!=$blogs->title){
            $blogs->slug=blogs::uniqueSlug($request->title);
        }
        $blogs->title=$request->title;
        $blogs->description=$request->description;
        $blogs->update();
        $cat_id= substr($request->cat_id, 0, -1);
        $blogCatArr=explode(',', $cat_id);
        $blogs->category()->detach();
        $blogs->category()->attach($blogCatArr);
        return response()->json([
            'success'=>true,
            'data'=>'post Updated Successfully !',
        ]);
       }
       }

} catch (Exception $e) {
    return response()->json([
        'success'=>false,
        'data'=>$e->getMessage(),
    ]);
}
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
        $blogs=blogs::findOrFail($id)->delete();
        if($blogs){
        blogCategories::where('blog_id',$id)->delete();
            return response()->json([
                'success'=>true,
                'data'=>'Post Delete Successfully !',
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'data'=>'Some Problem Found !',
            ]);
        }
    } catch (Exception $e) {
        return response()->json([
            'success'=>false,
            'data'=>$e->getMessage(),
        ]);
    }
    }

    public function status($id)
    {
        try {

            $blogs = blogs::findOrFail($id);
        if ($blogs->status == 1) {
            $blogs->status = 0;
            $success = 'Deactived Successfully';
        } elseif ($blogs->status == 0) {
            $blogs->status = 1;
            $success = 'Activeted Successfully';
        }
        $blogs->update();
        return response()->json([
            'success'=>true,
            'data'=>$success,
        ]);
    } catch (Exception $e) {
        return response()->json([
            'success'=>false,
            'data'=>$e->getMessage(),
        ]);
    }

    }
}
