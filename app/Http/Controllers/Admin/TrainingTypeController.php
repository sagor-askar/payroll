<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $training_types = TrainingType::paginate(20);
        return view('admin.training_type.index', compact('training_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.training_type.create');
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
        TrainingType::create($data);
        return redirect()->route('admin.training_type.index')->with('message','Training Type Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training_type = TrainingType::find($id);
        return view('admin.training_type.show', compact( 'training_type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training_type = TrainingType::find($id);
        return view('admin.training_type.edit', compact( 'training_type'));
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
        $training_type = TrainingType::find($id);
        $training_type->update($data);
        return redirect()->route('admin.training_type.index')->with('message','Training Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training_type = TrainingType::find($id);
        $training_type->delete();
        return redirect()->route('admin.training_type.index')->with('message','Training Type Deleted Successfully');
    }


    public function massDestroy(Request $request)
    {
        TrainingType::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function changeStatus($id)
    {
        $training_type = TrainingType::find($id);
        if ($training_type->status == 1){
            $training_type->status = 0;
            $training_type->save();
            return redirect()->route('admin.training_type.index')->with('message','Status Change Successfully !');
        }

        if ($training_type->status == 0){
            $training_type->status = 1;
            $training_type->save();
            return redirect()->route('admin.training_type.index')->with('message','Status Change Successfully !');
        }
    }
}
