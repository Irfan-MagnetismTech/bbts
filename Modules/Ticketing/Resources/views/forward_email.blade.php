<html>
<style>
    .table_header{
        background-color: #c8c8c9 !important;
        font-size: 12px;
        color: black;
    }
    .table_footer{
        background-color: #c8c8c9 !important;
        font-size: 12px;
        color: black;
    }
    .table_header_td{
        background-color: #c8c8c9;
        text-align: left;
        font-size: 12px;
        border: 1px solid rgb(205, 207, 208) !important
    }
</style>
<body>
<div class="table-responsive">
    <table class="table table-bordered" style="">
        <tr class="table_header">
            <td colspan="4" style="text-align: start">Dear Sir,<br>BBTSL Support Service Center would like to inform you that you have reported a fault(s). We have raised a trouble ticket against the notification, details as per below :</td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Ticket ID</b></td>
            <td colspan="3" style="text-align: start">{{ $subject ?? '' }}</td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Status</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>TT Created By</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Client Name</b></td>
            <td colspan="3" style="text-align: start">{{ $receiver }}</td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Problem Type</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Complain Time</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Solved Time</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Reason</b></td>
            <td colspan="3" style="text-align: start">{!! $customEmailBody !!} </td>
        </tr>
        <tr>
            <td class="table_header_td"><b>TT Closed By</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr>
            <td class="table_header_td"><b>Remarks</b></td>
            <td colspan="3" style="text-align: start"></td>
        </tr>
        <tr class="table_footer">
            <td colspan="4" style="text-align: start">Any update will be communicated whenever we will get. We are available 24x7 to assist you,<br>please feel free to contact us: 01730376384, 01730376378-82 or drop a mail: csd@bbts.net;<br>info@bbts.net. Thanking you for your cooperation.</td>
        </tr>
    </table>
</div>
</body>
</html>
