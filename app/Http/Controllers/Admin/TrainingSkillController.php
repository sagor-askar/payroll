<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrainingSkill;
use Illuminate\Http\Request;

class TrainingSkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $training_skills = TrainingSkill::paginate(20);
        return view('admin.training_skill.index', compact('training_skills'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.training_skill.create');
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
        TrainingSkill::create($data);
        return redirect()->route('admin.training_skill.index')->with('message','Training Skill Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training_skill = TrainingSkill::find($id);
        return view('admin.training_skill.show', compact( 'training_skill'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training_skill = TrainingSkill::find($id);
        return view('admin.training_skill.edit', compact( 'training_skill'));
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
        $training_skill = TrainingSkill::find($id);
        $training_skill->update($data);
        return redirect()->route('admin.training_skill.index')->with('message','Training Skill Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $training_skill = TrainingSkill::find($id);
        $training_skill->delete();
        return redirect()->route('admin.training_skill.index')->with('message','Training Skill Deleted Successfully');
    }


    public function massDestroy(Request $request)
    {
        TrainingSkill::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function changeStatus($id)
    {
        $training_skill = TrainingSkill::find($id);
        if ($training_skill->status == 1){
            $training_skill->status = 0;
            $training_skill->save();
            return redirect()->route('admin.training_skill.index')->with('message','Status Change Successfully !');
        }

        if ($training_skill->status == 0){
            $training_skill->status = 1;
            $training_skill->save();
            return redirect()->route('admin.training_skill.index')->with('message','Status Change Successfully !');
        }
    }
}
