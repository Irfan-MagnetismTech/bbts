<?php

namespace App\Exports\Ticketing;

use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CRMDailyReport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithStyles
{
    public $supportTickets;

    public function __construct($supportTickets)
    {
        $this->supportTickets = $supportTickets;
    }

    public function headings(): array
    {
        return [
            'Ticket Number',
            'Client Name',
            'Pop',
            'Contact Name',
            'Contact No.',
            'Created By',
            'Complain Time',
            'Solved Time',
            'Duration',
            'Problem Type',
            'Description',
            'Closed By',
            'Reason Details',
            'Remarks',
            'Priority',
            'Feedback',
            'Source',
            'Current Status (open/closed)',
            'Last Updated',
            'Reopen Count'
        ];
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $output = $this->supportTickets->map(function ($ticketInfo) {

            $feedbacks = "";
            $reasons = "";
            $ticketInfo->clientFeedbacks->map(function ($feedback) use (&$feedbacks) {
                $feedbacks .= $feedback->feedback . PHP_EOL;
            });

            $ticketInfo->supportTicketLifeCycles->map(function ($lifeCycle) use (&$reasons) {
                if (!empty($lifeCycle->description)) {
                    $reasons .= $lifeCycle->description . PHP_EOL;
                }
            });

            return [
                $ticketInfo->ticket_no,
                $ticketInfo?->client?->client_name,
                $ticketInfo?->pop?->name,
                $ticketInfo->client?->contact_person,
                $ticketInfo->client?->contact_no,
                $ticketInfo?->createdBy?->name,
                Carbon::parse($ticketInfo->complain_time)->format('d/m/Y h:i A'),
                Carbon::parse($ticketInfo->closing_date)->format('d/m/Y h:i A'),
                $this->getDuration($ticketInfo->duration),
                $ticketInfo?->supportComplainType?->name,
                $ticketInfo->description,
                $ticketInfo?->closedBy?->name,
                $reasons,
                $ticketInfo->remarks,
                $ticketInfo->priority,
                $feedbacks,
                $ticketInfo?->ticketSource?->name,
                $ticketInfo->status,
                Carbon::parse($ticketInfo->supportTicketLifeCycles()->orderBy('id', 'desc')->first()->updated_at)->format('d/m/Y h:i A'),
                $ticketInfo->reopen_count

            ];
        });

        return $output;
    }

    public function registerEvents(): array
    {

        return [

            AfterSheet::class  => function (AfterSheet $event) {
                $latest_col = $event->sheet->getHighestColumn();
                $latest_row = $event->sheet->getHighestRow();

                $event->sheet->getDelegate()->getStyle("A1:" . $latest_col . "1")
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB("007af5");

                $event->sheet->getDelegate()
                    ->getStyle("A1:" . $latest_col . "1")
                    ->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER)
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle("A1:" . $latest_col . "1")
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                $event->sheet->getDelegate()->getStyle("A1:$latest_col$latest_row")->getFont()->setSize(14);

                $event->sheet->getStyle('P2:P' . $latest_row)->getAlignment()->setWrapText(true);
                $event->sheet->getStyle('M2:M' . $latest_row)->getAlignment()->setWrapText(true);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {

        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }



    private function getDuration($duration)
    {
        $days = floor($duration / 1440); // 1 day has 1440 minutes
        $hours = gmdate('H', $duration * 60); // convert minutes to seconds
        $minutes = gmdate('i', $duration * 60);

        return $days . ' Days ' . $hours . ' Hours ' . $minutes . ' Minutes';
    }
}
