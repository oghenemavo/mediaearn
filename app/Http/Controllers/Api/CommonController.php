<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getCategories()
    {
        $category_collection = Category::get();
        return response()->json(['categories' => $category_collection]);
    }

    public function validateUniqueCategory(Request $request)
    {
        $inp_category = $request->get('category');
        $ignore_id = $request->get('ignore_id') ?? null;
        
        $category = new Category();
        $is_valid = ! $category->categoryExists($inp_category, $ignore_id);
        echo json_encode($is_valid);
    }

    public function getVideos()
    {
        $video_collection = Video::get();
        $mapped_videos = $video_collection->map(function($item, $key) {
            $data['id'] = $item->id;
            $data['title'] = $item->title;
            $data['slug'] = $item->slug;
            $data['category'] = $item->category->category;
            $data['description'] = htmlspecialchars_decode($item->description);
            $data['url'] = $item->url;
            $data['video_url'] = $item->video_url;
            $data['cover'] = $item->cover;
            $data['length'] = $item->length;
            $data['charges'] = $item->charges;
            $data['earnable'] = $item->earnable;
            $data['earnable_ns'] = $item->earnable_ns ?? '0.00';
            $data['earned_after'] = $item->earned_after;
            $data['status'] = $item->status;
            $data['created_at'] = $item->created_at;

            return $data;
        });
        return response()->json(['videos' => $mapped_videos]);
    }
}
