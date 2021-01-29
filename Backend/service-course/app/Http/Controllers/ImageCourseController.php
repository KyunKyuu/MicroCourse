<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Course,ImageCourse};
use Illuminate\Support\Facades\Validator;
class ImageCourseController extends Controller
{

    public function create(Request $request)
    {
        $rules = [
            'image' => 'required|url',
            'course_id' => 'required|integer'
        ];
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }
        $course_id = $request->course_id;
        $course = Course::find($course_id);
        if(!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ],404); 
        }

        $ImageCourse = ImageCourse::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $ImageCourse
        ]);
    }

    public function destroy($id)
    {   
        $image = ImageCourse::find($id);
        if(!$image)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'image not found'
            ],404); 
        }
        $image->delete();
        return response()->json([
                'status' => 'success',
                'message' => 'image has deleted'
            ],404); 
    }
}
