<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FAQController extends Controller
{

    public function index()
    {
        $data['page_title'] = 'Create & Manage FAQ';
        $data['faqs'] = Faq::query()->get();
        return view('admin.settings.faq', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:10',
        ]);

        $data = $request->only('title', 'description');
        $data['description'] = clean($data['description']);

        if (Faq::create($data)) {
            return redirect()->route('admin.faq')->with('primary', 'Faq Created Successfully!');
        }
        return back()->with('danger', 'Unable to Create FAQ!');
    }

    public function show(Faq $faq)
    {
        $data['page_title'] = 'Edit FAQ | ' . $faq->title;
        $data['faq'] = $faq;
        return view('admin.settings.edit-faq', $data);
    }

    public function edit(Request $request, Faq $faq)
    {
        $request->validate([
            'title' => 'required|string|min:5',
            'description' => 'required|string|min:10',
        ]);

        $data = $request->only('title', 'description');
        
        $response = $faq->update([
            'title' => $data['title'],
            'description' => clean($data['description']),
        ]);

        if ($response) {
            return redirect()->route('admin.faq')->with('primary', 'FAQ Edited Successfully!');
        }
        return back()->with('danger', 'Unable to Edit FAQ!');
    }

    public function delete(Faq $faq)
    {
        if ($faq->delete()) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

}
