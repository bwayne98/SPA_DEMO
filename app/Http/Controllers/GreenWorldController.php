<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonDetail;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Exceptions\RtnException;
use Omnipay\Omnipay;
use Illuminate\Support\Str;

class GreenWorldController extends Controller
{
    //

    public function __construct()

    {
        $this->geteway = Omnipay::create('ECPay');
        $this->geteway->initialize([
            'hashKey' => '5294y06JbISpM5x9',
            'hashIv' => 'v77hoKGq4kWxNNIS',
            'MerchantID' => '2000132', //商店編碼
            'EncryptType' => 1, //加密設定
            'testMode' => true,
        ]);
    }


    public function createOrder(Request $request)
    {

        $student_count = Lesson::studentCount($request->lesson_id);

        if ($student_count > 20) {
            return response('班級人數已滿，請重新報名課程', 422);
        }

        // $response = $this->geteway->purchase([
        //     'MerchantTradeNo' => $request->id, //訂單編號
        //     'StoreID' => 'LaraJoy', //自訂分店代碼
        //     'MerchantTradeDate' => Carbon::now()->format('Y/m/d H:i:s'), //交易時間

        //     'PaymentType' => 'aio',
        //     'TotalAmount' => 1111, //交易金額
        //     'TradeDesc' => 'LaraJoy', //交易描述
        //     'ItemName' => 'lesson' . $request->lesson_id, //商品名稱
        //     'notifyUrl' => 'https://36.233.38.230/api/greenworldcallback', //綠界回傳SERVER的地址
        //     'ChoosePayment' => 'Credit',    //交易方式

        //     'ClientBackURL' => 'https://36.233.38.230/orderstate/' . $request->id, //CLIENT端倒回頁面
        // ])->send();


        // dump($response);
        // return $response->redirect();


        // $url = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';


        // $request = Http::withHeaders([
        //     'Content-Type' => 'application/x-www-form-urlencoded'
        // ])->post($url, [
        //     'MerchantID' => '2000132', //商店編碼
        //     'MerchantTradeNo' => $request->id, //訂單編號
        //     'StoreID' => 'LaraJoy', //自訂分店代碼
        //     'MerchantTradeDate' => Carbon::now(), //交易時間

        //     'hashKey' => '5294y06JbISpM5x9',
        //     'hashIv' => 'v77hoKGq4kWxNNIS',

        //     'TotalAmount' => 3600, //交易金額
        //     'TradeDesc' => 'LaraJoy', //交易描述
        //     'ItemName' => 'lesson' . $request->lesson_id, //商品名稱
        //     'ReturnURL' => 'http://36.233.30.126/orderstate/api/GreenWorldResponse', //綠界回傳SERVER的地址
        //     'ChoosePayment' => 'Credit',    //交易方式

        //     'CheckMacValue' => 95833941, //檢查碼
        //     'ClientBackURL' => 'http://36.233.30.126/orderstate/' . $request->id, //CLIENT端倒回頁面
        //     'EncryptType' => 1, //加密設定

        //     //Credit
        //     'BindingCard' => 0, //記憶信用卡 
        // ]);

        // return $request;


        try {
            $factory = new Factory([
                'hashKey' => '5294y06JbISpM5x9',
                'hashIv' => 'v77hoKGq4kWxNNIS',
            ]);
            $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

            $input = [
                'MerchantID' => '2000132',
                'MerchantTradeNo' => $request->id,
                'MerchantTradeDate' => date('Y/m/d H:i:s'),
                'PaymentType' => 'aio',
                'TotalAmount' => 3600,
                'TradeDesc' => UrlService::ecpayUrlEncode($request->lesson_id),
                'ItemName' => 'lesson' . $request->lesson_id,
                'ReturnURL' => 'https://36.233.38.230/api/greenworldcallback',
                'ClientBackURL' => 'https://36.233.38.230/orderstate/' . $request->id,
                'ChoosePayment' => 'Credit',
                'EncryptType' => 1,
            ];
            $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

            echo ($autoSubmitFormService->generate($input, $action));
        } catch (RtnException $e) {
            echo '(' . $e->getCode() . ')' . $e->getMessage() . PHP_EOL;
        }
    }


    function orderCallback(Request $request)
    {

        $order = Order::where('id', $request->MerchantTradeNo);

        $order->update([
            'MerchantTradeNo' => $request->CheckMacValue,
            'TradeNo' => $request->TradeNo,
            'paid' => true
        ]);




        return  '';
    }
}
