<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionEditRequest;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;

class PromotionController extends Controller
{
    public function index()
    {
        $data['page_title'] = 'Create & Manage Promotions';
        return view('admin.media.promotions', $data);
    }

    public function homeAd()
    {
        $data['page_title'] = 'Create & Manage Homepage Ad';
        return view('admin.media.homepage-ad', $data);
    }

    public function createHomeAd(Request $request)
    {
        $rule = [
            'material' => 'required|mimes:jpeg,png,jpg,gif,svg',
        ];
        $data = [];

        $request->validate($rule);

        if ($request->hasfile('material')) {
            $promotion = $request->file('material');
            $promotionFile =  uniqid('promotion_') . '.' . $promotion->extension();
            $title = 'home_ad';

            $promotion->move(public_path('/promotions'), $promotionFile);

            $ad = Promotion::where('title', $title)->where('status', '0')->get()->first();

            if ($ad) {
                $initial_path = public_path('/promotions') . $ad->material;
                if (FacadesFile::exists($initial_path)) {
                    FacadesFile::delete($initial_path);
                }

                $ad->material = $promotionFile;
                $result = $ad->save();
            } else {
                $data['title'] = 'home_ad';
                $data['material'] = $promotionFile;
                $data['expires_at'] = Carbon::now()->year(2009);
                $result = Promotion::create($data);
            }

            if ($result) {
                return redirect()->route('admin.media.home.promotions')->with('primary', 'Promotion Created Successfully!');
            }
        }

        return back()->with('danger', 'Unable to Create Promotion!');
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

    public function show(Promotion $promotion)
    {
        $data['page_title'] = 'Edit Promotion';
        $data['promotion'] = $promotion;

        $imageExtensions = ['jpeg','png','jpg','gif','svg',];
        $ext = explode('.', $promotion->material);
        $materialExtension = strtolower(array_pop($ext));
        $data['is_image'] = in_array($materialExtension, $imageExtensions);

        return view('admin.media.edit-promotion', $data);
    }

    public function edit(PromotionEditRequest $request, Promotion $promotion)
    {
        $data = $request->validated();

        if ($request->hasfile('material')) {
            $promotionFileObject = $request->file('material');
            $promotionFile =  uniqid('promotion_') . '.' . $promotionFileObject->extension();

            $promotionFileObject->move(public_path('/promotions'), $promotionFile);

            $initial_path = public_path('/promotions') . $promotion->material;
            if (FacadesFile::exists($initial_path)) {
                FacadesFile::delete($initial_path);
            }
            $data['material'] = $promotionFile;
        }

        $time = strtotime($data['expiry_date'] . ' ' . $data['expiry_time']);
        $data['expires_at'] = date('Y-m-d h:i:s.u', $time);

        if ($promotion->update($data)) {
            return redirect()->route('admin.media.promotions')->with('primary', 'Promotion edited Successfully!');
        }
        return back()->with('danger', 'Unable to Edit Promotion!');
    }

    public function unblock(Promotion $promotion)
    {
        $promotion->status = '1';

        $result = $promotion->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

    public function block(Promotion $promotion)
    {
        $promotion->status = '0';

        $result = $promotion->save();
        if ($result) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }
}
