<?php

namespace Modules\Networking\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Admin\Entities\Ip;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    
    public function ip_import(){
        $ipDatas = [ 
            '119.18.144.0',
            '119.18.145.0',
            '119.18.146.0',
            '119.18.147.0',
            '119.18.148.0',
            '119.18.149.0',
            '119.18.150.0',
            '119.18.151.0',
            '103.30.28.0',
            '103.30.29.0',
            '103.30.30.0',
            '103.30.31.0',
            '202.5.32.0',
            '202.5.33.0',
            '202.5.34.0',
            '202.5.35.0',
            '202.5.36.0',
            '202.5.37.0',
            '202.5.38.0',
            '202.5.39.0',
            '202.5.40.0',
            '202.5.41.0',
            '202.5.42.0',
            '202.5.43.0',
            '202.5.44.0',
            '202.5.45.0',
            '202.5.46.0',
            '202.5.47.0',
            '202.5.48.0',
            '202.5.49.0',
            '202.5.50.0',
            '202.5.51.0',
            '202.5.52.0',
            '202.5.53.0',
            '202.5.54.0',
            '202.5.55.0',
            '202.5.56.0',
            '202.5.57.0',
            '202.5.58.0',
            '202.5.59.0',
            '202.5.60.0',
            '202.5.61.0',
            '202.5.62.0',
            '202.5.63.0', 
        ];
        foreach($ipDatas as $data){
            $ip_block = explode('.', $data); 
            $ip=[];
            for($i=0; $i<=255; $i++){
                $ip[] = [
                    'address' => "$ip_block[0].$ip_block[1].$ip_block[2].$i",
                    'ip_type' => 'IPv4',
                    ];
                // $ip['ip_type'] = 'IPv4';
                // dump($ip);
            }
            Ip::insert($ip);
        }
        dd('done');
    }
}
