<?php
return [

    'name' => 'Broad Band Telecom Services Limited',
    'shortname' => 'BBTS',
    'slogan'    =>  '',
    'logo' => '/images/bbts_logo.png',
    'favicon' => '/favicon.png',
    'url'   => 'https://bbts.net',
    'footer' => 'All Rights Reserved',
    'developer' => 'Developed by <a href="https://magnetismtech.com" target="_blank">Magnetism Tech Limited</a>',

    'ticketStatuses' => ['Pending', 'Approved', 'Accepted', 'Processing', 'Closed', 'Reopen'],
    'ticketPriorities' => ['Low', 'Medium', 'High', 'Urgent'],
    'supportEmployeeLevels' => [
        '1' => '1st Layer',
        '2' => '2nd Layer',
        '3' => '3rd Layer',
    ],

    // Remember the following Linear Serial is mandatory as TicketMovementController and Create-Edit has used it by index number.
    'ticketMovements' => [
        'Forward',
        'Backward',
        'Handover'
    ],
    'pastForms' => [
        'Forward' => 'Forwarded',
        'Backward' => 'Backwarded',
        'Handover' => 'Handovered'
    ],
    'ticketReopenValidity' => (60 * 24), // Time is in minutes, so it's 24 hours.

    //material received types
    'receivedTypes' => [
        'MRR' => 'MRR',
        'ERR' => 'ERR',
        'WCR' => 'WCR',
        'WOR' => 'WOR'
    ],

    //Tax or VAT
    'vatOrTax' => [
        'Include' => 'Include',
        'Exclude' => 'Exclude'
    ],

    //Challan Purpose
    'challanPurpose' => [
        'activation' => 'Activation',
        'maintenance' => 'Maintenance',
        'shifting' => 'Shifting',
        'own_use' => 'Own Use',
        'stolen' => 'Stolen',
    ],

    //err return for
    'errReturnFor' => [
        'Inactive Client' => 'Inactive Client',
        'BBTS' => 'BBTS',
        'Shifting Client' => 'Shifting Client',
        'Method Change' => 'Method Change',
    ],

    //pop type
    'popType' => [
        'POP' => 'POP',
        'NOC' => 'NOC',
        'Office' => 'Office',
        'DC' => 'DC',
        'DR' => 'DR',
        'Co-Loc' => 'Co-Loc',
    ],
];
