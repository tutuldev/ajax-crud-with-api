<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\API\ComController as ComController;

class PostController extends ComController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::all();
        // return response()->json([
        //     'status'=>true,
        //     'message'=>'All Post Data',
        //     'data'=> $data,
        // ],200);
        return $this->sendResponse($data,'All Post Data.');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateUser= Validator::make(
            $request->all(),
            [
                     'title'=>'required',
                     'description'=> 'required',
                     'image'=>'required|mimes:png,jpg,jpeg,gif',
                    ]
            );
            if($validateUser->fails()){
                // return response()->json([
                //     'status'=>false,
                //     'message'=>'Validation Error',
                //     'error'=> $validateUser->errors()->all()
                // ],401);
        return $this->sendError('Validation Error',$validateUser->errors()->all());

            }
            $img = $request->image;
            $text= $img->getClientOriginalExtension();
            $imageName = time(). '.' . $text;
            $img->move(public_path(). '/uploads', $imageName);

            $post = Post::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'image'=>$imageName,
            ]);
            return $this->sendResponse($post,'Post created Successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Post::select(
            'id',
            'title',
            'description',
            'image',

        )->where(['id'=>$id])->get();


        return $this->sendResponse($data,'Your Singel Post.');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validateUser= Validator::make(
            $request->all(),
            [
                'title'=>'required',
                'description'=> 'required',
                'image'=>'nullable|image|mimes:png,jpg,jpeg,gif',
            ]
        );

        if($validateUser->fails()){
            return $this->sendError('Validation Error', $validateUser->errors()->all());
        }

        $post = Post::find($id);

        if(!$post){
            return $this->sendError('Error', ['Post not found']);
        }

        if ($request->hasFile('image')) {
            $path = public_path() . '/uploads';

            // পুরোনো ছবি ডিলিট করা
            if ($post->image && file_exists($path . '/' . $post->image)) {
                unlink($path . '/' . $post->image);
            }

            $img = $request->file('image');
            $imageName = time() . '.' . $img->getClientOriginalExtension();
            $img->move($path, $imageName);
        } else {
            $imageName = $post->image; // আগের ইমেজ ঠিক রাখার জন্য
        }

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return $this->sendResponse($post, 'Post Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imagePath= Post::select('image')->where('id',$id)->get();
        $filePath = public_path(). '/uploads/' . $imagePath[0]['image'];

        unlink($filePath);

        $post = Post::where('id',$id)->delete();


        return $this->sendResponse($post,'Your Post Deleted Successfully');

    }
}
