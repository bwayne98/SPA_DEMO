<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;

class GreenWorldController extends Controller
{
    //
    function createOrder(Request $request){

        $url = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

        $response = Http::withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded'
        ])->post($url,[
            'MerchantID' => '2000132', //商店編碼
            'MerchantTradeNo' => $request->id, //訂單編號
            'StoreID' => 'LaraJoy', //自訂分店代碼
            'MerchantTradeDate' => Carbon::now(), //交易時間
            
            'TotalAmount' => 3600, //交易金額
            'TradeDesc' => 'LaraJoy', //交易描述
            'ItemName' => 'lesson'.$request->lesson_id, //商品名稱
            'ReturnURL' => 'http://36.233.30.126/orderstate/api/GreenWorldResponse', //綠界回傳SERVER的地址
            'ChoosePayment' => 'Credit',    //交易方式

            'CheckMacValue' => 95833941, //檢查碼
            'ClientBackURL' => 'http://36.233.30.126/orderstate/'.$request->id, //CLIENT端倒回頁面
            'EncryptType' => 1, //加密設定
            
            //Credit
            'BindingCard' => 0, //記憶信用卡 

        ]);


        return $response;

    }

}
