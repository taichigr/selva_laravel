<?php

namespace App\Http\Controllers;

use App\Product;
use App\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    //
    public function revieweditmanagement()
    {
        $reviews = Review::where('member_id', session()->get('member_id'))->paginate(5);
//        dd($reviews);
        return view('products.edit.review_management', ['reviews' => $reviews]);
    }
    public function revieweditshow(Request $request)
    {
//        dd($request->review_id);
        $review = Review::where('id', $request->review_id)->first();
        return view('products.edit.review_show', ['review' => $review]);
    }

    public function revieweditconfirm(Request $request)
    {
        $this->validate($request, [
            'review_id' => 'required',
            'evaluation' => 'required|in:1,2,3,4,5',
            'comment' => 'required|max:500',
        ]);
        $review = Review::where('id', $request->review_id)->first();
        return view('products.edit.review_confirm', [
            'review' => $review,
            'evaluation' => $request->evaluation,
            'comment' => $request->comment
        ]);
    }
    public function revieweditcomplete(Request $request)
    {
        $review = Review::where('id', $request->review_id)->first();

        $review->evaluation = $request->evaluation;
        $review->comment = $request->comment;
        $review->save();
        return redirect()->route('products.revieweditmanagement');
    }

    public function revieweditdeleteshow(Request $request)
    {
        $review = Review::where('id', $request->review_id)->first();
        return view('products.edit.review_delete_show', ['review' => $review]);
    }
    public function revieweditdelete(Request $request)
    {
        Review::where('id', $request->review_id)->delete();
        return redirect()->route('products.revieweditmanagement');
    }
}
