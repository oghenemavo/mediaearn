<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\IVideo;
use App\Enums\VideoTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoEditRequest;
use App\Http\Requests\VideoRequest;
use App\Models\Category;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File as FacadesFile;

class VideoController extends Controller
{
    public function __construct(protected IVideo $videoRepository)
    {
        $this->videoRepository = $videoRepository;
    }

    public function categories()
    {
        $data['page_title'] = 'Create & Manage Categories';
        return view('admin.media.categories', $data);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'category' => 'required|min:3|unique:categories'
        ]);

        $data = $request->only('category');

        $data['slug'] = Str::of($data['category'])->slug('-');

        $result = Category::create($data);
        if ($result) {
            return back()->with('primary', 'Categories Created Successfully!');
        }
        return back()->with('danger', 'Unable to Create Category!');
    }

    public function editCategory(Request $request, Category $category)
    {
        $rules = [
            'category' => [
                'required',
                'min:3',
                Rule::unique('categories')->ignore($category->id)
            ],
        ];
        $request->validate($rules);
        
        $category->category = $request->category;
        $category->slug = Str::of($request->category)->slug('-');

        if ($category->save()) {
            return response()->json(['success' => true]);
        }
        return back()->with('danger', 'Unable to Update Category!');
    }

    public function videos()
    {
        $data['page_title'] = 'Create & Manage Videos';
        $data['categories'] = Category::query()->get();
        $data['video_types'] = VideoTypeEnum::cases();
        return view('admin.media.videos', $data);
    }

    public function createVideo(VideoRequest $request)
    {
        $data = $request->validated();

        if ($this->videoRepository->createVideo($data)) {
            return redirect()->route('admin.media.videos')->with('primary', 'Video Created Successfully!');
        }
        return back()->with('danger', 'Unable to Create Video!');
    }

    public function showVideo(Video $video)
    {
        $data['page_title'] = 'Edit Video | ' . $video->title;
        $data['categories'] = Category::query()->get();
        $data['video_types'] = VideoTypeEnum::cases();
        $data['video'] = $video;
        return view('admin.media.edit-video', $data);
    }

    public function editVideo(VideoEditRequest $request, Video $video)
    {
        $data = $request->validated();
        if ($this->videoRepository->editVideoPost($data, $video)) {
            if ($request->hasfile('cover')) {
                $initial_path = public_path('/covers') . $video->cover;
                if (FacadesFile::exists($initial_path)) {
                    FacadesFile::delete($initial_path);
                }
            }
    
            if ($request->hasfile('video_file')) {
                $initial_path = public_path('/videos') . $video->url;
                if (FacadesFile::exists($initial_path)) {
                    FacadesFile::delete($initial_path);
                }
            }

            return redirect()->route('admin.media.videos')->with('primary', 'Video Edited Successfully!');
        }
        return back()->with('danger', 'Unable to Edit Video!');
    }

}
