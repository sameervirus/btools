<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;


use App\Models\Client;
use App\Models\Item;
use App\Models\Warehouse;
use App\Models\TransferType;
use App\Models\TransferHeader;

use App\Http\Resources\ItemResources;
use App\Http\Resources\MoveResources;
use App\Http\Resources\MoveItemResources;

use App\Http\Controllers\TransferHeaderController;
use App\Http\Resources\DetailMoveResources;
use App\Http\Resources\StockResources;
use App\Models\Category;
use App\Models\TransferDetails;

class OrderController extends Controller
{
    public function index()
    {
        $clients = Client::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $items = ItemResources::collection(Item::all());

        return response()->json(compact('clients', 'warehouses', 'items'), 200);
    }

    public function movements()
    {
        $clients = Client::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $transfers = TransferType::orderBy('name')->get();
        $moves = MoveResources::collection(TransferHeader::orderBy('trans_date', 'desc')->take(500)->get());

        return response()->json(compact('clients', 'warehouses', 'transfers', 'moves'), 200);
    }

    public function storage()
    {
        $categories = Category::orderBy('name')->get();
        $warehouses = Warehouse::orderBy('name')->get();
        $storage = StockResources::collection(Item::with('warehouses')->get());

        return response()->json(compact('categories', 'warehouses', 'storage'), 200);
    }

    public function item($code = null)
    {
        if(!$code) return [];

        $item = new StockResources(Item::where('code', $code)->first());

        $moves = DetailMoveResources::collection(TransferDetails::with('header')->where('item_id', $item->id)->get());

        return response()->json(compact('item', 'moves'), 200);
    }

    public function move(Request $request, $id=null)
    {
        $request->validate([
            'type' => 'required',           
            'trans_date' => 'required',
            'selectedItems' => 'required'
        ]);

        if(in_array($request->type, [1, 4])) {
            $request->validate([
                'client' => 'required',
                'invoiceNo' => 'required',
                'invoiceDate' => 'required',
                'warehouse' => 'required',
            ]);
            if($request->type == 1) {
                $from = null;
                $to = $request->warehouse;
            } else if($request->type == 4) {
                $from = $request->warehouse;
                $to = null;
            }
        }

        if($request->type == 2) {
            $request->validate([
                'from_warehouse' => 'required',
                'warehouse' => 'required',
            ]);
            $from = $request->from_warehouse;
            $to = $request->warehouse;
        }

        if(in_array($request->type, [3])) {
            $request->validate([
                'warehouse' => 'required',
            ]);
            $from = $request->warehouse;
            $to = $request->warehouse;
        }

        if(in_array($request->type, [5, 6])) {
            $request->validate([
                'warehouse' => 'required',
            ]);
            $from = $request->warehouse;
            $to = null;
        }

        if(!$request->isUpdate) {
            $request->validate([
                'trans_no' => 'required|unique:transfer_headers',
            ]);
        } else {
            $request->validate([
                'trans_no' => 'required',
            ]);
        }

        if($request->isUpdate) {
            $update = new TransferHeaderController();
            $update->updateTrans(
                $request->trans_no, 
                $request->trans_date, 
                $request->totalQty, 
                $request->totalPrice, 
                $request->comments, 
                $request->invoiceNo, 
                $request->invoiceDate, 
                $from, 
                $to, 
                $request->type, 
                auth()->user()->id, 
                $request->client, 
                $request->selectedItems
            );
        } else {

            $store = new TransferHeaderController();
            $store->addTrans(
                $request->trans_no, 
                $request->trans_date, 
                $request->totalQty, 
                $request->totalPrice, 
                $request->comments, 
                $request->invoiceNo, 
                $request->invoiceDate, 
                $from, 
                $to, 
                $request->type, 
                auth()->user()->id, 
                $request->client, 
                $request->selectedItems
            );
        }

        return response()->json(['success' => 'success'], 200);
    } 

    public function trans($no = null)
    {
        if(!$no) return [];
        $item = new MoveItemResources(TransferHeader::with('details')->where('trans_no', $no)->firstOrFail());

        return response()->json(compact('item'), 200);
    }
}
