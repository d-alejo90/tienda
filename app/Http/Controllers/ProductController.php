<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Helpers\WebServiceManagerCurl;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get();
        foreach ($products as &$product) {
            $sale_price = $this->recalculatePrice($product);
            $product->sale_price = $sale_price;
        }        
        return view('product/list', compact('products'));
    }

    private static function getRange($weight)
    {
        if($weight >= 0 && $weight <= 10) {
            return 1;
        }
        if($weight > 10 && $weight <= 20) {
            return 2;
        }
        if($weight > 20 && $weight <= 30) {
            return 3;
        }
        if($weight > 30 && $weight <= 40) {
            return 4;
        }
        if($weight > 40) {
            return 5;
        }
    }

    private static function getComission($range, $type)
    {
        $comission = 0;
        switch ($range){
            case 1: 
                return ($type == 'Basica') ? 0.15 : 0.10;
                break;
            case 2: 
                return ($type == 'Basica') ? 0.25 : 0.20;
                break;
            case 3: 
                return ($type == 'Basica') ? 0.35 : 0.30;
                break;
            case 4: 
                return ($type == 'Basica') ? 0.45 : 0.40;
                break;
            case 5: 
                return ($type == 'Basica') ? 0.55 : 0.50;
                break;
            default:
                return 0;
        }
    }

    private static function getTrm() {
        try {
            $url = "http://apilayer.net/api/live?access_key=" . env('CURRENCY_LAYER_ACCESS_KEY') . "&currencies=COP";
            $api = new WebServiceManagerCurl($url);
            $response = \json_decode($api->get());
            return $response->quotes->USDCOP;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    private function recalculatePrice(Product $product) 
    {
        $range = self::getRange($product->weight);
        $comission = $product->price * self::getComission($range, $product->post_type);
        print_r($comission);
        $trm = self::getTrm();; // TODO
        $basePrice = (($product->price + ($product->weight * 10) + $comission) * $trm);
        $totalPrice = ($product->post_type == 'Basica') ? $basePrice + ($basePrice * 0.16) : $basePrice + ($basePrice * 0.14);
        return $basePrice;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
