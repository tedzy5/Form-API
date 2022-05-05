<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index() {
        $categories = Http::get(url('api/categories'));
        if($categories->status() != 200) {
            return 'No!';
        }

        $categories = json_decode($categories, true);
        $categories = collect($categories);

        return view('welcome', compact('categories'));
    }
}
