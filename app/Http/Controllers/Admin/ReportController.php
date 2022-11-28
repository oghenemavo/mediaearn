<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function referrals()
    {
        $data['page_title'] = 'All Referrals';
        return view('admin.reports.referral', $data);
    }
}
