<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __invoke() {

        $products = Product::orderBy('created_at', 'DESC')->get();

        return view('test.create', compact('products'));
        
        // return [
        //     'success' => true,
        //     'message' => __('messages.welcome'),
        //     'data' => [
        //         'service' => 'PMIFAPI',
        //         'version' => '1.0',
        //         'Language'  => app()->getLocale(),
        //         'support' => 'contact@pmifapi.com'
        //     ]
            
        // ];
    }

    public function edit($id)
    {
        $product = Product::where('id', $id)->firstOrFail();
        return view('test.update', compact('product'));

    }

}