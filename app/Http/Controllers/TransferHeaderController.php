<?php

namespace App\Http\Controllers;

use App\Models\TransferHeader;
use App\Models\TransferDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransferHeaderController extends Controller
{
    
    public function addTrans($trans_no, $trans_date, $qty, $cost, $comments, $invo_no, $invo_date, $from, $to, $transfer_type_id, $user_id, $client_id, $items) {
        DB::beginTransaction();
        $trans = TransferHeader::create([
            'trans_no' => $trans_no,
            'trans_date' => $trans_date,
            'qty' => $qty,
            'cost' => $cost,
            'comments' => $comments,
            'invo_no' => $invo_no,
            'invo_date' => $invo_date,
            'from' => $from,
            'to' => $to,
            'transfer_type_id' => $transfer_type_id,
            'user_id' => $user_id,
            'client_id' => $client_id
        ]);

        if($trans) {
            foreach($items as $item) {
                TransferDetails::create([
                    'transfer_header_id' => $trans->id,
                    'item_id' => $item['id'],
                    'qty' => $item['qty'],
                    'cost' => $item['price']
                ]);

                if($transfer_type_id == 5) {
                    DB::table('item_warehouse')->updateOrInsert(
                        ['item_id' => $item['id'], 'warehouse_id' => $from],
                        ['qty' => DB::raw('qty - '. $item['qty'] .' ')]
                    );
                }

                DB::table('item_warehouse')->updateOrInsert(
                    ['item_id' => $item['id'], 'warehouse_id' => $to],
                    ['qty' => DB::raw('qty+ '. $item['qty'] .' ')]
                );
            }
            DB::commit();
        } else {
            DB::rollBack();
        }
    }

    public function updateTrans($trans_no, $trans_date, $qty, $cost, $comments, $invo_no, $invo_date, $from, $to, $transfer_type_id, $user_id, $client_id, $items)
    {
        $trans = TransferHeader::where('trans_no' , $trans_no)->first();
        DB::beginTransaction();
        $trans->trans_date = $trans_date;
        $trans->qty = $qty;
        $trans->cost = $cost;
        $trans->comments = $comments;
        $trans->invo_no = $invo_no;
        $trans->invo_date = $invo_date;
        $trans->from = $from;
        $trans->to = $to;
        $trans->transfer_type_id = $transfer_type_id;
        $trans->user_id = $user_id;
        $trans->client_id = $client_id;
        if($trans->save()) {
            foreach($items as $item) {
                $detail = TransferDetails::where('transfer_header_id', $trans->id)
                                        ->where('item_id', $item['id'])
                                        ->first();
                if($detail) {
                    DB::table('item_warehouse')->updateOrInsert(
                        ['item_id' => $item['id'], 'warehouse_id' => $to],
                        ['qty' => DB::raw('qty + '. ($detail->qty - $item['qty']) .' ')]
                    );
                    $detail->qty = $item['qty'];                
                    $detail->cost = $item['price'];
                    $detail->save();
                } else {
                    DB::table('item_warehouse')->updateOrInsert(
                        ['item_id' => $item['id'], 'warehouse_id' => $to],
                        ['qty' => DB::raw('qty + '. $item['qty'] .' ')]
                    );
                    TransferDetails::create([
                        'transfer_header_id' => $trans->id,
                        'item_id' => $item['id'],
                        'qty' => $item['qty'],
                        'cost' => $item['price']
                    ]);
                }

                
            }
            DB::commit();
        } else {
            DB::rollBack();
        }
    }
    
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TransferHeader  $transferHeader
     * @return \Illuminate\Http\Response
     */
    public function show(TransferHeader $transferHeader)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TransferHeader  $transferHeader
     * @return \Illuminate\Http\Response
     */
    public function edit(TransferHeader $transferHeader)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TransferHeader  $transferHeader
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TransferHeader $transferHeader)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TransferHeader  $transferHeader
     * @return \Illuminate\Http\Response
     */
    public function destroy(TransferHeader $transferHeader)
    {
        //
    }
}
