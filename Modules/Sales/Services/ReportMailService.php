<?php

namespace Modules\Sales\Services;

use Modules\Sales\Entities\Sale;

class ReportMailService
{
    public function salesActivationReportClientWise(){
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
}
