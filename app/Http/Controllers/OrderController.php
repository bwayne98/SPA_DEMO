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
        //確認報名人數

        // dd(Lesson::studentCount($request->lesson_id));

        // return DB::transaction(function () use ($request) {
        //     return DB::table('orders')->lockForUpdate()->when((Lesson::studentCount($request->lesson_id) >= 50),
        //         function () {
        //             DB::rollBack();
        //             return response()->json([
        //                 'state' => 422,
        //                 'meg' => '人數已滿，請選擇其他課程'
        //             ], 422);
        //         },
        //         function () use ($request) {
        //             $order = new Order();
        //             $order->name = 'test' . '123';
        //             $order->email = 'test@gmail.com';
        //             $order->phone = '0912345678';
        //             $order->lesson_id = $request->lesson_id;
        //             $order->save();

        //             return $order->id;
        //         }
        //     );
        // });

        DB::beginTransaction();

        $i = 0;
        while ($i < 3) {
            try {
                $lesson = Lesson::where('id', $request->lesson_id)->lockForUpdate()->first();
                if ($lesson->order_count > 0) {

                    $lesson->order_count--;
                    $lesson->save();

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
            } catch (Exception $e) {
                sleep(5);
                $i++;
                continue;
            }
        }

        return response()->json([
            'state' => 400,
            'meg' => '連線逾時，請重新下單'
        ], 400);


        // if (Lesson::studentCount($request->lesson_id) > 100) {

        // } else {

        // }
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
