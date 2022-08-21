<?php

namespace App\Http\Controllers;

use App\Models\Apptitle;
use App\Models\Box;
use App\Models\Cast;
use App\Models\Footertext;
use App\Models\Part;
use App\Models\Seosetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Dompdf\Dompdf;
class BoxController extends Controller
{
    public function index()
    { 
        $seopage = Seosetting::first();
        $title = Apptitle::first();
        $data['title'] = $title;
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $data['seopage'] = $seopage;
        return view("manufact.box.index")->with($data);
    }

    public function getBoxList(Request $request)
    {
        $data = Box::get();

        return DataTables::of($data)
            ->addColumn('part_ref', function ($data) {
                return $data->part->reference;
            })
            ->addColumn('box_number', function ($data) {
                return $data->number;
            })
            ->addColumn('quantity', function ($data) {
                return count($data->castes);
            })
            ->addColumn('quantity_pending', function ($data) {
                return count($data->castes);
            })
            ->addColumn('quantity_conforme', function ($data) {
                return count($data->castes_conforme);
            })
            ->addColumn('quantity_no_conforme', function ($data) {
                return count($data->castes_no_conforme);
            })
            ->addColumn('status', function ($data) {

                if ($data->is_valid) {
                    return '<span  class="badge w-100 bg-success">Controlé</span>';
                } else {
                    return '<span class="badge w-100 bg-warning">En attente</span>';
                }
            })
            ->addColumn('action', function ($data) {
              
                return '<a href="'.url('manufact/box/detail/' . $data->id).'" class="s edit-testimonial"><i class="feather feather-eye text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Edit" aria-label="Edit"></i></a>';
            })
            ->rawColumns(['part_ref', 'box_number', 'quantity', 'quantity_conforme', 'quantity_conforme', 'status', 'action'])
            ->make(true);
    }


    public function create(Request $request)
    {
        $seopage = Seosetting::first();
        $title = Apptitle::first();
        $data['title'] = $title;
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $data['seopage'] = $seopage;

        $parts = Part::get();
        $part = Part::find($request->part_ref);
        $box = Box::get();
        $data['parts'] = $parts;
        $data['part'] = $part;
        $data['box'] = $box;

        return view('manufact.box.create')->with($data);;
    }

    public function createBox(Request $request)
    {
        
        $box = Box::create(["part_id" => $request->part_id, "number" => $request->box_number,'machinist_id'=>$request->user()->id]);
        $box->ref = "D" . Carbon::now()->format("dmy") . $box->id;
        $box->save();

        foreach ($request->casts as $key => $cast) {
            for ($i = 1; $i <= $cast["quantity"]; $i++) {
                Cast::create(["mark" => $cast["mark"], "number" => $i, "box_id" => $box->id]);
            }
        }
        return redirect("/manufact/box/detail/" . $box->id);
    }

    public function show($id, Request $request)
    {
        $box = Box::find($id);
        $seopage = Seosetting::first();
        $title = Apptitle::first();
        $data['title'] = $title;
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
        $data['seopage'] = $seopage;
        $data['box'] = $box;

        return view("manufact.box.detail")->with($data);
    }

    public function pdfMachinistControl($id)
    {
        $box = Box::find($id);
        // return view("manufact.pdf.machinist_control", compact('box'));
        $image_file = base_path() . '/public/img/portfolio-1.jpg';
        $dompdf = new Dompdf();
        // return view("manufact.pdf.machinist_control", compact('box'));
        $dompdf->loadHtml(view("manufact.pdf.machinist_control", compact('box')));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

    }
    public function update(Request $request, $id)
    {
       
        foreach ($request->castes as $key => $c) {
            $cast = Cast::find($c["id"]);
            $cast->status = $c["status"];
            $cast->hallmark=$c["hallmark"];
            $cast->hallmark_machinist=$c["hallmark_machinist"];
            if (isset($c["mark_replace"])){
                $cast->mark_replace = $c["mark_replace"];
            }
          
            $cast->save();
        }
        Box::find($id)->update(["is_valid" => true]);
        return redirect("/manufact/box/detail/" . $id)->with("success","Vous control a été enregister avec succès");
    }

    public function pdfLabelBox($id)
    {
        $box = Box::find($id);
         //return view("manufact.pdf.box_label", compact('box'));
        //return view("manufact.pdf.machinist_control", compact('box'));
        $image_file = base_path() . '/public/img/portfolio-1.jpg';
        $box = Box::find($id);
        // return view("manufact.pdf.machinist_control", compact('box'));
        $image_file = base_path() . '/public/img/portfolio-1.jpg';
        $dompdf = new Dompdf([ 'chroot' => base_path()]); 
        // return view("manufact.pdf.machinist_control", compact('box'));
        $dompdf->loadHtml(view("manufact.pdf.box_label", compact('box')));

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();

        /*PDF::SetTitle('Hello World');
        PDF::SetFont('helvetica', 'B', 20);

        PDF::AddPage('L', 'A4');
        PDF::Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
      
        // Title
        PDF::Cell(0, 15, 'Fiche de control', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        PDF::
        // header("Content-type: application/pdf");
        PDF::Output('hello_world.pdf', 'I');*/
        // create new PDF document
        $pdf = new MYPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('');
        $pdf->SetTitle('');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');

        // set default header data
        /*     $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, "Fiche de control", "");

        // set header and footer fonts
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)*/


        // ---------------------------------------------------------

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();
        //return view("manufact.pdf.box_label", compact('box'));
        $pdf->writeHTML(view("manufact.pdf.box_label", compact('box')), true, true, true, false, 'left');

        // ---------------------------------------------------------

        // close and output PDF document
        $pdf->Output('label-box.pdf', 'I');

        //============================================================+
        // END OF FILE
        //============================================================+
    }
}
