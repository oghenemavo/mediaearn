<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Create & Manage Promotions';
        return view('admin.media.promotions', $data);
    }

    public function store(PromotionRequest $request)
    {
        $data = $request->validated();

        if ($request->hasfile('material')) {
            $promotion = $request->file('material');
            $promotionFile =  uniqid('promotion_') . '.' . $promotion->extension();

            $promotion->move(public_path('/promotions'), $promotionFile);
            $data['material'] = $promotionFile;
            $time = strtotime($data['expiry_date'] . ' ' . $data['expiry_time']);
            $data['expires_at'] = date('Y-m-d h:i:s.u', $time);
    
            $result = Promotion::create($data);
            if ($result) {
                return redirect()->route('admin.media.promotions')->with('primary', 'Promotion Created Successfully!');
            }
        }

        return back()->with('danger', 'Unable to Create Promotion!');
    }
}
