<?php
return [

    'name' => 'Broad Band Telecom Services Limited',
    'shortname' => 'BBTS',
    'slogan'    =>  '',
    'logo' => '/images/bbts_logo.png',
    'footer' => 'All Rights Reserved',
    'developer' => 'Developed by <a href="https://magnetismtech.com" target="_blank">Magnetism Tech Limited</a>',
    
    'ticketStatuses' => ['Pending', 'Approved', 'Accepted', 'Processing', 'Closed', 'Reopen'],
    'ticketPriorities' => ['Low', 'Medium', 'High', 'Urgent'],
    'supportEmployeeLevels' => [
        '1' => '1st Layer',
        '2' => '2nd Layer',
        '3' => '3rd Layer',
    ],
    'ticketMovements' => [
        'Forward',
        'Backward',
        'Handover'
    ],
];