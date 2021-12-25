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

    public function move(Request $request, $id=null)
    {
        $request->validate([
            'type' => 'required',
            'warehouse' => 'required',
            'from_warehouse' => 'required',            
            'trans_date' => 'required',
            'selectedItems' => 'required'
        ]);

        if($request->type == 1) {
            $request->validate([
                'client' => 'required',
                'invoiceNo' => 'required',
                'invoiceDate' => 'required',
            ]);
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
                $request->from_warehouse, 
                $request->warehouse, 
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
                $request->from_warehouse, 
                $request->warehouse, 
                $request->type, 
                auth()->user()->id, 
                $request->client, 
                $request->selectedItems
            );
        }

        return response()->json(['success' => 'success'], 200);
    } 
    
    
    public function purchase(Request $request)
    {
        

        

        
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'from_warehouse' => 'required',
            'warehouse' => 'required',
            'trans_no' => 'required|unique:transfer_headers',
            'trans_date' => 'required',
            'selectedItems' => 'required'
        ]);

        $store = new TransferHeaderController();
        $store->addTrans(
            $request->trans_no, 
            $request->trans_date, 
            $request->totalQty, 
            $request->totalPrice, 
            $request->comments, 
            0, 
            $request->trans_date, 
            $request->from_warehouse,
            $request->warehouse, 
            2, 
            auth()->user()->id, 
            0, 
            $request->selectedItems
        );

        return response()->json(['success' => 'success'], 200);
    }

    public function item($no = null)
    {
        if(!$no) return [];
        $item = new MoveItemResources(TransferHeader::with('details')->where('trans_no', $no)->firstOrFail());

        return response()->json(compact('item'), 200);
    }
}
