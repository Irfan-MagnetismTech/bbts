<?php

namespace App\Console\Commands;

use App\Mail\ReportEmail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendReportEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:monthlyReportSend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
         // Your logic to generate the report data
         $reportData = // ...

         // Generate and save the report file
         $reportFileName = 'report_' . now()->format('Ymd_His') . '.pdf';
         $reportFilePath = storage_path('app/reports/' . $reportFileName);
         
         // Your logic to generate and save the report file, e.g., using a PDF generation library
         // Example: PDF::loadView('reports.report', compact('reportData'))->save($reportFilePath);
 
         // Send email with attached report
         Mail::to('saleha@magnetismtech.com')->send(new ReportEmail($reportData, $reportFilePath));
 
         // Optionally, delete the report file after sending the email
         // unlink($reportFilePath);
 
         $this->info('Report sent successfully.');

        // return Command::SUCCESS;
    }
}
