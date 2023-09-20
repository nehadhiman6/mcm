<?php

namespace App\Http\Controllers\Fees;

use Illuminate\Http\Request;
use App\Http\Requests\FeeStructureRequest;
use App\Http\Controllers\Controller;
use DB;
use Gate;
use App\SubFeeHead;
use App\FeeStructure;

class FeeStructureController extends Controller
{

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
    public function index(Request $request)
    {
        if (Gate::denies('FEE-STRUCTURE')) {
            return deny();
        }
//    $fee_str = \App\FeeStructure::groupBy(DB::raw('1, 2, 3, 4'))->orderBy(DB::raw('1, 2, 3, 4'))
//        ->select('fee_structures.course_id', 'fee_structures.installment_id', 'fee_structures.optional', 'fee_structures.opt_default', DB::raw('sum(fee_structures.amount) as amount'))
//        ->get();
//    dd($fee_str);
        if (!request()->ajax()) {
            $courses = \App\Course::orderBy('sno')->get();
            $installments = \App\Installment::orderBy('name')->get();
            return view('fees.feestructure.index', compact('courses', 'installments'));
        }
//    dd($request->all());
        $this->validate($request, ['std_type_id' => 'required|in:1,2|integer']);
        $fee_str = \App\FeeStructure::groupBy(DB::raw('1, 2, 3, 4'))->orderBy(DB::raw('1, 2, 3, 4'))
        ->where('std_type_id', '=', $request->std_type_id)
        ->select('fee_structures.course_id', 'fee_structures.installment_id', 'fee_structures.optional', 'fee_structures.opt_default', DB::raw('sum(fee_structures.amount) as amount'))
        ->get();
        return $fee_str;
    }

    public function feeHeadWise(Request $request)
    {
        // dd('here');
        if (!request()->ajax()) {
            $courses = \App\Course::orderBy('sno')->get();
            $feeheads = \App\FeeHead::orderBy('name')->get();
            return view('fees.feestructure.fee_head_wise', compact('courses', 'feeheads'));
        }
        $this->validate($request, [
            'std_type_id' => 'required|in:1,2|integer',
            'installment_id' => 'required|integer'
        ]);
        $fee_str = \App\FeeStructure::groupBy(DB::raw('1, 2'))->orderBy(DB::raw('1, 2'))
            ->join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
            ->where('fee_structures.std_type_id', '=', $request->std_type_id)
            ->where('fee_structures.installment_id', '=', $request->installment_id);

        if ($request->type != 'All') {
            if ($request->type == 'Compulsory') {
                $fee_str = $fee_str->whereOptional('N');
            } elseif ($request->type == 'Optional') {
                $fee_str = $fee_str->whereOptional('Y');
            } elseif ($request->type == 'Optional Default') {
                $fee_str = $fee_str->whereOptional('Y')->whereOptDefault('Y');
            }
        }

        $fee_str = $fee_str->select('fee_structures.course_id', 'sub_heads.feehead_id', DB::raw('sum(fee_structures.amount) as amount'))
            ->get();
        return $fee_str;
    }

