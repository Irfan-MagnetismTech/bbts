<?php

namespace App\Console\Commands;

use App\Mail\ReportEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Sale;
use PDF;

class SendReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthlyReportSend';
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $month = now()->format('F-Y');
        $data["email"] = "saleha@magnetismtech.com";
        $data["title"] = "Monthly Sales Report of $month";
        $data["body"]  = "Please find attached the monthly sales report for $month.";

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

        $clientWiseSalesPdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data,], [], [
            'format' => 'A4',
            'orientation' => 'L'
        ]);
        $AccountHolderWiseSalesPdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data,], [], [
            'format' => 'A4',
            'orientation' => 'L'
        ]); 

        Mail::send('mail.report_mail', $data, function ($message) use ($data, $clientWiseSalesPdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($clientWiseSalesPdf->output(), "clientWiseSales.pdf");
        });
    }
}
