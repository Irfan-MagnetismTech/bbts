<?php

namespace App\Console\Commands;

use App\Mail\ReportEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\Sale;
use Modules\Sales\Services\ReportMailService;
use PDF;

class SendReportEmail extends Command
{

    protected $signature = 'command:monthlyReportSend';
    protected $description = 'Command description';

    public function handle()
    {
        $month = now()->format('F-Y');
        $data["email"] = "saleha@magnetismtech.com";
        $data["title"] = "Monthly Sales Report of $month";
        $data["body"]  = "Please find attached the monthly sales report for $month.";
        $salesActivationReportClientWise = (new ReportMailService)->salesActivationReportClientWise();

        $clientWiseSalesPdf        = PDF::loadView('sales::pdf.monthly-sales-summary-report', 
                                    ['sales_data' => $salesActivationReportClientWise], [], [ 'format' => 'A4', 'orientation' => 'L']);
        $AccountHolderWiseSalesPdf = PDF::loadView('sales::pdf.monthly-sales-summary-report', 
                                    ['sales_data' => $salesActivationReportClientWise], [], [ 'format' => 'A4', 'orientation' => 'L']); 

        Mail::send('mail.report_mail', $data, function ($message) use ($data, $clientWiseSalesPdf, $AccountHolderWiseSalesPdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($clientWiseSalesPdf->output(), "clientWiseSales.pdf")
                ->attachData($AccountHolderWiseSalesPdf->output(), "clientWiseSalesdgd.pdf");
        });
    }
}
