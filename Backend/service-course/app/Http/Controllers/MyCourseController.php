<?php

namespace App\Http\Controllers;
use App\{Course,MyCourse,Review};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MyCourseController extends Controller
{
    public function index(Request $request)
    {
        $MyCourse = MyCourse::query()->with('course');
        $user_id = $request->user_id;
        $MyCourse->when($user_id, function($query) use($user_id){
            return $query->where('user_id','=',$user_id);
        });
        
            return response()->json([
                 'status' => 'success',
                'message' => $MyCourse->get()
            ]);
    }


    public function create(Request $request)
    {
        $rules =[
            'course_id' => 'required|integer',
            'user_id' => 'required|integer'
        ];

        $data = $request->all();

        $validator = Validator::make($data,$rules);
        if($validator->fails())
        {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()
            ],400);
        }

        $courseId = $request->course_id;
        $course = Course::find($courseId);
        if(!$course)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'course not found'
            ],404);
        }

        $userId = $request->user_id;
        $user = getUser($userId);
        if($user['status'] === 'error')
        {
            return response()->json([
                'status' => $user['status'],
                'message' => $user['message']
            ],$user['http_code']);
        }

        $isExist = MyCourse::where('course_id','=',$courseId)->where('user_id','=',$userId)->exists();
        if($isExist)
        {
              return response()->json([
                'status' => 'error',
                'message' => 'user already taken this course'
            ],409);
        }
        $MyCourse = MyCourse::create($data);
        return response()->json([
            'status' => 'success',
            'data' => $MyCourse
        ]);
    }
}
