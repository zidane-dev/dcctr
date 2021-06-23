<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MetabaseController extends Controller
{
    public function get_url(){
        return 'http://localhost:3000';

    }
    public function get_secret_key(){
        return '338c82373475e1a429e615e7613f7c63c714271a4ae9beeaf1519d4246d8a353';
    }

    public function get_question($metabaseSiteUrl, $token){
        return "{$metabaseSiteUrl}/embed/question/{$token}#bordered=true&titled=true";
    }

    public function get_dashboard($metabaseSiteUrl, $token){
        return "{$metabaseSiteUrl}/embed/dashboard/{$token}#bordered=false&titled=false";
    }
}
