<?php

namespace App\Http\Controllers;

use App\Procedure;
use Illuminate\Http\Request;

class ProcedureController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()

    {

        $data['steps'] = Procedure::all();
        $data['page_title'] = 'Work Procedure';

        return view('dashboard.procedure', $data);

    }

    public function store(Request $r)

    {

        $r->validate([
            'name' => 'required',
            'image' => 'required|image',
            'description' => 'required'
        ]);

        $input['name'] = $r->post('name');
        $input['description'] = $r->post('description');

        if ($r->hasFile('image')) {
            $image = $r->file('image');
            $name = time() . '.' . $image->getClientOriginalExtension();
            if ($image->move('assets/images', $name)) {
                $input['image'] = $name;
            } else {
                session()->flash('message', 'Image Not Uploaded.');
                session()->flash('type', 'error');
                session()->flash('title', 'Error');
                return redirect()->back();
            }
        } else {
            session()->flash('message', 'Image Not Uploaded.');
            session()->flash('type', 'error');
            session()->flash('title', 'Error');
            return redirect()->back();
        }

        $procedure = Procedure::create($input);

        if ($procedure) {
            session()->flash('message', 'Step Added Successfully.');
            session()->flash('type', 'success');
            session()->flash('title', 'Success');
            return redirect()->back();
        }

        session()->flash('message', 'Unexpected Error! Please Try Again.');
        session()->flash('type', 'error');
        session()->flash('title', 'Error');
        return redirect()->back();



    }

    public function update(Request $r)

    {

        $r->validate([
            'id' => 'required|numeric',
            'name' => 'required',
            'description' => 'required'
        ]);

        $step = Procedure::find($r->post('id'));

        if ($step) {

            $step->name = $r->post('name');
            $step->description = $r->post('description');

            if ($r->hasFile('image')) {
                $image = $r->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                if ($image->move('assets/images', $name)) {

                    if (file_exists('assets/images/' . $step->image)) {
                        unlink('assets/images/' . $step->image);
                    }

                    $step->image = $name;
                }
            }

            $step->save();

            session()->flash('message', 'Step Updated Successfully.');
            session()->flash('type', 'success');
            session()->flash('title', 'Success');

            return redirect()->back();

        }


        session()->flash('message', 'Unexpected Error! Please Try Again.');
        session()->flash('type', 'error');
        session()->flash('title', 'Error');

        return redirect()->back();

    }

    public function delete(Request $r)

    {

        $r->validate([
            'id' => 'required|numeric'
        ]);

        $id = $r->post('id');

        $procedure = Procedure::find($id);

        if ($procedure) {

            if (file_exists('assets/images/' . $procedure->image)) {
                unlink('assets/images/' . $procedure->image);
            }

            $procedure->delete();

            session()->flash('message', 'Step Deleted Successfully.');
            session()->flash('type', 'success');
            session()->flash('title', 'Success');

            return redirect()->back();

        }

        session()->flash('message', 'Unexpected Error! Please Try Again.');
        session()->flash('type', 'error');
        session()->flash('title', 'Error');

        return redirect()->back();

    }
}
