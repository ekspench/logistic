<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\Cast;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CastController extends Controller
{
    public function getCastList(Request $request)
    {
       
        $from = date($request->min);
        $to = date($request->max);
        $data = Cast::where("status", "!=", "peding")->whereBetween('created_at', [$from, $to])->orderByDesc("created_at")->get();
        
        return DataTables::of($data)
            ->addColumn('reference', function ($data) {
                return $data->box->part->reference;
            })
            ->addColumn('number', function ($data) {
                return $data->box->number;
            })
            ->addColumn('mark', function ($data) {
                return $data->mark;
            })
            ->addColumn('status', function ($data) {
                if ($data->status == "validated") {
                    return '<span class="badge bg-success"> Validée </span>';
                } else  if ($data->status == "scrap") {
                    return '<span class="badge bg-warning">Rebut</span>';
                } else     if ($data->status == "repair") {
                    return '<span class="badge bg-warning"> En reparation</span>';
                } else  {
                    return '<span class="badge bg-danger"> ux/rx</span>';
                }
            })
            ->addColumn('replace', function ($data) {
                return $data->mark_replace;
            })
            ->addColumn('date', function ($data) {
                return  $data->created_at;
            })


            ->rawColumns(['reference', 'number', 'mark', 'status', 'replace','date'])
            ->make(true);
    }
}
