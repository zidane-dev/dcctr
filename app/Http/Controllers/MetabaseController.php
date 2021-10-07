<?php

namespace App\Http\Controllers;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;


class MetabaseController extends Controller
{
    private function get_url(){
        return 'http://localhost:3000';

    }
    private function get_secret_key(){
        return '338c82373475e1a429e615e7613f7c63c714271a4ae9beeaf1519d4246d8a353';
    }
    private function get_signer(){
        return new Sha256();
    }
    private function get_builder(){
        return new Builder();
    }
    public function metabase_init(){
        $url = $this->get_url();
        $secret = $this->get_secret_key();
        $time = time();
        $signer = $this->get_signer();
        $builder = $this->get_builder();

        return [$builder, $signer, $secret, $url, $time];
    }
    public function get_question($metabaseSiteUrl, $token){
        return "{$metabaseSiteUrl}/embed/question/{$token}#bordered=true&titled=false&refresh=30";
    }
    public function get_dashboard($metabaseSiteUrl, $token, $dark = null){
        if($dark !== null)
            return "{$metabaseSiteUrl}/embed/dashboard/{$token}#bordered=false&titled=false&refresh=30&night";
        return "{$metabaseSiteUrl}/embed/dashboard/{$token}#bordered=false&titled=false&refresh=30";
    }
}
