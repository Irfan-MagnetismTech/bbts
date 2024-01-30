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
        $data["email"] = "saleha@magnetismtech.com";
        $data["title"] = "Monthly Sales Report";
        $data["body"] = "This is Demo";


        // $dateFrom = now()->firstOfMonth()->format('Y-m-d');
        // $dateTo = now()->lastOfMonth()->format('Y-m-d');
        $dateFrom = '2023-12-01';
        $dateTo = '2024-01-01';
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
        $clients = Client::latest()->get();

        $pdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', ['sales_data' => $sales_data, 'clients' => $clients], [], [
            'format' => 'A4',
            'orientation' => 'L'
        ]);
        // return $pdf->stream('monthly-sales-summary-report.pdf');

        // $pdf = PDF::loadView('mail.report_mail', $data);

        Mail::send('mail.report_mail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($pdf->output(), "text.pdf");
        });


        // Your logic to generate the report data
        //  $reportData = // ...

        //  // Generate and save the report file
        //  $reportFileName = 'report_' . now()->format('Ymd_His') . '.pdf';
        //  $reportFilePath = storage_path('app/reports/' . $reportFileName);

        //  // Your logic to generate and save the report file, e.g., using a PDF generation library
        //  // Example: PDF::loadView('reports.report', compact('reportData'))->save($reportFilePath);

        //  // Send email with attached report
        //  Mail::to('saleha@magnetismtech.com')->send(new ReportEmail($reportData, $reportFilePath));

        //  // Optionally, delete the report file after sending the email
        //  // unlink($reportFilePath);

        //  $this->info('Report sent successfully.');

        // return Command::SUCCESS;
    }
}
