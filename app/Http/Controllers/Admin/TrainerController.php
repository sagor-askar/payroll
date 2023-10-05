<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $trainers = Trainer::paginate(20);
        return view('admin.trainer.index', compact('trainers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trainer.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        Trainer::create($data);
        return redirect()->route('admin.trainer.index')->with('message','Trainer Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $trainer = Trainer::find($id);
        return view('admin.trainer.show', compact( 'trainer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trainer = Trainer::find($id);
        return view('admin.trainer.edit', compact( 'trainer'));
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
        $data =  $request->all();
        $trainer = Trainer::find($id);
        $trainer->update($data);
        return redirect()->route('admin.trainer.index')->with('message','Trainer Updated Successfully');
    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trainer = Trainer::find($id);
        $trainer->delete();
        return redirect()->route('admin.trainer.index')->with('message','Trainer Deleted Successfully');
    }

    public function massDestroy(Request $request)
    {
        Trainer::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function changeStatus($id)
    {

        $trainer = Trainer::find($id);
        if ($trainer->status == 1){
            $trainer->status = 0;
            $trainer->save();
            return redirect()->route('admin.trainer.index')->with('message','Status Change Successfully !');
        }

        if ($trainer->status == 0){
            $trainer->status = 1;
            $trainer->save();
            return redirect()->route('admin.trainer.index')->with('message','Status Change Successfully !');
        }
    }

}
