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
        'WOR' => 'WOR',
        'OS' => 'OS'
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
        'Co-Location' => 'Co-Location',
    ],

    //link status
    'linkStatus' => [
        'Active' => 'Active',
        'Inactive' => 'Inactive',
        'Increase' => 'Increase',
        'Decrease' => 'Decrease',
        'Pending' => 'Pending',
        'Under Process' => 'Under Process',
        'Under Notice' => 'Under Notice',
        'Terminated' => 'Terminated',
    ],

    //services status
    'serviceStatus' => [
        'Active' => 'Active',
        'Inactive' => 'Inactive',
        'Increase' => 'Increase',
        'Decrease' => 'Decrease',
    ],

    //ip address type
    'ipAddressType' => [
        'Link' => 'Link',
        'Internet' => 'Internet',
        'Data' => 'Data',
        'Management' => 'Management',
    ],

    //equipment type
    'equipmentType' => [
        'Network' => 'Network',
        'Power' => 'Power',
        'Tower' => 'Tower',
        'WireLess' => 'WireLess'
    ],

    //client type
    'clientType' => [
        'Corporate' => 'Corporate',
        'Individual' => 'Individual',
    ],

    //ip address type
    'ipType' => [
        'IPv4' => 'IPv4',
        'IPv6' => 'IPv6',
    ],


    'fiberType' => [
        '4 Core' => '4 Core',
        '8 Core' => '8 Core',
        '12 Core' => '12 Core',
        '16 Core' => '16 Core',
        '24 Core' => '24 Core',
        '28 Core' => '28 Core',
        '32 Core' => '32 Core',
    ],


    'coreNoColor' => [
        '1-White (WH)' => '1 - White (WH)',
        '2-Brown (BR)' => '2 - Brown (BR)',
        '3-Green (GN)' => '3 - Green (GN)',
        '4-Yellow (YW)' => '4 - Yellow (YW)',
        '5-Grey (GR)' => '5 - Grey (GR)',
        '6-Pink (PK)' => '6 - Pink (PK)',
        '7-Blue (BL)' => '7 - Blue (BL)',
        '8-Red (RD)' => '8 - Red (RD)',
        '9-Black (BK)' => '9 - Black (BK)',
        '10-Violet (VI)' => '10 - Violet (VI)',
        '11-Grey-Pink (GRPK)' => '11 - Grey-Pink (GRPK)',
        '12-Red-Blue (RDBL)' => '12 - Red-Blue (RDBL)',
        '13-White-Green (WHGN)' => '13 - White-Green (WHGN)',
        '14-Brown-Green (BRGN)' => '14 - Brown-Green (BRGN)',
        '15-White-Yellow (WHYW)' => '15 - White-Yellow (WHYW)',
        '16-Yellow-Brown (YWBN)' => '16 - Yellow-Brown (YWBN)',
        '17-White-Grey (WHGR)' => '17 - White-Grey (WHGR)',
        '18-Grey-Brown (GRBN)' => '18 - Grey-Brown (GRBN)',
        '19-White-Pink (WHPK)' => '19 - White-Pink (WHPK)',
        '20-Pink-Brown (PKBN)' => '20 - Pink-Brown (PKBN)',
        '21-White-Blue (WHBL)' => '21 - White-Blue (WHBL)',
        '22-Brown-Blue (BNBL)' => '22 - Brown-Blue (BNBL)',
        '23-White-Red (WHRD)' => '23 - White-Red (WHRD)',
        '24-Brown-Red (BNRD)' => '24 - Brown-Red (BNRD)',
        '25-White-Black (WHBK)' => '25 - White-Black (WHBK)',
        '26-Brown-Black (BNBK)' => '26 - Brown-Black (BNBK)',
        '27-Grey-Green (GRGN)' => '27 - Grey-Green (GRGN)',
        '28-Yellow-Grey (YWGR)' => '28 - Yellow-Grey (YWGR)',
        '29-Pink-Green (PKGN)' => '29 - Pink-Green (PKGN)',
        '30-Yellow-Pink (YWPK)' => '30 - Yellow-Pink (YWPK)',
        '31-Green-Blue (GNBL)' => '31 - Green-Blue (GNBL)',
        '32-Yellow-Blue (YWBL)' => '32 - Yellow-Blue (YWBL)',
        '33-Green-Red (GNRD)' => '33 - Green-Red (GNRD)',
        '34-Yellow-Red (YWRD)' => '34 - Yellow-Red (YWRD)',
        '35-Green-Black (GNBK)' => '35 - Green-Black (GNBK)',
        '36-Yellow-Black (YWBK)' => '36 - Yellow-Black (YWBK)',
        '37-Grey-Blue (GRBL)' => '37 - Grey-Blue (GRBL)',
        '38-Pink-Blue (PKBL)' => '38 - Pink-Blue (PKBL)',
        '39-Grey-Red (GRRD)' => '39 - Grey-Red (GRRD)',
        '40-Pink-Red (PKRD)' => '40 - Pink-Red (PKRD)',
        '41-Grey-Black (GRBK)' => '41 - Grey-Black (GRBK)',
        '42-Pink-Black (PKBK)' => '42 - Pink-Black (PKBK)',
        '43-Blue-Black (BLBK)' => '43 - Blue-Black (BLBK)',
        '44-Red-Black (RDBK)' => '44 - Red-Black (RDBK)',
        '45-White-Brown-Black (WHBNBK)' => '45 - White-Brown-Black (WHBNBK)',
        '46-Yellow-Green-Black (YWGNBK)' => '46 - Yellow-Green-Black (YWGNBK)',
        '47-Grey-Pink-Black (GRPKBK)' => '47 - Grey-Pink-Black (GRPKBK)',
        '48-Red-Blue-Black (RDBLBK)' => '48 - Red-Blue-Black (RDBLBK)',
        '49-White-Green-Black (WHGNBK)' => '49 - White-Green-Black (WHGNBK)',
        '50-Brown-Green-Black (BNGNBK)' => '50 - Brown-Green-Black (BNGNBK)',
        '51-White-Yellow-Black (WHYWBK)' => '51 - White-Yellow-Black (WHYWBK)',
        '52-Yellow-Brown-Black (YWBNBK)' => '52 - Yellow-Brown-Black (YWBNBK)',
        '53-White-Grey-Black (WHGRBK)' => '53 - White-Grey-Black (WHGRBK)',
        '54-Grey-Brown-Black (GRBNBK)' => '54 - Grey-Brown-Black (GRBNBK)',
        '55-White-Pink-Black (WHPKBK)' => '55 - White-Pink-Black (WHPKBK)',
        '56-Pink-Brown-Black (PKBNBK)' => '56 - Pink-Brown-Black (PKBNBK)',
        '57-White-Blue-Black (WHBLBK)' => '57 - White-Blue-Black (WHBLBK)',
        '58-Brown-Blue-Black (BNBLBK)' => '58 - Brown-Blue-Black (BNBLBK)',
        '59-White-Red-Black (WHRDBK)' => '59 - White-Red-Black (WHRDBK)',
        '60-Brown-Red-Black (BNRDBK)' => '60 - Brown-Red-Black (BNRDBK)',
    ],
];
