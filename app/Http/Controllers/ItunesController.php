<?php

namespace App\Http\Controllers;

use Http;
use Illuminate\Http\Request;

class ItunesController extends Controller
{
    public function index()
    {
        $url = "https://rss.itunes.apple.com/api/v1/be/apple-music/top-songs/all/12/explicit.json";
        $response = Http::get($url)->json();

        $feed = $response['feed'];

        $title = $feed['title'];
        $country = $feed['country'];
        $update = $feed['updated'];
        $resultaten = $feed['results'];


        $titel = $title . " - " . strtoupper($country);

        $result = compact( 'titel','update', 'resultaten');
        return view('itunes.index',$result);
    }
}
