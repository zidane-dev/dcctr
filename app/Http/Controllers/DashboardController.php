<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\RhsdController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;

class DashboardController extends Controller
{
    
    public function index(Request $request){

        // $metabase = (new MetabaseController);
        // $metabaseSiteUrl = $metabase->get_url();
        // $metabaseSecretKey = $metabase->get_secret_key();

        // $time = time();
        // $signer = new Sha256();
        // $token = (new Builder())
        //     ->set('resource', [ 'question' => 2 ])
        //     ->set('params', ['param' => ''])
        //     ->sign($signer, $metabaseSecretKey)
        //     ->getToken();

        // $iframeUrl = $metabase->get_question($metabaseSiteUrl, $token);

        return view('dashboard.dashboard');
    }
}

