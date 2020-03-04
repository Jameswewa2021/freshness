<?php

namespace App\Http\Controllers;

use App\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{

    public function __construct()

    {

        $this->middleware('auth:admin');

    }

    public function index()

    {

        $data['page_title'] = 'All Partner';
        $data['partners'] = Partner::all();

        return view('dashboard.partner', $data);

    }

    public function store(Request $r)

    {

        $r->validate([
            'name' => 'required',
            'logo' => 'required|image'
        ]);

        $input['name'] = $r->post('name');

        if ($r->hasFile('logo')) {
            $logo = $r->file('logo');
            $name = time() . '.' . $logo->getClientOriginalExtension();
            if ($logo->move('assets/images/', $name)) {
                $input['logo'] = $name;
            } else {
                return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');
            }
        }

        $partner = Partner::create($input);

        if ($partner) {
            return redirect()->back()->with('message', 'Partner Added Successfully.');
        }

        return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

    }

    public function update(Request $r)

    {

        $r->validate([
            'name' => 'required'
        ]);

        $partner = Partner::find($r->post('id'));

        if ($partner) {
            $partner->name = $r->post('name');
            if ($r->hasFile('logo')) {
                $logo = $r->file('logo');
                $name = time() . '.' . $logo->getClientOriginalExtension();
                if ($logo->move('assets/images/', $name)) {
                    if (file_exists('assets/images/' . $partner->logo)) {
                        unlink('assets/images/' . $partner->logo);
                        //echo 'logo deleted';
                    }
                    $partner->logo = $name;
                    //echo 'Logo Updated';
                }
            }
        }

        $partner->save();

        return redirect()->back()->with('message', 'Partner Updated Successfully.');

    }

    public function delete(Request $r)

    {

        $r->validate([
            'id' => 'required|numeric'
        ]);

        $id = $r->post('id');

        $partner = Partner::find($id);

        if ($partner) {
            if (file_exists('assets/images/' . $partner->logo)) {
                unlink('assets/images/' . $partner->logo);
            }
            $partner->delete();
            return redirect()->back()->with('message', 'Partner Deleted Successfully');
        }

        return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

    }
}
