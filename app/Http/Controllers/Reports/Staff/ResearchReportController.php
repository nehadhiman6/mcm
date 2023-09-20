<?php

namespace App\Http\Controllers\Reports\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Department;
use App\Faculty;
use App\Research;
use Illuminate\Support\Facades\DB;
use Gate;
class ResearchReportController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('research-report')){
            return deny();

        }
        if (!request()->ajax()) {
            $form_data = $request->all();
            if(isset($form_data['item_id']) && $form_data['item_id'] != ''){
                $dt2 = getDateFormat(getDateAdd($request->as_on, -1 * $request->year, 'Y'), 'ymd');
                $form_data['date_to'] = getDateFormat($dt2,'dmy');
            }
            return view('staff.reports.research.index', ['form_data' => $form_data]);
        }
        // dd($request->all());
        $rules = [
            'date_from' => 'required|date:"d-m-y"',
            'date_to' => 'required|date:"d-m-y"',
        ];
        $this->validate($request, $rules);
        $dt1 = getDateFormat($request->date_from, 'ymd');
        $dt2 = getDateFormat($request->date_to, 'ymd');
        $data = Research::join('staff', 'staff.id', '=', 'researches.staff_id')
                        ->join('departments', 'staff.dept_id', '=', 'departments.id')
            ->select([
                DB::raw("trim(concat(ifnull(staff.salutation,''),' ',staff.name,' ',ifnull(staff.middle_name,''),' ',ifnull(staff.last_name,''))) as name"),
                'researches.title1 as title', 'researches.title2 as paper_title', 'researches.title3 as title_pro',
                'researches.level', 'researches.publisher', 'researches.pub_mode as mode', 'researches.isbn',
                DB::raw("date_format(pub_date,'%b,%Y') as month_year"), 'researches.authorship',
                'researches.institute', 'researches.ugc_approved', 'researches.peer_review',
                DB::raw("trim(concat(ifnull(researches.indexing,''),',',ifnull(researches.indexing_other,''))) as indexing"),
                'researches.doi_no', 'researches.impact_factor', 'researches.citations', 'researches.h_index',
                'researches.i10_index', 'researches.res_award', 'researches.relevant_link','departments.name as depart_name','researches.type','staff.source',
            ])->whereBetween('pub_date', [$dt1, $dt2]);
        if ($request->has('depart_id') && count($request->depart_id) > 0) {
            $data = $data->whereIn('staff.dept_id', $request->depart_id);
        }
        if ($request->has('faculty_id') && count($request->faculty_id) > 0) {
            $data = $data->whereIn('staff.faculty_id', $request->faculty_id);
        }
        if ($request->has('type') && count($request->type) > 0) {
            $data = $data->whereIn('researches.type', $request->type);
        }
        if ($request->indexing) {
            $data = $data->where('researches.indexing', 'like', '%' . $request->indexing . '%');
        }

        if ($request->has('level') && count($request->level) > 0) {
            $data = $data->whereIn('researches.level', $request->level);
        }

        if ($request->source) {
            $data = $data->where('staff.source', $request->source);
        }

        if (intval($request->staff_id) > 0) {
            $data = $data->where('staff.id', $request->staff_id);
        }

        $data = $data->get();
        // name
        // title
        // paper_title
        // title_pro
        // level
        // publisher
        // month_year
        // mode
        // isbn_issn
        // author
        // aff_inst
        // ugc_app
        // peer_review
        // indexing
        // Doi_no
        // imp_factor
        // citation
        // h_index
        // i10_index
        // award
        // rel_link

        // dd($request->all());
        return $data;
    }

    public function getDepartment(Request $request)
    {

        $depart = Department::whereIn('faculty_id', $request->faculty_id)->get(['name', 'id']);
        // dd($depart);
        return  reply('true', [
            'depart' => $depart
        ]);
    }
}
