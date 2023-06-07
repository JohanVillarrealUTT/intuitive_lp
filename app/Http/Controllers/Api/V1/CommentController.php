<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Entities\Comment;

class CommentController extends Controller
{
   
    
    public function store(Request $request)
    {
        if (!is_array($request->all())) {
            return ['error' => 'request must be an array'];
        }

        $rules = [
            'comment' => 'required',
            'subscriber_id' => 'required',
            'user_id' => 'required'
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response(['created' => false,'errors'  => $validator->errors()->all()], 422);
            }

            $comment = Comment::create($request->all());

            return response(['created' => true, 'comment' => $comment], 200)->header('Content-Type', 'application/json');

        } catch (Exception $e) {

            \Log::info('Error creating comment: ' . $e);

            return \Response::json(['created' => false], 500);
        }
    }

    public function update(Request $request, $comment)
    {

        $rules = [
            'comment' => 'required',
            'user_id' => 'required'
        ];

        try {

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response(['created' => false,'errors'  => $validator->errors()->all()], 422);
            }

            $comment->update(['comment' => $request->comment, 'user_id' => $request->user_id]);

            return response(['updated' => true], 200)->header('Content-Type', 'application/json');

        } catch (Exception $e) {

            \Log::info('Error creating comment: ' . $e);

            return \Response::json(['created' => false], 500);
        }
    }

  
}
