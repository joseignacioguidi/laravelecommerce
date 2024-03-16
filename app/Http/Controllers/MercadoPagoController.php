<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Resources\Preference;
use MercadoPago\Resources\Preference\Item;
use MercadoPago\Resources\Preference\Payer;
use Validator;
class MercadoPagoController extends Controller
{
    public function generateLink(Request $request){
        
        MercadoPagoConfig::setAccessToken(env('MERCADO_PAGO_ACCESS_TOKEN'));
        $items = [];
        $transaction_amount = 0;
        $validators = Validator::make($request->all(),[
            'payer.name'=>'required',
            'payer.surname'=>'required',
            'payer.email'=>'required|email',
            'payer.phone.area_code'=>'required',
            'payer.phone.number'=>'required',
            'payer.address.street_name'=>'required',
            'payer.address.street_number'=>'required',
            'payer.address.zip_code'=>'required',
            'items'=>'required|array',
            'items.*.id'=>'required',
            'items.*.quantity'=>'required|integer'
        ]);
        if($validators->fails()){
            return response()->json(['message'=>$validators->errors()],400);
        }
        foreach($request->items as $item){
            $producto = Product::find($item['id']); 
            $itemMP = new Item();
            $itemMP->title = $producto->name;
            $itemMP->description = $producto->description;
            $itemMP->quantity = $item['quantity'];
            $itemMP->unit_price = $producto->price;
            $itemMP->currency_id = 'ARS';
            array_push($items,$itemMP);
            $transaction_amount += $producto->price * $itemMP->quantity;
        }
        if(User::where('email',$request->payer['email'])->first() == null){
            return response()->json(['message'=>'User not found'],404);
        }
        $payer = new Payer();
        $payer->name = $request->payer['name'];
        $payer->surname = $request->payer['surname'];
        $payer->email = $request->payer['email'];
        $payer->phone = [
            'area_code'=>$request->payer['phone']['area_code'],
            'number'=>$request->payer['phone']['number']
        ];
        $payer->address = [
            'street_name'=>$request->payer['address']['street_name'],
            'street_number'=>$request->payer['address']['street_number'],
            'zip_code'=>$request->payer['address']['zip_code']
        ];

        $notification_url = env('APP_URL').'/buy/notification';

        $preference = array();
        $preference['items'] = $items;
        $preference['payer'] = $payer;
        $preference['back_urls'] = [
            'success'=>env('APP_URL').'/buy/success',
            'failure'=>env('APP_URL').'/buy/failure',
            'pending'=>env('APP_URL').'/buy/pending'
        ];
        $preference['auto_return'] = 'approved';
        $preference['notification_url'] = $notification_url;
        $preference['transaction_amount'] = $transaction_amount;
        $client = new PreferenceClient();
        $preference = $client->create($preference);
        if(isset($preference)){
            return response()->json(['message'=>$preference->init_point],201);
        }else{
            return response()->json(['message'=>'Error creating preference'],500);
        }
    }

    public function notification(Request $request){

    }
}
