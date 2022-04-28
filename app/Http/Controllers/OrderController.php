<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\LessonDetail;
use App\Models\Order;
use Carbon\Carbon;
use Exception;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        DB::beginTransaction();


        
        try {
            $result = DB::transaction(function () use ($request) {
                $lesson = Lesson::where('id', $request->lesson_id)->lockForUpdate()->first();
                if ($lesson->order_count > 0) { //or > 訂單數量

                    $lesson->order_count--;
                    $lesson->save();

                    return true;  //單筆商品，多筆商品考慮用array去包
                } else {
                    return false;
                }
            }, 3); //嘗試次數
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'state' => 400,
                'meg' => '連線逾時，請重新下單'
            ], 400);
        }

        if ($result) { //單筆商品，多筆商品考慮用array的長度判斷
            $order = new Order();
            $order->name = 'test' . '123';
            $order->email = 'test@gmail.com';
            $order->phone = '0912345678';
            $order->lesson_id = $request->lesson_id;
            $order->save();

            DB::commit();
            return $order->id;
        } else {
            DB::rollBack();
            return response()->json([
                'state' => 422,
                'meg' => '人數已滿，請選擇其他課程'
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return Order::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
