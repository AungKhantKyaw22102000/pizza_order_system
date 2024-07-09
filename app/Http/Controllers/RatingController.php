<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RatingController extends Controller
{
    // rating section
    public function ratingCreate(Request $request){
        $this->ratingCheckData($request);
        $rating = $this->ratingRequestData($request);
        Rating::create($rating);
        return back()->with(['createSuccess'=>'Your Rating has been Uploaded']);
    }

    // rating check data
    private function ratingCheckData($request){
        Validator::make($request->all(),[],[
            'ratingCount'=>'required',
        ])->validate();
    }

    // rating request data
    private function ratingRequestData($request){
        return([
            'user_id' => $request->userId,
            'product_id' => $request->productId,
            'rating_count' => $request->ratingCount,
            'message' => $request->ratingMessage,
        ]);
    }
}
