<?php

namespace App\Http\Controllers;

use App\Models\Apptitle;
use App\Models\Cast;
use App\Models\Footertext;
use App\Models\Seosetting;
use Illuminate\Http\Request;

class ManufactDashboard extends Controller
{
    public function index()
    {
        $seopage = Seosetting::first();
        $title = Apptitle::first();
        $data['title'] = $title;
        $data["castes_pending"] = Cast::where("status", "pending")->get();
        $data["castes_scrap"] = Cast::where("status", "scrap")->get();
        $data["castes_validate"] = Cast::where("status", "repair")->get();
        $data["castes_repair"] = Cast::where("status", "validated")->get();
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
        $data['seopage'] = $seopage;


        return view("manufact.dashboard")->with($data);
    }
}
