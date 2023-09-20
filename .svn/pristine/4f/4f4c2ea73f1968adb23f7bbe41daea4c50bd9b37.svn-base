<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Staff;
use App\Models\Staff\StaffPromotion;

class StaffPromotionController extends Controller
{
    public function show(Request $request, $id){
        $staff_id = $id;
        $desig = Staff::where('id','=',$staff_id)->first();
        $desig->load('desig','dept');
        $prom = StaffPromotion::where('staff_id','=', $staff_id)->orderBy('id', 'DESC')->get();
        if($prom){
            $prom->load('old_desig','new_desig');
        }
        
        // $last = StaffPromotion::where('staff_id','=', $staff_id)->latest()->first();
        // // dd($last);
        // if($last){
        //     $last->load('new_desig')->get();
        // }
        
        // $last->load('new_desig');
        return View('staff.staff_promotion.create',compact('staff_id','prom','desig'));
    }

    public function store(Request $request, $id = 0)
    {
        $this->validateForm($request, $id);
        // dd($request->all());
        $staff = Staff::where('id','=',$request->staff_id)->first();
        $prom = StaffPromotion::findOrNew($id);
        $prom->fill($request->all());
        $staff->desig_id = $request->new_desig_id;
        $prom->save();
        $staff->save();
        return response()->json([
            'prom' => $prom, 
            'success' => "Promotion Add Successfully",
            'prom' => StaffPromotion::where('staff_id','=', $prom->staff_id)->orderBy('id', 'DESC')->get()->load('old_desig','new_desig'),
            'desig' => Staff::where('id','=', $prom->staff_id)->first()->load('desig')
        ], 200, ['app-status' => 'success']);

        

    }
    private function validateForm(Request $request, $id)
    {
        $this->validate(
            $request,
            [
                'staff_id'=>'required|exists:staff,id',
                'new_desig_id'=>'required|exists:desigs,id',
                'promotion_date'=>'required|date_format:d-m-Y',
                
                
            ]
        );
    }

    public function edit(Request $request, $id)
    {
        $staff = StaffPromotion::findOrFail($id);
        return reply('Ok', [
            'staff' => $staff,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validateForm($request, $id);
        $staff = Staff::where('id','=',$request->staff_id)->first();
        $prom = StaffPromotion::findOrFail($id);
        $prom->fill($request->all());
        $staff->desig_id = $request->new_desig_id;
        $prom->update();
        $staff->update();
        return response()->json([
            'success' => "Promotion Updated Successfully",
            'prom' => StaffPromotion::where('staff_id','=', $prom->staff_id)->orderBy('id', 'DESC')->get()->load('old_desig','new_desig'),
            'desig' => Staff::where('id','=', $prom->staff_id)->first()->load('desig')
        ], 200, ['app-status' => 'success']);
    }
}
