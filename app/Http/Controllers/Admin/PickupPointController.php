<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Model\PickupPoint;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
class PickupPointController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort_search =null;
        $pickup_points = PickupPoint::orderBy('created_at', 'desc');
        if ($request->has('search')){
            $sort_search = $request->search;
            $pickup_points = $pickup_points->where('name', 'like', '%'.$sort_search.'%');
        }
        $pickup_points = $pickup_points->paginate(10);
        return view('admin-views.pickup_point.index', compact('pickup_points','sort_search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin-views.pickup_point.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pickup_point = new PickupPoint;
        $pickup_point->name = $request->name;
        $pickup_point->address = $request->address;
        $pickup_point->phone = $request->phone;
        $pickup_point->pick_up_status = $request->pick_up_status;
    
        $pickup_point->save();

        Toastr::success('Pickup Point added successfully.');
        return redirect()->route('admin.pick_up_points.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $lang           = $request->lang;
        $pickup_point   = PickupPoint::findOrFail($id);
        return view('admin-views.pickup_point.edit', compact('pickup_point','lang'));
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
        $pickup_point = PickupPoint::findOrFail($id);
        if($request->lang == env("DEFAULT_LANGUAGE")){
            $pickup_point->name = $request->name;
            $pickup_point->address = $request->address;
        }

        $pickup_point->phone = $request->phone;
        $pickup_point->pick_up_status = $request->pick_up_status;
        $pickup_point->save();

        Toastr::success('Pickup Point Updated successfully.');
        return redirect()->route('admin.pick_up_points.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $pickup_point = PickupPoint::findOrFail($id);

        if(PickupPoint::destroy($id)){
            Toastr::success('Pickup Point Deleted successfully.');
            return redirect()->route('admin.pick_up_points.index');
        }

    }
}
