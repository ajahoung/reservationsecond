<?php


namespace App\Http\Controllers;


use App\Models\Local;
use Symfony\Component\HttpFoundation\Request;

class RapportController extends Controller
{

    public function index(Request $request)
    {
       $locals=Local::all();
        return view('rapport.index', [
            "locals"=>$locals
        ]); }
}