    public function subHeadWise(Request $request)
    {
        if (Gate::denies('SUBHEAD-FEE-STRUCTURE')) {
            return deny();
        }
        // dd('here');
        if (!request()->ajax()) {
            $courses = \App\Course::orderBy('sno')->get();
            $subheads = SubFeeHead::orderBy('name')->get();
            return view('fees.feestructure.sub_head_wise', compact('courses', 'subheads'));
        }
        $this->validate($request, [
            'std_type_id' => 'required|in:1,2|integer',
            'installment_id' => 'required|integer'
        ]);
        $fee_str = FeeStructure::groupBy(DB::raw('1, 2'))->orderBy(DB::raw('2, 1'))
            ->join('sub_heads', 'sub_heads.id', '=', 'fee_structures.subhead_id')
            ->where('fee_structures.std_type_id', '=', $request->std_type_id)
            // ->where('fee_structures.course_id', '=', 13)
            ->where('fee_structures.installment_id', '=', $request->installment_id);

        if ($request->type != 'All') {
            if ($request->type == 'Compulsory') {
                $fee_str = $fee_str->whereOptional('N');
            } elseif ($request->type == 'Optional') {
                $fee_str = $fee_str->whereOptional('Y');
            } elseif ($request->type == 'Optional Default') {
                $fee_str = $fee_str->whereOptional('Y')->whereOptDefault('Y');
            }
        }

        $fee_str = $fee_str->select('fee_structures.course_id', 'fee_structures.subhead_id', 'fee_structures.amount')
            ->get();
        return reply('OK', ['fee_str' => $fee_str]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (Gate::denies('FEE-STRUCTURE')) {
            return deny();
        }
        // dd($request->all());
        $rules = [
        'std_type_id' => 'required',
        'installment_id' => 'required',
        'feehead_id' => 'required',
    ];
        $messages = [];
        $this->validate($request, $rules, $messages);

        $stdtype = \App\StudentType::where('id', '=', $request->std_type_id)->first();
        $feehead = \App\FeeHead::whereId($request->feehead_id)->first();
        $installment = \App\Installment::whereId($request->installment_id)->first();
        //  dd($feehead);
        $courses = \App\Course::orderBy('sno')->get();
        $subheads = $feehead->subHeads;

        $fee_str = \App\Course::crossJoin('sub_heads', function ($q) use ($feehead) {
            $q->where('feehead_id', '=', $feehead->id);
        })
            ->leftJoin('fee_structures', function ($q) use ($request) {
                $q->on('fee_structures.course_id', '=', 'courses.id')
              ->on('fee_structures.subhead_id', '=', 'sub_heads.id')
              ->where('fee_structures.std_type_id', '=', $request->std_type_id)
              ->where('fee_structures.installment_id', '=', $request->installment_id);
            })
            ->select(DB::raw('courses.id course_id, sub_heads.id subhead_id, ifnull(fee_structures.amount,0) amount, ifnull(fee_structures.optional,"N") optional, ifnull(fee_structures.opt_default,"N") opt_default'))
            ->orderBy('sub_heads.id')->orderBy('courses.id')->get();
        $fee_str = $fee_str->groupBy(function ($item, $key) {
            return $item['subhead_id'] . '_' . $item['course_id'];
        });
//    return $fee_str;
        return view('fees.feestructure.create', compact('stdtype', 'feehead', 'installment', 'courses', 'fee_str'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Gate::denies('FEE-STRUCTURE')) {
            return deny();
        }
//    dd($request->all());
        $this->validate($request, [
            'std_type_id' => 'required|integer|in:1,2',
            'installment_id' => 'integer|min:1',
            'feehead_id' => 'integer|min:1',
        ]);
        $fee_strs = new \Illuminate\Database\Eloquent\Collection();
        $subhead_ids = \App\FeeHead::findOrFail($request->feehead_id)->subHeads->pluck('id');
//    dd($subhead_ids);
        $saved_fee_strs = \App\FeeStructure::where('std_type_id', '=', $request->std_type_id)
            ->where('installment_id', '=', $request->installment_id)
            ->whereIn('subhead_id', $subhead_ids)
            ->get();
        $attributes = $request->only(['std_type_id', 'installment_id']);
        foreach ($request->fee_str as $subhead_course => $fee) {
            $fee_str = $saved_fee_strs->where('course_id', $fee[0]['course_id'])->where('subhead_id', $fee[0]['subhead_id'])->first();
            if (!$fee_str && floatval($fee[0]['amount']) > 0) {
                $fee_str = new \App\FeeStructure();
            }
            if ($fee_str) {
                if ($fee[0]['optional'] == 'N') {
                    $fee[0]['opt_default'] = 'N';
                }
                $fee_str->fill($attributes + $fee[0]);
                $fee_strs->add($fee_str);
            }
        }
//    dd($fee_strs);
        DB::connection(getYearlyDbConn())->beginTransaction();
        foreach ($fee_strs as $fee_str) {
            $fee_str->save();
        }
        DB::connection(getYearlyDbConn())->commit();
        return response()->json(['success' => "Fee Structure saved successfully"], 200, ['app-status' => 'success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function showCopyForm()
    {
        if (Gate::denies('COPY-FEE-STRUCTURE')) {
            return deny();
        }
        $courses = \App\Course::orderBy('sno')->get();
        $installments = \App\Installment::orderBy('name')->get();
        return view('fees.feestructure.copy', compact('courses', 'installments'));
    }

    public function makeCopy(Request $request)
    {
        if (Gate::denies('COPY-FEE-STRUCTURE')) {
            return deny();
        }
        // dd($request->all());
        $rules = [
          'std_type_id' => 'required|integer|in:1,2',
          'installment_id' => 'required|integer|exists:'.getYearlyDbConn().'.installments,id',
          'to_std_type_id' => 'required|integer|in:1,2',
          'to_installment_id' => 'required|integer|exists:'.getYearlyDbConn().'.installments,id',
        ];
        if ($request->std_type_id == $request->to_std_type_id && $request->installment_id == $request->to_installment_id) {
            $rules['same_values'] = 'required';
        }
        $this->validate($request, $rules, ['same_values.required' => 'Select different criteria for from and to parameters!!']);

        $feestr = \App\FeeStructure::where('std_type_id', '=', $request->std_type_id)
          ->where('installment_id', '=', $request->installment_id);
        
        if ($feestr->count() == 0) {
            flash('No records find to copy!!');
        } else {
            \App\FeeStructure::where('std_type_id', '=', $request->to_std_type_id)
              ->where('installment_id', '=', $request->to_installment_id)->delete();
            $fields = array_keys(array_except($feestr->first()->attributesToArray(), ['id', 'std_type_id', 'installment_id']));
            $fislds_str = implode(',', $fields);
            // $fields = array_except($feestr->first()->attributesToArray(), ['id', 'std_type_id', 'installment_id', 'created_by', 'updated_by', 'created_at', 'updated_at']);
            $sql = "insert into ".getYearlyDb().".fee_structures ({$fislds_str},std_type_id,installment_id) select {$fislds_str},{$request->to_std_type_id},{$request->to_installment_id} from ".getYearlyDb().".fee_structures where std_type_id={$request->std_type_id} and installment_id={$request->installment_id}";
            // dd($sql);
            DB::insert($sql);
        }



        return redirect()->back()->with($request->all());
    }
}
