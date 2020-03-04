<?php

namespace App\Http\Controllers;

use App\Category;
use App\InvestmentPlan;
use App\InvestmentPlans;
use Illuminate\Http\Request;


class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()

    {

        $page_title = 'All Miner';
        $categories = Category::all();
        return view('dashboard.category', compact('page_title','categories'));

    }
    public function plan()

    {

        $page_title = 'Investment Plans';
        $plans = InvestmentPlans::all();
        return view('dashboard.plan', compact('page_title','plans'));

    }

    public function store(Request $r)

    {

        $r->validate([
            'name' => 'required|unique:categories',
            'code' => 'required|unique:categories'
        ]);

        $category = Category::create([
            'name' => $r->post('name'),
            'code' => $r->code
        ]);

        if (!$category){
            return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');
        }

        return redirect()->back()->with('message', 'Miner Created Successfully.');

    }

    public function update(Request $r)

    {

        $r->validate([
            'id' => 'required|numeric',
            'name' => 'required',
            'code' => 'required'
        ]);

        $category = Category::find($r->post('id'));

        if ($category) {
            $category->name = $r->post('name');
            $category->code = $r->code;
            $category->save();
            return redirect()->back()->with('message', 'Updated Successfully.');
        }

        return redirect()->back()->withErrors('Unexpected Error! Please Try Again.');

    }
}
