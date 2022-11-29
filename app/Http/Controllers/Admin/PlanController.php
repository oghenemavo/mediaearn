<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\IPlan;
use App\Http\Controllers\Controller;
use App\Http\Requests\PlanCreateRequest;
use App\Http\Requests\PlanEditRequest;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function __construct(protected IPlan $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function index()
    {
        $data['page_title'] = 'Create & Manage Plans';
        $data['plans'] = Plan::query()->get();
        return view('admin.settings.plans', $data);
    }

    public function store(PlanCreateRequest $request)
    {
        $data = $request->validated();

        if ($this->planRepository->create($data)) {
            return redirect()->route('admin.plans')->with('primary', 'Plan Created Successfully!');
        }
        return back()->with('danger', 'Unable to Create Plan!');
    }

    public function show(Plan $plan)
    {
        $data['page_title'] = 'Edit Plan | ' . $plan->title;
        $data['plan'] = $plan;
        return view('admin.settings.edit-plan', $data);
    }

    public function edit(PlanEditRequest $request, Plan $plan)
    {
        $data = $request->validated();
        if ($this->planRepository->edit($data, $plan)) {
            return redirect()->route('admin.plans')->with('primary', 'Plan Edited Successfully!');
        }
        return back()->with('danger', 'Unable to Edit Plan!');
    }

    public function deactivate(Plan $plan)
    {
        $status = '0';
        if ($this->planRepository->changeStatus($status, $plan)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }

    public function activate(Plan $plan)
    {
        $status = '1';
        if ($this->planRepository->changeStatus($status, $plan)) {
            return response()->json(['success' => true]);
        }
        return response()->json(['fail' => true]);
    }
}
