<?php

namespace Modules\Sales\Services;

use Modules\Networking\Entities\Activation;
use Modules\Sales\Entities\ConnectivityRequirement;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Entities\SaleDetail;

class ReportMailService
{
    public function salesActivationReportClientWise()
    {
        $dateFrom = now()->firstOfMonth()->format('Y-m-d');
        $dateTo = now()->lastOfMonth()->format('Y-m-d');
        $sales_data = [];
        Sale::query()
            ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->where('is_modified', 0)
            ->get()
            ->map(function ($sale) use (&$sales_data) {
                $sale->saleDetails->map(function ($saleDetail, $index) use ($sale, &$sales_data) {
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
        return $sales_data;
    }

    public function salesActivationReportAccountHolderWise()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $account_holder_name = request()->account_holder_name ?? '';
        $sales_data = [];
        //client_no, client_name, Connectivity Point, Method, Data, Internet, ip, OTC, MRC, activation_date, billing_date, billing_address, ac_holder, remarks   
        $monthly_sales_summary = Sale::query()
            ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
            ->when(!empty($account_holder_name), function ($q) use ($account_holder_name) {
                $q->where('account_holder', $account_holder_name);
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

        $sales_data = collect($sales_data)->groupBy('account_holder')->toArray();
        return $sales_data;
    }

    public function salesActivationReportBranchWise()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $branch_id = request()->branch_id ?? '';
        $sales_data = [];
        //client_no, client_name, Connectivity Point, Method, Data, Internet, ip, OTC, MRC, activation_date, billing_date, billing_address, ac_holder, remarks   
        $monthly_sales_summary = Sale::query()
            ->with('client', 'saleDetails', 'saleProductDetails', 'saleLinkDetails.finalSurveyDetails')
            ->when(!empty($branch_id), function ($q) use ($branch_id) {
                $q->whereHas('saleDetails', function ($q) use ($branch_id) {
                    $q->whereHas('feasibilityRequirementDetails', function ($q) use ($branch_id) {
                        $q->where('branch_id', $branch_id);
                    });
                });
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
                        'branch' => $saleDetail->feasibilityRequirementDetails->branch->name,
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

        $sales_data = collect($sales_data)->groupBy('branch')->toArray();
        return $sales_data;
    }

    public function productWiseReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $product_id = request()->product_id ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'saleProductDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($product_id), function ($q) use ($product_id) {
                $q->whereHas('saleProductDetails', function ($q) use ($product_id) {
                    $q->where('product_id', $product_id);
                });
            })
            ->when(!empty($dateFrom) && !empty($dateTo), function ($q) use ($dateFrom, $dateTo) {
                $q->whereBetween('created_at', [$dateFrom, $dateTo]);
            })
            ->when(!empty($dateFrom) && empty($dateTo), function ($q) use ($dateFrom) {
                $q->where('created_at', '<=', $dateFrom);
            })
            ->when(!empty($dateTo) && empty($dateFrom), function ($q) use ($dateTo) {
                $q->where('created_at', '>=', empty($dateTo));
            })
            ->when(empty($dateFrom) && empty($dateTo) && empty($product_id), function ($q) {
                $q->where('created_at', '>=', now()->subDays(30));
            })
            ->whereHas('sale', function ($q) use ($product_id) {
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

        if (!empty($product_id)) {
            $product_data = collect($product_data)->where('product_name', Product::find($product_id)->name)->toArray();
        }
        //product data group by
        $product_data = collect($product_data)->groupBy('product_name')->toArray();
        return $product_data;
    }

    public function branchWiseProductReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $branch_id = request()->branch_id ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($branch_id), function ($q) use ($branch_id) {
                $q->whereHas('feasibilityRequirementDetails', function ($q) use ($branch_id) {
                    $q->where('branch_id', $branch_id);
                });
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
                $q->where('created_at', '>=', now()->subDays(30));
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
        return $product_data;
    }

    public function accountHolderWiseReport()
    {
        $dateFrom = request()->date_from ? date('Y-m-d', strtotime(request()->date_from)) : null;
        $dateTo = request()->date_to ? date('Y-m-d', strtotime(request()->date_to)) : null;
        $account_holder_name = request()->account_holder_name ?? '';
        $product_data = [];

        $data = SaleDetail::with('sale.client', 'sale.saleDetails', 'sale.saleProductDetails', 'sale.saleLinkDetails.finalSurveyDetails')
            ->when(!empty($account_holder_name), function ($q) use ($account_holder_name) {
                $q->whereHas('sale', function ($q) use ($account_holder_name) {
                    $q->where('account_holder', $account_holder_name);
                });
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
                $q->where('created_at', '>=', now()->subDays(30));
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
        return $product_data;
    }

    public function   permanentlyInactiveClients()
    {
        $permanently_inactive_clients = [];
        $activations = Activation::where('is_active', 'Inactive')->get();
        $fr_nos = $activations->pluck('fr_no')->toArray();
        //get latest connectivity_requirement_id by wherein fr_nos
        $connectivity_requirements = ConnectivityRequirement::whereIn('fr_no', $fr_nos)->latest()->get();
        //remove same fr_no from connectivity_requirements
        $connectivity_requirements = $connectivity_requirements->unique('fr_no');
        foreach ($connectivity_requirements as $connectivity_requirement) {
            $permanently_inactive_clients[] = [
                'client_no' => $connectivity_requirement->client_no,
                'client_name' => $connectivity_requirement->client->client_name,
                'thana' => $connectivity_requirement->client->thana->name ?? '',
                'fr_no' => $connectivity_requirement->fr_no,
                'connectivity_requirement_id' => $connectivity_requirement->id,
                'connectivity_requirement_date' => $connectivity_requirement->created_at,
                'connectivity_requirement_details' => $connectivity_requirement->connectivityRequirementDetails,
                'scm_err' => $connectivity_requirement?->scmErr->scmErrLines->load('material') ?? [],
                'sale_product_details' => $connectivity_requirement->saleDetail->last()->load('saleProductDetails')->saleProductDetails,
                'account_holder' => $connectivity_requirement->saleDetail->last()->sale->account_holder,
                'reason' => $connectivity_requirement->scmErr->reason ?? '',
                'branch' => $connectivity_requirement->FeasibilityRequirementDetail->branch->name ?? '',
                'connectivity_point' => $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point ?? '',
                'otc' => $connectivity_requirement->saleDetail->last()->otc,
                'mrc' => $connectivity_requirement->saleDetail->last()->mrc,
            ];
        }

        return $permanently_inactive_clients;
    }

    public function accountHolderWiseInactiveReport()
    {
        $permanently_inactive_clients = [];
        $activations = Activation::where('is_active', 'Inactive')->get();
        $fr_nos = $activations->pluck('fr_no')->toArray();
        //get latest connectivity_requirement_id by wherein fr_nos
        $connectivity_requirements = ConnectivityRequirement::whereIn('fr_no', $fr_nos)->latest()->get();
        //remove same fr_no from connectivity_requirements
        $connectivity_requirements = $connectivity_requirements->unique('fr_no');
        foreach ($connectivity_requirements as $connectivity_requirement) {
            $permanently_inactive_clients[] = [
                'client_no' => $connectivity_requirement->client_no,
                'client_name' => $connectivity_requirement->client->client_name,
                'thana' => $connectivity_requirement->client->thana->name ?? '',
                'fr_no' => $connectivity_requirement->fr_no,
                'connectivity_requirement_id' => $connectivity_requirement->id,
                'connectivity_requirement_date' => $connectivity_requirement->created_at,
                'connectivity_requirement_details' => $connectivity_requirement->connectivityRequirementDetails,
                'scm_err' => $connectivity_requirement?->scmErr->scmErrLines->load('material') ?? [],
                'sale_product_details' => $connectivity_requirement->saleDetail->last()->load('saleProductDetails')->saleProductDetails,
                'account_holder' => $connectivity_requirement->saleDetail->last()->sale->account_holder,
                'reason' => $connectivity_requirement->scmErr->reason ?? '',
                'branch' => $connectivity_requirement->FeasibilityRequirementDetail->branch->name ?? '',
                'connectivity_point' => $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point ?? '',
                'otc' => $connectivity_requirement->saleDetail->last()->otc,
                'mrc' => $connectivity_requirement->saleDetail->last()->mrc,
            ];
        }



        $permanently_inactive_clients = collect($permanently_inactive_clients)->groupBy('account_holder');
        return $permanently_inactive_clients;
    }

    public function branchWiseInactiveReport()
    {
        $permanently_inactive_clients = [];
        $activations = Activation::where('is_active', 'Inactive')->get();
        $fr_nos = $activations->pluck('fr_no')->toArray();
        //get latest connectivity_requirement_id by wherein fr_nos
        $connectivity_requirements = ConnectivityRequirement::whereIn('fr_no', $fr_nos)->latest()->get();
        //remove same fr_no from connectivity_requirements
        $connectivity_requirements = $connectivity_requirements->unique('fr_no');
        foreach ($connectivity_requirements as $connectivity_requirement) {
            $permanently_inactive_clients[] = [
                'client_no' => $connectivity_requirement->client_no,
                'client_name' => $connectivity_requirement->client->client_name,
                'thana' => $connectivity_requirement->client->thana->name ?? '',
                'fr_no' => $connectivity_requirement->fr_no,
                'connectivity_requirement_id' => $connectivity_requirement->id,
                'connectivity_requirement_date' => $connectivity_requirement->created_at,
                'connectivity_requirement_details' => $connectivity_requirement->connectivityRequirementDetails,
                'scm_err' => $connectivity_requirement?->scmErr->scmErrLines->load('material') ?? [],
                'sale_product_details' => $connectivity_requirement->saleDetail->last()->load('saleProductDetails')->saleProductDetails,
                'account_holder' => $connectivity_requirement->saleDetail->last()->sale->account_holder,
                'reason' => $connectivity_requirement->scmErr->reason ?? '',
                'branch' => $connectivity_requirement->FeasibilityRequirementDetail->branch->name ?? '',
                'connectivity_point' => $connectivity_requirement->FeasibilityRequirementDetail->connectivity_point ?? '',
                'otc' => $connectivity_requirement->saleDetail->last()->otc,
                'mrc' => $connectivity_requirement->saleDetail->last()->mrc,
            ];
        }

        $permanently_inactive_clients = collect($permanently_inactive_clients)->groupBy('branch');
        return $permanently_inactive_clients;
    }  
}
