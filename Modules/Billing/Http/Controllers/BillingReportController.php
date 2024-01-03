<?php

namespace Modules\Billing\Http\Controllers;

use Illuminate\Database\QueryException;
use Modules\Admin\Entities\Branch;
use Modules\Billing\Entities\Collection;
use Modules\Sales\Entities\Client;
use PDF;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Services\BbtsGlobalService;
use Modules\Sales\Entities\SaleDetail;
use Modules\Billing\Entities\MonthlyBill;
use Illuminate\Contracts\Support\Renderable;

class BillingReportController extends Controller
{
    public function duesReport(Request $request)
    {

    }

    public function collectionReport(Request $request)
    {
//        $branches = Branch::get();
        $clients = Client::get();
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        if ($from_date != null && $to_date != null) {
            $from_date = Carbon::createFromFormat('d-m-Y', $request->from_date)->format('Y-m-d');
            $to_date = Carbon::createFromFormat('d-m-Y', $request->to_date)->format('Y-m-d');
        }
//        $branch_id = $request->branch_id;
        $client_no = $request->client_no;

        if ($from_date != null && $to_date != null && $client_no != null) {
            $collection = Collection::whereBetween('date', [$from_date, $to_date])
                ->where('client_no', $client_no)
                ->get();
        }elseif ($from_date != null && $to_date != null && $client_no == null) {
        $collection = Collection::whereBetween('date', [$from_date, $to_date])->get();
        }elseif ($from_date == null && $to_date == null && $client_no != null) {
            $collection = Collection::where('client_no', $client_no)->get();
        } else {
            $collection = Collection::get();
        }
        $from_date = $request->from_date;
        $to_date = $request->to_date;

        if ($request->type === 'pdf') {
            return PDF::loadView('billing::report.collection_report_pdf', ['collection' => $collection, 'client_no' => $client_no, 'from_date' => $from_date, 'to_date' => $to_date, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L',
                'title' => 'Collection Report PDF',
                'watermark' => 'BBTS',
                'show_watermark' => true,
                'watermark_text_alpha' => 0.1,
                'watermark_image_path' => '',
                'watermark_image_alpha' => 0.2,
                'watermark_image_size' => 'D',
                'watermark_image_position' => 'P',
            ])->stream('collection_report.pdf');
            return view('billing::report.collection_report_pdf', compact('collection', 'client_no', 'from_date', 'to_date','clients'));
        } else {
            return view('billing::report.collection_report', compact('collection', 'client_no', 'from_date', 'to_date','clients'));
        }
    }
}
