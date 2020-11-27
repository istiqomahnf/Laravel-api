<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Cache;

class APIController extends Controller
{
    //
    public function get_movie_data(Request $request)
    {
    	$keyword= $request->judul;
    	$ch 	= curl_init();
    	$headers= array();

    	$url 	= "http://api.tvmaze.com/search/shows?q=".$keyword;

    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    	$result = json_decode(curl_exec($ch));
    	curl_close($ch);

    	if(!empty($result->status)){
    		$code = $result->status;
    		return response()->json(['code'=>$code, 'message'=> $result->message], $code);
    	}

    	//create cache laravel
    	$create_cache = Cache::put('carifilm', $result);

    	return response()->json(['code'=>200, 'message'=>"Succesfully get movie data", 'data' => $result], 200);
    }
}
