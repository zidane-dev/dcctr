<?php

namespace App\Http\Controllers;

use App\Http\Controllers\User\DomaineController;
use App\Http\Controllers\User\UserHelperController;
use Illuminate\Http\Request;
use App\Http\Controllers\Validation\UserValidationController;
use App\Models\Dpci;

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

        $role_code = $request->session()->get('role');
        $role = (new UserValidationController)->get_role_name($role_code);
        $dp = Dpci::where('id', $request->session()->get('domaine_id'))->select('type', 'domaine_fr')->first();
        $structure = $dp->type.' / '.$dp->domaine_fr;
        $portee = (new UserHelperController)->getUserScope();
        $total = $this->somme($request);
        $data = ['role' => $role, 'structure' => $structure, 'portee' => $portee, 'total' => $total];
        return view('dashboard.dashboard',compact('data'));
    }

    public function somme($request){
        $a = $request->session()->get('rh_count'     );
        $b = $request->session()->get('bdg_count'    );
        $c = $request->session()->get('attproc_count');
        $d = $request->session()->get('indic_count'  );

        return $a + $b + $c + $d;
    }
}

