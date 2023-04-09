<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Indicator;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ufs = Indicator::orderByDesc('date')->paginate(10);
        $title = Indicator::first()->name;
        $source = Indicator::first()->source;
        $currency = Indicator::first()->currency;
        return view('indicators.index', compact('ufs', 'title', 'source', 'currency'));
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
        $validator =  Validator::make($request->all(), [
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date', 'max:255', 'unique:indicators']
        ],
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'date' => 'el campo :attribute es inválido.',
                'unique' => 'Ya hay un registro con esta fecha.'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error'=> $validator->errors()], 400);
        }

        Indicator::create([
            'value' => $request->value,
            'date' => $request->date
        ]);

        return response()->json(['success'=>'UF registrada con éxito.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $uf = Indicator::find($id);
        return response()->json(['uf' => $uf]);
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
        $validator =  Validator::make($request->all(), [
            'value' => ['required', 'numeric'],
            'date' => ['required', 'date', 'max:255', \Illuminate\Validation\Rule::unique('indicators')->ignore($request->id)]
        ],
            $messages = [
                'required' => 'El campo :attribute es obligatorio.',
                'date' => 'el campo :attribute es inválido.',
                'unique' => 'Ya hay un registro con esta fecha.'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error'=> $validator->errors()], 400);
        }
        $uf = Indicator::find($request->id);
        $uf->update([
            'value' => $request->value,
            'date' => $request->date
        ]);
        return response()->json(['success'=>'UF actualizada con éxito.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $uf = Indicator::find($id);
        $uf->delete();
        return response()->json(['success'=>'UF eliminada con éxito.']);
    }

    public static function getResultsByRangeDate(Request $request){
        $start = Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
        $end = Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');

        $results = Indicator::select('date', 'value')->whereBetween('date', [$start, $end])->orderBy('indicators.date','asc')->get();
        
        $arr = [];
        foreach ($results as $res) {
            $date = Carbon::createFromFormat('Y-m-d', $res->date)->format('d-m-Y');
            array_push($arr, [strtotime($date)*1000, $res->value]);
        }

        
        return response()->json(['results'=> $arr]);
    }
}
