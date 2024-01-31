<?php

namespace Modules\Sales\Http\Controllers;

use App\Models\Dataencoding\Employee;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Planning;
use Modules\Sales\Entities\Product;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleDetail;
use PDF;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function planReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        // $plans = Planning::get();
        // dd($plans);
        $clients = Client::latest()->get();
        $plan_reports = Planning::query()
            ->with('client', 'survey')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 0)
            ->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.plan-report', ['plan_reports' => $plan_reports, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('plan-report.pdf');
        } else {
            return view('sales::reports.plan-report', compact('plan_reports', 'clients'));
        }
    }

    public function planModificationReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        // $plans = Planning::get();
        // dd($plans);
        $clients = Client::latest()->get();
        $plan_reports = Planning::query()
            ->with('client', 'ConnectivityRequirement')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 1)
            ->get();
        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.plan-modification-report', ['plan_reports' => $plan_reports, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('plan-modification-report.pdf');
        } else {
            return view('sales::reports.plan-modification-report', compact('plan_reports', 'clients'));
        }
    }

    public function monthlySalesSummaryReport()
    {

        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $client_no = request()->client_no ?? '';
        $sales_data = [];
        //client_no, client_name, Connectivity Point, Method, Data, Internet, ip, OTC, MRC, activation_date, billing_date, billing_address, ac_holder, remarks   
        $monthly_sales_summary = Sale::query()
            ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
            ->when(!empty($client_no), function ($q) use ($client_no) {
                $q->where('client_no', $client_no);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->where('is_modified', 0)
            ->get()
            ->map(function ($sale) use (&$sales_data) {
                $sale->saleDetails->map(function ($saleDetail, $index) use ($sale, &$sales_data) {
                    // dd($saleDetail->saleLinkDetails[0]->finalSurveyDetails);
                    $pop_name = [];
                    $methods = [];
                    foreach ($saleDetail->saleLinkDetails as $link) {
                        $pop_name[] = $link->finalSurveyDetails->pop->name ?? '';
                        $methods[] = $link->finalSurveyDetails->method ?? '';
                    }
                    $sales_data[] = [
                        'client_no' => $sale->client->client_no,
                        'client_name' => $sale->client->client_name,
                        'connectivity_point' => $saleDetail->feasibilityRequirementDetails->connectivity_point,
                        'products' => $saleDetail->saleProductDetails,
                        'pop' => $pop_name,
                        'method' => $methods,
                        'activation_date' => $saleDetail?->connectivity?->commissioning_date,
                        'billing_date' => $saleDetail?->connectivity?->billing_date,
                        'billing_address' => $saleDetail->billingAddress->address,
                        'account_holder' => $sale->account_holder,
                        'remarks' => $sale->remarks,
                        'otc' => $saleDetail->otc,
                        'mrc' => $saleDetail->mrc,
                    ];
                });
            });
        $clients = Client::latest()->get();
        $filter_data = [
            'client_no' => request()->client_no ?? '',
            'client_name' => request()->client_name ?? '',
            'connectivity_point' => request()->connectivity_point ?? '',
            'product' => request()->product ?? '',
            'quantity' => request()->quantity ?? '',
            'price' => request()->price ?? '',
            'total' => request()->total ?? '',
            'pop' => request()->pop ?? '',
            'method' => request()->method ?? '',
            'activation_date' => request()->activation_date ?? '',
            'billing_date' => request()->billing_start_date ?? '',
            'billing_address' => request()->billing_address ?? '',
            'account_holder' => request()->account_holder ?? '',
            'remarks' => request()->remarks ?? '',
            'otc' => request()->otc ?? '',
            'mrc' => request()->mrc ?? '',
        ];

        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data, 'clients' => $clients], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('monthly-sales-summary-report.pdf');
        } else {
            return view('sales::reports.monthly-sales-summary-report', compact('sales_data', 'clients', 'filter_data'));
        }
    }

    // public function accountHolderWiseReport()
    // {
    //     $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
    //     $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
    //     $account_holder_name = request()->account_holder_name ?? '';
    //     $sales_data = [];
    //     //client_no, client_name, Connectivity Point, Method, Data, Internet, ip, OTC, MRC, activation_date, billing_date, billing_address, ac_holder, remarks   
    //     $monthly_sales_summary = Sale::query()
    //         ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
    //         ->when(!empty($account_holder_name), function ($q) use ($account_holder_name) {
    //             $q->where('account_holder', $account_holder_name);
    //         })
    //         ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {

    //             $q->whereBetween('created_at', [$dateFrom, $dateTo]);
    //         })
    //         ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
    //             $q->where('created_at', '>=', $dateFrom);
    //         })
    //         ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
    //             $q->where('created_at', '<=', empty($dateTo));
    //         })
    //         ->when(empty($dateFrom) && empty($dateTo) && empty($client_no), function ($q) {
    //             $q->where('created_at', '>=', now()->subDays(30));
    //         })
    //         ->where('is_modified', 0)
    //         ->get()
    //         ->map(function ($sale) use (&$sales_data) {
    //             $sale->saleDetails->map(function ($saleDetail, $index) use ($sale, &$sales_data) {
    //                 // dd($saleDetail->saleLinkDetails[0]->finalSurveyDetails);
    //                 $pop_name = [];
    //                 $methods = [];
    //                 foreach ($saleDetail->saleLinkDetails as $link) {
    //                     $pop_name[] = $link->finalSurveyDetails->pop->name ?? '';
    //                     $methods[] = $link->finalSurveyDetails->method ?? '';
    //                 }
    //                 $sales_data[] = [
    //                     'client_no' => $sale->client->client_no,
    //                     'client_name' => $sale->client->client_name,
    //                     'connectivity_point' => $saleDetail->feasibilityRequirementDetails->connectivity_point,
    //                     'products' => $saleDetail->saleProductDetails,
    //                     'pop' => $pop_name,
    //                     'method' => $methods,
    //                     'activation_date' => $saleDetail?->connectivity?->commissioning_date,
    //                     'billing_date' => $saleDetail?->connectivity?->billing_date,
    //                     'billing_address' => $saleDetail->billingAddress->address,
    //                     'account_holder' => $sale->account_holder,
    //                     'remarks' => $sale->remarks,
    //                     'otc' => $saleDetail->otc,
    //                     'mrc' => $saleDetail->mrc,
    //                 ];
    //             });
    //         });
    //     $employees = Employee::get();
    //     $filter_data = [
    //         'client_no' => request()->client_no ?? '',
    //         'client_name' => request()->client_name ?? '',
    //         'connectivity_point' => request()->connectivity_point ?? '',
    //         'product' => request()->product ?? '',
    //         'quantity' => request()->quantity ?? '',
    //         'price' => request()->price ?? '',
    //         'total' => request()->total ?? '',
    //         'pop' => request()->pop ?? '',
    //         'method' => request()->method ?? '',
    //         'activation_date' => request()->activation_date ?? '',
    //         'billing_date' => request()->billing_start_date ?? '',
    //         'billing_address' => request()->billing_address ?? '',
    //         'account_holder' => request()->account_holder ?? '',
    //         'remarks' => request()->remarks ?? '',
    //         'otc' => request()->otc ?? '',
    //         'mrc' => request()->mrc ?? '',
    //     ];

    //     if (request('type') == 'PDF') {
    //         $pdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data, 'clients' => $employees], [], [
    //             'format' => 'A4',
    //             'orientation' => 'L'
    //         ]);
    //         return $pdf->stream('monthly-sales-summary-report.pdf');
    //     } else {
    //         return view('sales::reports.account-holder-wise-report', compact('sales_data', 'employees', 'filter_data'));
    //     }
    // }

    public function productWiseReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $product_id = request()->product_id ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($product_id), function ($q) use ($product_id) {
                $q->where('product_id', $product_id);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($product_id), function ($q) {
                $q->where('created_at', '<=', now()->subDays(30));
            })
            ->whereHas('sale', function ($q) {
                $q->where('is_modified', 0);
            })
            ->get()
            ->map(function ($saleDetail) use (&$products, &$product_data) {
                $saleDetail->saleProductDetails->map(function ($sale_product) use (&$products, $saleDetail, &$product_data) {
                    $product_data[] = [
                        'client_no' => $saleDetail->sale->client->client_no,
                        'client_name' => $saleDetail->sale->client->client_name,
                        'product_name' => $sale_product->product->name,
                        'quantity' => $sale_product->quantity,
                        'price' => $sale_product->price,
                        'total' => $sale_product->price * $sale_product->quantity,
                        'activation_date' => $saleDetail?->connectivity?->commissioning_date,
                        'billing_date' => $saleDetail?->connectivity?->billing_date,
                        'account_holder' => $saleDetail->sale->account_holder,
                    ];
                });
            });
        //product data group by
        $product_data = collect($product_data)->groupBy('product_name')->toArray();
        $products = Product::get();

        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.product_report_pdf.product-wise-report', ['products' => $products, 'product_data' => $product_data], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('product-wise-report.pdf');
        } else {
            return view('sales::reports.product_report.product-wise-report', compact('products', 'product_data'));
        }
    }

    public function branchWiseReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $product_id = request()->product_id ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($product_id), function ($q) use ($product_id) {
                $q->where('product_id', $product_id);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($product_id), function ($q) {
                $q->where('created_at', '<=', now()->subDays(30));
            })
            ->whereHas('sale', function ($q) {
                $q->where('is_modified', 0);
            })
            ->get()
            ->map(function ($saleDetail) use (&$products, &$product_data) {
                $saleDetail->saleProductDetails->map(function ($sale_product) use (&$products, $saleDetail, &$product_data) {
                    $product_data[] = [
                        'client_no' => $saleDetail->sale->client->client_no,
                        'client_name' => $saleDetail->sale->client->client_name,
                        'product_name' => $sale_product->product->name,
                        'quantity' => $sale_product->quantity,
                        'price' => $sale_product->price,
                        'total' => $sale_product->price * $sale_product->quantity,
                        'activation_date' => $saleDetail?->connectivity?->commissioning_date,
                        'billing_date' => $saleDetail?->connectivity?->billing_date,
                        'account_holder' => $saleDetail->sale->account_holder,
                        'branch' => $saleDetail->feasibilityRequirementDetails->branch->name,
                    ];
                });
            });
        //product data group by
        $product_data = collect($product_data)->groupBy('branch')->toArray();
        $products = Product::get();

        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.product_report_pdf.branch-wise-report', ['products' => $products, 'product_data' => $product_data], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('product-wise-report.pdf');
        } else {
            return view('sales::reports.product_report.branch-wise-report', compact('products', 'product_data'));
        }
    }

    public function accountHolderWiseReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $product_id = request()->product_id ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($product_id), function ($q) use ($product_id) {
                $q->where('product_id', $product_id);
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '>=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '<=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($product_id), function ($q) {
                $q->where('created_at', '<=', now()->subDays(30));
            })
            ->whereHas('sale', function ($q) {
                $q->where('is_modified', 0);
            })
            ->get()
            ->map(function ($saleDetail) use (&$products, &$product_data) {
                $saleDetail->saleProductDetails->map(function ($sale_product) use (&$products, $saleDetail, &$product_data) {
                    $product_data[] = [
                        'client_no' => $saleDetail->sale->client->client_no,
                        'client_name' => $saleDetail->sale->client->client_name,
                        'product_name' => $sale_product->product->name,
                        'quantity' => $sale_product->quantity,
                        'price' => $sale_product->price,
                        'total' => $sale_product->price * $sale_product->quantity,
                        'activation_date' => $saleDetail?->connectivity?->commissioning_date,
                        'billing_date' => $saleDetail?->connectivity?->billing_date,
                        'account_holder' => $saleDetail->sale->account_holder,
                        'branch' => $saleDetail->feasibilityRequirementDetails->branch->name,
                    ];
                });
            });
        //product data group by
        $product_data = collect($product_data)->groupBy('account_holder')->toArray();
        $products = Product::get();

        if (request('type') == 'PDF') {
            $pdf = PDF::loadView('sales::pdf.product_report_pdf.account-holder-wise-report', ['products' => $products, 'product_data' => $product_data], [], [
                'format' => 'A4',
                'orientation' => 'L'
            ]);
            return $pdf->stream('product-wise-report.pdf');
        } else {
            return view('sales::reports.product_report.account-holder-wise-report', compact('products', 'product_data'));
        }
    }
}
