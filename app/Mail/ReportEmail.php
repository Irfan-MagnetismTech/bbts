<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReportEmail extends Mailable
{
    use Queueable, SerializesModels;

    // public $reportData;
    // public $reportFilePath;


    public function __construct()
    {
        // $this->reportData = $reportData;
        // $this->reportFilePath = $reportFilePath;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Report Email',
        );
    }

    public function build()
    {
        return $this->view('mail.report_mail')
            ->subject('Scheduled Email Subject');

        // return $this->view('emails.report')
        //     ->with(['reportData' => $this->reportData])
        //     ->attach($this->reportFilePath, [
        //         'as' => 'report.pdf', // Specify the desired filename for the attachment
        //     ]);
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'view.name',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
