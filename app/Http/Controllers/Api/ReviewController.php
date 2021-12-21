<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index($user_id){
        $reviews = Review::where('user_id', $user_id)->get();

        if(!is_null($reviews)){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reviews
            ], 200);
        }

        return response([
            'message' => 'No Review',
            'data' => $reviews
        ], 200);
    }

    public function store(Request $request, $user_id){
        $newReview = $request->all();

        $newReview['user_id'] = $user_id;
        
        $validate = Validator::make($newReview, [
            'user_id' => 'required',
            'points' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if(is_null($newReview['comments']))
            $newReview['comments'] = "no comments...";

        $review = Review::create($newReview);
        return response([
            'message' => 'Add Review Success',
            'data' => $review
        ], 200);
    }

    public function update(Request $request, $id){
        $review = Review::find($id);

        if(is_null($review)){
            return response([
                'message' => 'Review Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();

        $validate = Validator::make($updateData, [
            'points' => 'required'
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        if(is_null($updateData['comments']))
            $updateData['comments'] = "no comments...";

        $review->points = $updateData['points'];
        $review->comments = $updateData['comments'];

        if($review->save()){
            return response([
                'message' => 'Update Review Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'Update Review Failed',
            'data' => null
        ], 400);
    }

    public function destroy($id){
        $review = Review::find($id);

        if(is_null($review)){
            return response([
                'message' => 'Review Not Found',
                'data' => null
            ], 404);
        }

        if($review->delete()){
            return response([
                'message' => 'Delete Review Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'Delete Review Failed',
            'data' => null
        ], 400);
    }
}
