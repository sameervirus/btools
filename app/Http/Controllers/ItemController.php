<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Http\Request;
use App\Http\Resources\ItemResources;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result['items'] = ItemResources::collection(Item::all());
        $result['categories'] = Category::all();
        $result['units'] = Unit::all();
        return response()->json($result, 200);
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
        $request->validate([
            'code' => 'required|unique:items',
            'name' => 'required|unique:items',
            'unit_id' => 'required',
            'category_id' => 'required',
        ]);

        $item = Item::create([
            'code' => $request->code,
            'name' => $request->name,      
            'unit_id' => $request->unit_id,      
            'category_id' => $request->category_id,      
            'iprice' => $request->iprice,      
        ]);

        if($item) return response()->json(new ItemResources($item), 200);

        return response()->json(['error' => 'Unknown Error'], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([            
            'unit_id' => 'required',
            'category_id' => 'required',
        ]);

        if($item->code != $request->code) {
            $request->validate([
                'code' => 'required|unique:items',
            ]);
            $item->code = $request->code;
        }

        if($item->name != $request->name) {
            $request->validate([
                'name' => 'required|unique:items',
            ]);
            $item->name = $request->name;
        }

           
        $item->unit_id = $request->unit_id;    
        $item->category_id = $request->category_id;     
        $item->iprice = $request->iprice;      
        

        if($item->save()) return $this->index();

        return response()->json(['error' => 'Unknown Error'], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
