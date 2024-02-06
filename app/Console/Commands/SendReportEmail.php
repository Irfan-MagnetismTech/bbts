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
        $salesActivationReportBranchWise = (new ReportMailService)->salesActivationReportBranchWise();
        $salesActivationReportAccountHolderWise = (new ReportMailService)->salesActivationReportAccountHolderWise();
        $productWiseReport = (new ReportMailService)->productWiseReport();
        $branchWiseProductReport = (new ReportMailService)->branchWiseProductReport();
        $accountHolderWiseProductReport = (new ReportMailService)->accountHolderWiseReport();


        $clientWiseSalesPdf        = PDF::loadView(
            'sales::pdf.monthly-sales-summary-report',
            ['sales_data' => $salesActivationReportClientWise],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        $branchWiseSalesPdf = PDF::loadView(
            'sales::pdf.activation_report_pdf.branch-wise-report',
            ['sales_data' => $salesActivationReportBranchWise],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        $accountHolderWiseSalesPdf = PDF::loadView(
            'sales::pdf.activation_report_pdf.account-holder-wise-report',
            ['sales_data' => $salesActivationReportAccountHolderWise],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        $productWiseSalesPdf = PDF::loadView(
            'sales::pdf.product_report_pdf.product-wise-report',
            ['product_data' => $productWiseReport],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        $branchWiseProductReportPdf = PDF::loadView(
            'sales::pdf.product_report_pdf.branch-wise-report',
            ['product_data' => $branchWiseProductReport],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        $accountHolderWiseProductReportPdf = PDF::loadView(
            'sales::pdf.product_report_pdf.account-holder-wise-report',
            ['product_data' => $accountHolderWiseProductReport],
            [],
            ['format' => 'A4', 'orientation' => 'L']
        );

        Mail::send('mail.report_mail', $data, function ($message) use ($data, $clientWiseSalesPdf, $branchWiseSalesPdf, $accountHolderWiseSalesPdf, $productWiseSalesPdf, $branchWiseProductReportPdf, $accountHolderWiseProductReportPdf) {
            $message->to($data["email"], $data["email"])
                ->subject($data["title"])
                ->attachData($clientWiseSalesPdf->output(), "clientWiseSales.pdf")
                ->attachData($branchWiseSalesPdf->output(), "clientWiseSalesBranchWise.pdf")
                ->attachData($accountHolderWiseSalesPdf->output(), "clientWiseSalesAcocuntHolderWise.pdf")
                ->attachData($productWiseSalesPdf->output(), "productWiseSales.pdf")
                ->attachData($branchWiseProductReportPdf->output(), "branchWiseProductReport.pdf")
                ->attachData($accountHolderWiseProductReportPdf->output(), "accountHolderWiseProductReport.pdf");
        });
    }
}
