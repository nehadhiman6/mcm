<?php

use App\User;
use App\Staff;
use App\Course;
use App\Faculty;
use App\FeeBill;
use App\Student;
use App\Location;
use App\AlumniMeet;
use App\Concession;
use App\Permission;
use App\AlumniStudent;
use App\CourseSubject;
use App\Inventory\Item;
use App\SubjectSection;
use App\Inventory\Vendor;
use App\SubSectionDetail;
use App\Models\Block\Block;
use App\Models\Placement\Company;
use Illuminate\Support\Facades\DB;
use App\Models\Activity\AgencyType;
use App\Models\Activity\Orgnization;
use function GuzzleHttp\json_encode;
use Illuminate\Support\Facades\Gate;
use App\Models\Online\StudentFeedback;
use App\Models\Maintenance\FeedbackSection;
use App\Models\SubCombination\SubjectCombination;
use App\Models\SubCombination\SubjectCombinationDetail;

function checkActive($path, $active = 'active mm-active')
{
    if (is_string($path)) {
        return request()->is($path) ? $active : '';
    }
    foreach ($path as $str) {
        if (checkActive($str) == $active) {
            return $active;
        }
    }
}

function hasAccessToMenuOption($options)
{
    foreach ($options as $opt) {
        if (Gate::allows($opt)) {
            return true;
        }
    }
    return false;
}

function getPermissions()
{
    $user = Auth::user();
    if ($user->id == 1) {
        $permission = Permission::get();
    } else {
        $permission = $user->roles->first()->permissions()->get();
    }
    return $permission->pluck('name', 'name')->toArray();
    $permissions = [];
    foreach (Permission::all() as $permission) {
        if ($permission->admin == "Y") {
            $permissions[$permission->name] = true;
        }
    }
    return $permissions;
}

function checked($name, $value, $checked = 'checked')
{
    if (app('form')->getValueAttribute($name) == $value) {
        return $checked;
    }

    return '';
}

function deny($redirect = '', $msg = "You don't have access to this resource!!")
{
    if (request()->ajax()) {
        return reply("Error", [
            'error_msg' => $msg
        ], 422);
    }

    flash()->warning($msg);
    if (strlen($redirect) > 0) {
        return redirect($redirect);
    }
    //  abort(403);
    return redirect('/');
}

function getDrCrString($amount)
{
    if ($amount >= 0) {
        return abs($amount) . ' Cr';
    } else {
        return abs($amount) . ' Dr';
    }
}

function monthsList($json = false)
{
    $date = Carbon\Carbon::parse("01 December, 2001");
    $months = [];
    for ($i = 1; $i < 13; $i++) {
        $months[$i] = $date->addMonth(1)->format("F");
    }
    return $json ? json_encode($months) : $months;
}

function today()
{
    return Carbon\Carbon::today()->format('d-m-Y');
}

function startDate()
{
    return '01-07-2017';
}

function yesterday()
{
    return Carbon\Carbon::yesterday()->format('d-m-Y');
}

function tomorrow()
{
    return Carbon\Carbon::tomorrow()->format('d-m-Y');
}

function getDateObj($date, $format)
{
    if ($format == "dmy") {
        return Carbon\Carbon::createFromFormat('d-m-Y', $date);
    } else {
        return Carbon\Carbon::createFromFormat('Y-m-d', $date);
    }
}


function getDateDiff($dt1, $dt2)
{
    $dt1 =  Carbon\Carbon::createFromFormat('d-m-Y', $dt1);
    $dt2 =  Carbon\Carbon::createFromFormat('d-m-Y', $dt2);
    $diff = $dt2->diffInDays($dt1, false);
    return $diff;
}

function getDateAdd($dt1, $period, $interval = 'D')
{
    $dt1 =  Carbon\Carbon::createFromFormat('d-m-Y', $dt1);
    if (strtoupper($interval) == 'D') {
        $dt1->addDays($period);
    } elseif (strtoupper($interval) == 'M') {
        $dt1->addMonths($period);
    } else {
        $dt1->addYears($period);
    }
    return $dt1->format('d-m-Y');
}

function getDateSub($date, $dmy, $monthname = 'N')
{
    $dt = getDateObj($date, 'dmy');
    if (strtoupper($dmy) == 'D') {
        return $dt->day;
    } elseif (strtoupper($dmy) == 'M') {
        if (strtoupper($monthname) == 'Y') {
            return $dt->format('F');
        } else {
            return $dt->month;
        }
    } elseif (strtoupper($dmy) == 'W') {
        return $dt->dayOfWeek;     //0 for sunday & 6 for saturday
    } else {
        return $dt->year;
    }
}

function getMonthDate($month, $year, $start_end = "S")
{
    $dt = "01 $month, $year";
    $date = Carbon\Carbon::createFromFormat('d F, Y', $dt)->setTime(0, 0, 0);
    if ($start_end == "E") {
        $date = $date->addMonth()->addDays(-1);
    }
    return $date->format('d-m-Y');
}

// Checks Ist Date is (G)reater/(S)mall or (E)qual to Other Date
function getDateComp($dt1, $dt2)
{
    if (strpos($dt1, '-') < 3) {
        $dt1 =  Carbon\Carbon::createFromFormat('d-m-Y', $dt1);
    } else {
        $dt1 =  Carbon\Carbon::createFromFormat('Y-m-d', $dt1);
    }
    if (strpos($dt2, '-') < 3) {
        $dt2 =  Carbon\Carbon::createFromFormat('d-m-Y', $dt2);
    } else {
        $dt2 =  Carbon\Carbon::createFromFormat('Y-m-d', $dt2);
    }
    $days = $dt1->diffInDays($dt2, false);
    if ($days == 0) {
        return "E";
    } elseif ($days > 0) {
        return "S";
    } else {
        return "G";
    }
}

function getWMYDates($type, $date, $monthStart = 1)
{
    $dt1 = getDateObj($date, 'dmy');
    if (strtoupper($type) == 'W') {
        if ($dt1->dayOfWeek == 0) {
            $dt1->addDays(-6);
        } else {
            $dt1->addDays(1 - $dt1->dayOfWeek);
        }
        $dts = $dt1->format('d-m-Y');
        $dt1->addDays(6);
        $dte = $dt1->format('d-m-Y');
    } elseif (strtoupper($type) == 'M') {
        $dt1->firstOfMonth();
        $dts = $dt1->format('d-m-Y');
        $dt1->lastOfMonth();
        $dte = $dt1->format('d-m-Y');
    } elseif (strtoupper($type) == 'Y') {
        $dt1->firstOfYear();
        $dt1->addMonths($monthStart - 1);
        $dts = $dt1->format('d-m-Y');
        $dt1->lastOfYear();
        $dt1->addMonths($monthStart - 1);
        $dte = $dt1->format('d-m-Y');
    }
    return [$dts, $dte];
}


function daybeforeyesterday()
{
    return Carbon\Carbon::now()->subDays(2)->format('d-m-Y');
}

function getTimeAttribute($time)
{
    if ($time && $time != '0000-00-00' && $time != 'null') {
        if (is_object($time)) {
            if (get_class($time) == 'Carbon\Carbon') {
                return $time->parse($time)->format('H:i');
            } else {
                return $time;
            }
        }
        return Carbon\Carbon::parse($time)->format('H:i');
    }
    return '';
}

function setDateAttribute($date)
{
    if (strlen($date) > 0) {
        return Carbon\Carbon::createFromFormat('d-m-Y', $date);
    }
    return 'null';
}

function getDateAttribute($date)
{
    if ($date && $date != '0000-00-00' && $date != null) {
        return Carbon\Carbon::parse($date)->format('d-m-Y');
    }
    return '';
}



function xmltoarray($data)
{
    $parser = xml_parser_create('');
    xml_parser_set_option($parser, XML_OPTION_TARGET_ENCODING, "UTF-8");
    xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0);
    xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1);
    xml_parse_into_struct($parser, trim($data), $xml_values);
    xml_parser_free($parser);

    //  $returnArray = array();
    //  $returnArray['url'] = $xml_values[3]['value'];
    //  $returnArray['tempTxnId'] = $xml_values[5]['value'];
    //  $returnArray['token'] = $xml_values[6]['value'];

    return $xml_values;
}

function next_admno()
{
    return nextno("adm_no");
}

function next_outsider_no()
{
    return nextno("outsider_no");
}

function next_cardno()
{
    return nextno("card_no", true);
}

function nextno($idname, $yearly_db = false)
{
    $no = $yearly_db ? App\NoGeneratorYearlyDb::firstOrCreate(['idname' => $idname, 'prefix' => '']) : App\NoGenerator::firstOrCreate(['idname' => $idname, 'prefix' => '']);
    $no->increment('no', 1);
    return $no->no;
}

function nextRollno($course_id)
{
    $idname = "courseid_" . $course_id;
    $course = \App\Course::findOrfail($course_id);
    if (intval($course->st_rollno) < 1) {
        abort('423', 'Roll no series is not defined for this class');
    }
    $no = App\NoGeneratorYearlyDb::firstOrCreate(['idname' => $idname], ['idname' => $idname, 'prefix' => '', 'no' => 0]);
    //  var_dump($no);
    //  if($no->no > 0 && ($no->no < $course->st_rollno || $no->no > $course->end_rollno)) {
    //    $no->no = $course->st_rollno - 1;
    //  }
    if ($no->no >= $course->end_rollno) {
        abort(423, 'Roll no series is exhausted for this class');
    }
    if ($no->no > 0 && ($no->no > $course->st_rollno && $no->no < $course->end_rollno)) {
        do {
            $no->increment('no', 1);
        } while (\App\Student::whereRollNo($no->no)->exists());
    } else {
        $no->no = $course->st_rollno;
        $no->save();
    }
    //  dd($no->no);
    return $no->no;
}

//function next_rollno() {
//  return nextRollno("roll_no", false);
//}

function getVueData()
{
    if (config('college.app_location') == 'local') {
        echo '<pre>{{ $data | json }}</pre>';
    }
}

function getDateFormat($date, $formatreq)
{
    if ($formatreq == "ymd") {
        if (strlen($date) > 0) {
            return \Carbon\Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            return null;
        }
    } else {
        if (strlen($date) > 0) {
            return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        } else {
            return null;
        }
    }
}

function mysqlDate($dt)
{
    return Carbon\Carbon::createFromFormat('d-m-Y', $dt)->format('Y-m-d');
}

function getBoardlist($json = false)
{
    $boards = \App\BoardUniv::orderBy('name');
    if ($json) {
        //    return json_encode($boards->get(['id', 'name'])->push(['id' => '0', 'name' => 'Select'])->push(['id' => '-1', 'name' => 'Others']));
        return json_encode($boards->orderBy('name', 'desc')->get(['id', 'name']));
    } else {
        return ['0' => 'Select Board/Univ.'] + $boards->pluck('name', 'id')->toArray();
    }
}

function getCategory($type = "with")
{
    $catlist = \App\Category::orderBy('s_no')->pluck('name', 'id')->toArray();
    if ($type == 'without') {
        return $catlist;
    }
    return ['' => 'Select Category'] + $catlist;
}

function getResCategory()
{
    $rescatlist = \App\ResCategory::orderBy('name')->pluck('name', 'id')->toArray();
    return ['' => 'Select Resv. Category'] + $rescatlist;
}

function getCollFromArray($model, $arr)
{
}

function GetFirstKey($arr)
{
    if (count($arr) == 0) {
        return array($arr, 0);
    } else {
        reset($arr);
        $id = key($arr);
        unset($arr[$id]);
        return array($arr, $id);
    }
}

function reply($msg, $data = [], $status_code = 200, $headers = [])
{
    $data += ['app-status' => 'success'];
    return response()
        ->json(['success' => $msg] + $data, $status_code, $headers);
}

function getFY($prvYr = false)
{
    if ($prvYr) {
        $fy = session()->get('fy', '20232024');
        if ($fy != '') {
            $fy = (intval(substr($fy, -4)) - 2) . substr($fy, 0, 4);
        }
        return $fy;
    } else {
        return session()->get('fy', '20232024');
    }
}

function get_fy_label()
{
    $fy = getFY();
    if ($fy != '') {
        $fy = substr($fy, 0, 4) . '-' . substr($fy, 4, 4);
    }
    return $fy;
}

function getFYStartDate()
{
    return '01-04-' . substr(getFY(), 0, 4);
}

function getFYEndDate()
{
    $dt1 = '31-03-' . substr(getFY(), -4);
    if (getDateComp($dt1, getToday()) == 'G') {
        return getToday();
    } else {
        return $dt1;
    }
}

function getDefaultConn()
{
    return 'mysql';
}

function getYearlyDbConn($set = false, $prvYr = false)
{
    $db = config('database.connections.mysql');
    $db['database'] = config('database.data_name') . getFY($prvYr);
    config(['database.connections.yearly_db' => $db]);
    return 'yearly_db';
}

function getPrvYearDbConn($set = false)
{
    $db = config('database.connections.mysql');
    $db['database'] = config('database.data_name') . getFY(true);
    config(['database.connections.prv_year_db' => $db]);
    return 'prv_year_db';
}

function getYearlyDb()
{
    $conn = getYearlyDbConn();
    return config("database.connections.$conn.database");
}

function getSharedDb()
{
    return config('database.data_name') . "shared.";
    return '';
}

function getPrvYearDb()
{
    $conn = getPrvYearDbConn();
    return config("database.connections.$conn.database");
    return '';
}

function getFunds()
{
    $funds = \App\Fund::orderBy('name')->pluck('name', 'id')->toArray();
    return ['0' => 'Select'] + $funds;
}

function getGroup()
{
    $group = \App\SubFeeHead::pluck('group', 'group')->toArray();
    return ['' => ''] + $group;
    return ['0' => 'Select'] + $group;
}

function getStudentType()
{
    $stdtype = \App\StudentType::pluck('name', 'id')->toArray();
    return ['0' => 'Select'] + $stdtype;
}

function getInstallment($head_type = '', $json = false)
{
    $insts = \App\Installment::orderBy('name');
    if (strlen($head_type) > 0) {
        $insts = $insts->whereHeadType($head_type);
    }
    if (!$json) {
        $insts = ['0' => 'Select'] + $insts->pluck('name', 'id')->toArray();
    } else {
        $insts = $insts->get(['id', 'name', 'head_type']);
    }
    return $insts;
}

function getConcession()
{
    $cons = \App\Concession::pluck('name', 'id')->toArray();
    return ['0' => 'Select'] + $cons;
}

function getFeeHead($json = false)
{
    $head = \App\FeeHead::orderBy('name');
    if (!$json) {
        return ['0' => 'Select'] + $head->pluck('name', 'id')->toArray();
    } else {
        return $head->get(['id', 'name', 'fund']);
    }
}

function getSubHeadsJson()
{
    $head = \App\SubFeeHead::orderBy('name');
    return $head->with(['feehead'])->get(['id', 'name', 'feehead_id']);
}

function getSubjects()
{
    $subject = \App\Subject::orderBy('subject')->pluck('subject', 'id')->toArray();
    return $subject;
}
function getCourseSubjects($course_id, $all = false)
{
    $course_subject = \App\CourseSubject::whereCourseId($course_id);
    if ($all == false) {
        $course_subject = $course_subject->where('sub_type', '=', 'O');
    }
    $course_subject = $course_subject->with('subject')->get();
    return $course_subject->pluck('subject.subject', 'id')->toArray();
}

function getCourses($forFirstTime = false)
{
    $courses = Course::orderBy('sno');
    if ($forFirstTime) {
        $courses = $courses->where(function ($q) {
            $q->where('status', '=', 'GRAD');
            // ->where('course_year', '=', 1);
        })
            ->orWhere(function ($q) {
                $q->where('status', '=', 'PGRAD');
                // ->where('course_year', '=', 1);
            });
    }
    return [0 => 'Select'] + $courses->pluck('course_name', 'id')->toArray();
}

function getFinalYearCourses()
{
    $courses = Course::orderBy('sno');
    $courses = $courses->where(function ($q) {
        $q->where('status', '=', 'GRAD')
            ->where('course_year', '=', 3);
    })
        ->orWhere(function ($q) {
            $q->where('status', '=', 'PGRAD')
                ->where('course_year', '=', 2)
                ->orWhere('course_name', '=', 'PGDMC')
                ->orWhere('course_name', '=', 'PGDCA');
        });
    return $courses->get();
    //  return $courses->get();
}

function getTeacherCourses()
{
    $courses = Course::orderBy('sno');
    // return auth()->user()
    if (auth()->user()->hasRole('TEACHERS') && Gate::denies('see-courses-subjects')) {
        $teacher_id = Staff::where('user_id', auth()->user()->id)->first()->id;
        $sub_subjects = SubjectSection::where('teacher_id', $teacher_id)->with('course')->get()->pluck('course');
        $sub_subjects_det = SubSectionDetail::where('teacher_id', $teacher_id)->with('sub_section.course')->get()->pluck('sub_section.course');
        $courses = ($sub_subjects->merge($sub_subjects_det));
        $courses = $courses->pluck('course_name', 'id');
        return [0 => 'Select'] + $courses->toArray();
    } else {
        $courses = $courses->where(function ($q) {
            $q->where('status', '=', 'GRAD');
        })
            ->orWhere(function ($q) {
                $q->where('status', '=', 'PGRAD');
            });
        return [0 => 'Select'] + $courses->pluck('course_name', 'id')->toArray();
    }
}
function getCoursesForAdmForm($forFirstTime = false)
{
    $courses = Course::orderBy('sno');
    if ($forFirstTime) {
        $courses = $courses->where('course_year', '=', 1);
    }
    return $courses->get(['id', 'course_name', 'status', 'course_id', 'course_year', 'min_optional', 'honours_link'])->toJson();
}

function getSubheads($fund = 'A')
{
    if ($fund == 'A') {
        $subheads = ['' => 'Select'] + \App\SubFeeHead::orderBy('name')->pluck('name', 'id')->toArray();
    } else {
        $subheads = ['' => 'Select'] + \App\SubFeeHead::orderBy('name')
            ->join('fee_heads', 'fee_heads.id', '=', 'sub_heads.feehead_id')
            ->where('fee_heads.fund', '=', $fund)
            ->pluck('sub_heads.name', 'sub_heads.id')->toArray();
    }
    return $subheads;
}

function getUser()
{
    $users = \App\User::orderBy('name')->pluck('name', 'id')->toArray();
    return ['0' => 'Select'] + $users;
}

function getAddedString($string, $addstr, $gap = ",")
{
    if (strlen($string) > 0) {
        return $string . $gap . $addstr;
    } else {
        return $addstr;
    }
}

function figToWord($number)
{
    $array = array('01' => 'One', '02' => 'Two', '03' => 'Three', '04' => 'Four', '05' => 'Five', '06' => 'Six', '07' => 'Seven', '08' => 'Eight', '09' => 'Nine', '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen', '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty', '40' => 'Fourty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy', '80' => 'Eighty', '90' => 'Ninety', '00' => '');
    $fig1 = getNumToString($number, 13, 2);
    $count = 13 - strlen(trim($fig1));
    $word2 = "";
    while ($count <= 11) {
        if ($count == '1' || $count == '3' || $count == '5' || $count == '8' || $count == '11') {
            $fig2 = trim(substr($fig1, $count - 1, 2));
            if (isset($array[$fig2]) && $array[$fig2] != '') {
                $word1 = trim($array[$fig2]);
            } else {
                $fig2 = trim(substr($fig1, $count - 1, 1));
                $fig2 = $fig2 . "0";
                if ($fig2 == '00') {
                    $count = $count + 2;
                    continue;
                }
                $word1 = trim($array[$fig2]);
                $fig3 = trim(substr($fig1, ($count + 1 - 1), 1));
                $fig3 = '0' . $fig3;
                $word1 = trim($word1) . ' ' . trim($array[$fig3]);
            }
            $count = $count + 2;
        } else {
            $fig2 = trim(substr($fig1, $count - 1, 1));
            $fig2 = '0' . $fig2;
            $count = $count + 1;
            if (!isset($array[$fig2])) {
                $array[$fig2] = '';
            }
            $word1 = trim($array[$fig2]);
            if ($fig2 == '00') {
                continue;
            }
        }

        switch ($count) {
            case '3':
                $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Crore';
                break;
            case '5':
                $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Lac';
                break;
            case '7':
                $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Thousand';
                break;
            case '8':
                $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Hundred';
                break;
            case '10':
                $count = $count + 1;
                if (trim(substr($fig1, $count - 1, 2)) == '00') {
                    $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Only';
                    $count = $count + 1;
                } else {
                    $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'and';
                }
                break;
            case '13':
                $word2 = trim($word2) . ' ' . trim($word1) . ' ' . 'Paise Only';
                break;
        }
    }
    return $word2;
}

function getNumToString($varNumeric, $length, $decimal = 0)
{
    $varNumeric = number_format(round($varNumeric, $decimal), $decimal, '.', '');
    $varNumeric = str_pad($varNumeric, $length - strlen(settype($varNumeric, 'string')), ' ', STR_PAD_LEFT);
    return $varNumeric;
}

function docAttached($except = [])
{
    $doc = [
        ['name' => 'photograph', 'desc' => 'Photograph'],
        ['name' => 'signature', 'desc' => 'Signature'],
        ['name' => 'mark_sheet', 'desc' => 'Detailed Marks Sheet of all lower Examinations'],
        ['name' => 'dob_certificate', 'desc' => 'Matric/Secondary Certificate for Date Of Birth'],
        ['name' => 'char_certificate', 'desc' => 'Character Certificate From the Institution last attended(original)'],
        ['name' => 'migrate_certificate', 'desc' => 'Migration Certificate (original)'],
        ['name' => 'gap_certificate', 'desc' => 'Affidavit Justifying gap Year,if applicable'],
        ['name' => 'uid', 'desc' => 'Residence Proof/Adhaar Card/Voter Card/Passport etc'],
    ];
    if (count($except) > 0) {
        return array_where($doc, function ($d) use ($except) {
            return !in_array($d['name'], $except);
        });
    } else {
        return array_except($doc, $except);
    }
}

function resultType($json = false)
{
    $results = [
        '' => 'Select',
        'PASS' => 'PASS',
        'FAIL' => 'FAIL',
        'COMPARTMENT' => 'COMPARTMENT',
        'RESULT AWAITED' => 'RESULT AWAITED',
        'RL' => 'RL'
    ];
    if ($json) {
        return json_encode($results);
    } else {
        return $results;
    }
}

function getAcademicExam($json = false)
{
    if (getFY() < 20212022) {
        $exams = [
            '' => 'Select',
            '12th' => '10 + 2 Or Equivalent',
            '10th' => 'Class X',
            'sem_I' => 'B.A/B.Sc/B.Com/BBA/BCA Part I Semester -1',
            'sem_II' => 'B.A/B.Sc/B.Com/BBA/BCA Part I Semester-2',
            'sem_III' => 'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-3',
            'sem_IV' => 'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-4',
            'sem_V' => 'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-5',
            'sem_VI' => 'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-6',
            'honours' => 'B.A/B.Sc/B.Com(Honours)',
            'MComm' => 'M.Com/M.Com BE 1 Sem,2 Sem',
            'MA' => 'M.A/M.Sc 1 Sem,2 Sem',
            'O-Cet' => 'O-Cet Examination',
            'others' => 'Others'
        ];
    } else {
        $exams = [
            '' => 'Select',
            '12th' => '10 + 2 Or Equivalent',
            '10th' => 'Class X',
            'sem_I' => 'B.A/B.Sc/B.Com/BBA/BCA Part I Semester -1',
            'sem_II' => 'B.A/B.Sc/B.Com/BBA/BCA Part I Semester-2',
            'sem_III' => 'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-3',
            'sem_IV' => 'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-4',
            'sem_V' => 'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-5',
            'sem_VI' => 'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-6',
            'Honours' => 'B.A/B.Sc/B.Com(Honours)',
            'MCom' => 'M.Com/M.Com BE 1 Sem,2 Sem',
            'MA' => 'M.A/M.Sc 1 Sem,2 Sem',
            'OCet' => 'O-Cet Examination',
            'others' => 'Others'
        ];
    }
    if ($json) {
        return json_encode($exams);
    } else {
        return $exams;
    }
}

function getAcademicExamNo($exam)
{
    $exams = [
        'Class X' => 1,
        '10 + 2 Or Equivalent' => 2,
        'B.A/B.Sc/B.Com/BBA/BCA Part I Semester -1' => 3,
        'B.A/B.Sc/B.Com/BBA/BCA Part I Semester-2' => 4,
        'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-3' => 5,
        'B.A/B.Sc/B.Com/BBA/BCA Part II Semester-4' => 6,
        'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-5' => 7,
        'B.A/B.Sc/B.Com/BBA/BCA Part III Semester-6' => 8,
        'M.A/M.Sc 1 Sem,2 Sem' => 9,
        'M.Com/M.Com BE 1 Sem,2 Sem' => 10
    ];
    if(array_key_exists($exam,$exams)) {
        return $exams[$exam];
    }
    return 0;
}


function form_discrepancies($json = false)
{
    $form_discrepancies = [
        ['label' => 'Form Not Submitted', 'prop' => 'form_not_submitted', 'value' => 1]
    ];
    if ($json) {
        return json_encode($form_discrepancies);
    } else {
        return $form_discrepancies;
    }
}

function getUGPGExams()
{
    return  [
        [
            'grad' => 'ug', 'class' => '10', 'display' => '10th'
        ],
        [
            'grad' => 'ug', 'class' => '12', 'display' => '12th'
        ],
        [
            'grad' => 'ug', 'class' => 'ba', 'display' => 'B.A'
        ],
        [
            'grad' => 'ug', 'class' => 'bsc', 'display' => 'B.Sc'
        ],
        [
            'grad' => 'ug', 'class' => 'bcom', 'display' => 'B.Com'
        ],
        [
            'grad' => 'ug', 'class' => 'bca', 'display' => 'BCA'
        ],
        [
            'grad' => 'ug', 'class' => 'bba', 'display' => 'BBA'
        ],
        [
            'grad' => 'ug', 'class' => 'btec', 'display' => 'B.Tech'
        ],
        [
            'grad' => 'ug', 'class' => 'bed', 'display' => 'B.Ed'
        ],
        [
            'grad' => 'ug', 'class' => 'others', 'display' => 'Others'
        ],
        [
            'grad' => 'pg', 'class' => 'ma', 'display' => 'M.A'
        ],
        [
            'grad' => 'pg', 'class' => 'msc', 'display' => 'M.Sc'
        ],
        [
            'grad' => 'pg', 'class' => 'mcom', 'display' => 'M.Com'
        ],
        [
            'grad' => 'pg', 'class' => 'mca', 'display' => 'MCA'
        ],
        [
            'grad' => 'pg', 'class' => 'mba', 'display' => 'MBA'
        ],
        [
            'grad' => 'pg', 'class' => 'mtec', 'display' => 'M.Tech'
        ],
        [
            'grad' => 'pg', 'class' => 'med', 'display' => 'M.Ed'
        ],
        [
            'grad' => 'pg', 'class' => 'others', 'display' => 'Others'
        ],
        [
            'grad' => 'others', 'class' => 'mphil', 'display' => 'M.Phil'
        ],
        [
            'grad' => 'others', 'class' => 'phd', 'display' => 'Ph.D'
        ],
        [
            'grad' => 'others', 'class' => 'ugc-net', 'display' => 'UGC-NET'
        ],
        [
            'grad' => 'others', 'class' => 'jrf', 'display' => 'JRF'
        ],
        [
            'grad' => 'others', 'class' => 'slet', 'display' => 'SLET'
        ],
        [
            'grad' => 'others', 'class' => 'jpt', 'display' => 'JPT'
        ],
        [
            'grad' => 'others', 'class' => 'gate', 'display' => 'GATE'
        ],
        [
            'grad' => 'others',  'class' => 'others', 'display' => 'Others'
        ],
    ];
}

function getInstitutes($json = false)
{
    $exams = [
        '' => 'Select',
        1 => 'Pharmacy College',
        2 => 'School',
    ];
    if ($json) {
        return json_encode($exams);
    } else {
        return $exams;
    }
}

function examName($index)
{
    return getAcademicExam()[$index];
}

function getStates()
{
    $states = ['' => 'Select'] + \App\State::orderBy('state')->pluck('state', 'id')->toArray();
    return $states;
}

function getBloodGroup()
{
    $blood_grp = ['' => 'Select', 'NA' => 'NA', 'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-', 'AB+' => 'AB+', 'AB-' => 'AB-'];
    return $blood_grp;
}

function getAddOnCourses()
{
    $add_on_courses = ['0' => 'Select'] + \App\AddOnCourse::pluck('course_name', 'id')->toArray();
    return $add_on_courses;
}

function getAnnualIncome()
{
    $annual_income = ['0' => 'Select', 'Upto 250000' => 'Upto 250000', '250001-500000' => '250001-500000', '500001-800000' => '500001-800000', '800001-1000000' => '800001-1000000', 'Above 1000001' => 'Above 1000001'];
    // $annual_income = ['0' => 'Select', 'below 1 lac' => 'Below 1 Lac', '1 to 2 lac' => 'Between 1 Lac - 2 Lac ', '2 to 3 lac' => 'Between 2 Lac - 3 Lac', '3 to 4 lac' => 'Between 3 Lac - 4 Lac', '4 to 5 lac' => 'Between 4 Lac - 5 Lac', 'above 5 lacs' => 'Above 5 Lacs'];
    return $annual_income;
}
function getLastFeeBillID()
{
    return FeeBill::max('id');
}

function sendSms($msg, $mobile, $template_id = "")
{
    if (strlen($mobile) > 0) {
        $sms = new \App\Lib\Sms();
        // $sms = new \App\Lib\SmsKit();
        $r = $sms->send($msg, $mobile, $template_id);
        // logger($r);
    }
}
function getDepartments($json = false)
{
    $depart = App\Department::orderBy('name')->get(['name', 'id']);
    if ($json) {
        return $depart;
    }
    return $depart->pluck('name', 'id')->toArray();
}
function getDesignations($json = false)
{
    $desig = App\Designation::orderBy('name')->get(['name', 'id']);
    if ($json) {
        return $desig;
    }
    return $desig->pluck('name', 'id')->toArray();
}
function getSections($json = false)
{
    $sections = App\Section::orderBy('section')->get(['section', 'id']);
    if ($json) {
        return $sections;
    }
    return $sections->pluck('section', 'id')->toArray();
}
function getGender()
{
    return [
        'M' => 'Male', 'F' => 'Female', 'O' => 'Other'
    ];
}

function is_teacher()
{
    return auth()->user()->hasRole('TEACHERS');
}

function getStaffSource()
{
    return [
        'sanctioned/permanent-aided' => 'Sanctioned/Permanent-Aided',
        'non-sanctioned/permanent-unaided' => 'Non-sanctioned/Permanent-Unaided',
        'adhoc' => 'Contractual/Adhoc',
        'guest-faculty' => 'Guest Faculty',
        'out sourced' => 'Out sourced',
        // 'permanent-aided' => 'Permanent-Aided',
        // 'permanent-unaided' => 'Permanent-Unaided',
        'part-time' => 'Part Time'
    ];
}

function getStaffType()
{
    return [
        'Teacher' => 'Teaching', 'Other' => 'Non Teaching'
    ];
}

function getLocationTypes()
{
    return [
        'classroom' => 'Classroom',  'lab' => 'Lab', 'hostel' => 'Hostel', 'other' => 'Other'
    ];
}

function getTeachers($json = true)
{
    if ($json) {
        return Staff::where('type', '=', 'Teacher')->orderBy('name')->get()->load('dept');
    }
    return [0 => 'Select'] + \App\Staff::orderBy('name')->pluck('name', 'id')->toArray();
}


function getConcessions($json = true)
{
    $cons = Concession::orderBy('name');
    if ($json) {
        return $cons->get(['id', 'name']);
    } else {
        return $cons->pluck('name', 'id')->toArray();
    }
}

function getExams()
{
    return [
        'uni_1' => 'University First',
        'uni_2' => 'University Second',
        'coll_1' => 'College First',
        'coll_2' => 'College Second',
    ];
}


function getExaminations()
{
    return [
        'mst_1' => 'MST ODD',
        'mst_2' => 'MST EVEN',
        // 'pu_odd' => 'PU ODD',
        // 'pu_even' => 'PU EVEN',
        'ia_1' => 'IA ODD',
        'ia_2' => 'IA EVEN',
    ];
}

function getSemesters()
{
    return [
        1 => 'First',
        2 => 'Second',
    ];
}

// function added by neha dhiman for alumani Qualification
function graduateCourses($id = 0)
{
    $courses = [
        ['id' => 1, 'name' => 'Bachelor of Arts (BA)'],
        ['id' => 2, 'name' => 'Bachelor of Commerce (B.Com)'],
        ['id' => 3, 'name' => 'Bachelor of Computer Application (BCA)'],
        ['id' => 4, 'name' => 'Bachelor of Business Administration (BBA)'],
        ['id' => 5, 'name' => 'Microbial and Food Technology (MFT)'],
        ['id' => 6, 'name' => 'Bachelor of Science (B.Sc)-Medical'],
        ['id' => 7, 'name' => 'Bachelor of Science (B.Sc)-Non-Medical'],
        ['id' => 8, 'name' => 'Bachelor of Science (B.Sc)-Comp.Application'],
    ];

    if ($id == 0) {
        return json_encode($courses);
    }

    // return
    foreach ($courses as $course) {
        if ($course['id'] == $id) {
            return $course['name'];
        }
    }
}

function postGraduateCourses($id = 0)
{
    $courses = [
        ['id' => 1, 'name' => 'Master of Arts (MA)'],
        ['id' => 2, 'name' => 'Master of Science (M.Sc)'],
        ['id' => 3, 'name' => 'Master of Commerce (M.Com)'],
        ['id' => 4, 'name' => 'PGDMC'],
        ['id' => 5, 'name' => 'PGDCA'],
    ];

    if ($id == 0) {
        return json_encode($courses);
    }
    foreach ($courses as $course) {
        if ($course['id'] == $id) {
            return $course['name'];
        }
    }
}

function getAlumniCourse($course)
{
    if ($course->degree_type == 'PG') {
        switch ($course->course_id) {
            case 1:
                return "Master of Arts (MA)";
            case 2:
                return "Master of Science (M.Sc)";
            case 3:
                return "Master of Commerce (M.Com)";
            case 4:
                return "Bachelor of Computer Application (BCA)";
            case 5:
                return "Bachelor of Business Administration (BBA)";
            case 6:
                return "Microbial and Food Technology  (MFT)";
            default:
                "";
        }
    }
    if ($course->degree_type == 'UG') {
        switch ($course->course_id) {
            case 1:
                return "Bachelor of Arts (BA)";
            case 2:
                return "Bachelor of Science (B.Sc)";
            case 3:
                return "Master of Commerce (M.Com)";
            case 4:
                return "PGDCM";
            case 5:
                return "PGDCA";
            default:
                "";
        }
    }
}

function professionalCourses($id = 0)
{
    $courses = [
        ['id' => 1, 'name' => 'Chartered Accountant'],
        ['id' => 2, 'name' => 'Bachelor of Education (B.Ed)'],
        ['id' => 3, 'name' => 'Company Secretary'],
        ['id' => 4, 'name' => 'Bachelor of Law (LLB)'],
        ['id' => 5, 'name' => 'Master of Business Administration (MBA)'],
        ['id' => 6, 'name' => 'Nursery Teacher Training (NTT)'],
        ['id' => 7, 'name' => 'Master of Law and Business (LLM)'],
        ['id' => 8, 'name' => 'Fashion Designing'],

    ];

    if ($id == 0) {
        return json_encode($courses);
    }
    foreach ($courses as $course) {
        if ($course['id'] == $id) {
            return $course['name'];
        }
    }
}

function researchCourses($id = 0)
{
    $courses = [
        ['id' => 1, 'name' => 'Master of Philosophy (M.Phil)'],
        ['id' => 2, 'name' => 'Doctorate of Philosophy (Ph.d)'],
        ['id' => 3, 'name' => 'Post Doctorate'],
        // ['id'=> 4,'name'=>'Doctorate']
    ];

    if ($id == 0) {
        return json_encode($courses);
    }
    foreach ($courses as $course) {
        if ($course['id'] == $id) {
            return $course['name'];
        }
    }
}

function competitionexams($id = 0)
{
    $courses = [
        ['id' => 1, 'name' => 'Civil Service (UPSC)'],
        ['id' => 2, 'name' => 'Civil Service(SPSC)'],
        ['id' => 3, 'name' => 'Bank PO']
    ];

    if ($id == 0) {
        return json_encode($courses);
    }
    foreach ($courses as $course) {
        if ($course['id'] == $id) {
            return $course['name'];
        }
    }
}

function employmentTypes()
{
    $courses = [
        'self-employed' => 'Self Employed',
        'salaried' => 'Salaried',
        'charity' => 'Charity/NGO',

    ];

    return json_encode($courses);
}

function getPaperTypes()
{
    $papers = [
        'paper-a' => 'Paper A',
        'paper b' => 'Paper B',
        'paper-c' => 'Paper C',
        'practical' => 'Practical'

    ];

    return ['0' => 'Select'] + $papers;
}

function getAlumniMeet()
{
    return AlumniMeet::where('active', 'Y')->first();
    return AlumniMeet::whereDate('meet_date', '>', \Carbon\Carbon::now())->first();
}

function getEvents()
{
    $events = ['0' => 'Select'] + AlumniMeet::orderBy('meet_date', 'desc')->pluck('meet_date', 'id')->toArray();
    return $events;
}


function getParentCourses()
{
    $courses = ['0' => 'Select'] + \App\Course::orderBy('sno')->where('parent_course_id', 0)->pluck('course_name', 'id')->toArray();
    return $courses;
}


function getDonationReasons()
{
    return [
        'Scholership for Meritorial/Poor Student' => 'Scholership for Meritorial/Poor Student',
        'For Infrastructure' => 'For Infrastructure',
        'For Library' => 'For Library',
        'Others' => 'Others'
    ];
}

function getItemCategories()
{
    $value = ['' => 'Select'] + \App\Inventory\ItemCategory::orderBy('category')->pluck('category', 'id')->toArray();
    return $value;
}

function getItemSubCategories()
{
    $value = ['' => 'Select'] + \App\Inventory\ItemSubCategory::orderBy('category')->pluck('category', 'id')->toArray();
    return $value;
}

function getCities()
{
    $value = ['' => 'Select'] + \App\City::orderBy('city')->pluck('city', 'id')->toArray();
    return $value;
}

function getVendors()
{
    $value = ['' => 'Select'] + Vendor::orderBy('vendor_name')->pluck('vendor_name', 'id')->toArray();
    return $value;
}

function getitems($json = false)
{
    $value = Item::orderBy('item')->pluck('item', 'id')->toArray();
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getUnits($json = false)
{
    $value = [
        'KGs' => 'KGs',
        'PCs' => 'PCs',
        'Boxes' => 'Boxes',
        'Nos' => 'Nos',
        'Gm' => 'Gm',
        'Mg' => 'Mg',
        'Ltr' => 'Ltr',
        'Ml' => 'Ml',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getYesNo($json = false)
{
    $value = [
        'Y' => 'Yes',
        'N' => 'No',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getLocations($json = false)
{
    // $value = Location::orderBy('location')->pluck('location', 'id')->toArray();
    $value = Location::orderBy('location')->Where('is_store', 'N')->pluck('location', 'id')->toArray();
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getAlumniYears($json = false)
{
    $value = AlumniStudent::orderBy('passout_year')->pluck('passout_year', 'passout_year')->toArray();
    $result = array_unique($value);
    if ($json) {
        return json_encode($result);
    } else {
        return ['' => 'Select'] + $result;
    }
}

function getAllAlumniCourses()
{
    $value = AlumniStudent::orderBy('passout_year')->pluck('passout_year', 'passout_year')->toArray();
    $result = array_unique($value);
    return ['' => 'Select'] + $result;
}

function getCoursesType()
{
    $value = [
        'UG' => 'UG',
        'PG' => 'PG',
        'Professional' => 'Professional',
        'Research' => 'Research'
    ];
    return ['' => 'Select'] + $value;
}

function getStudentsByCourse($course_id)
{
    $value = Student::whereCourseId($course_id)->count();
    if ($value) {
        return $value;
    } else {
        return 0;
    }
}


function getSubjectType($course_id, $subject_id)
{
    $value = CourseSubject::whereCourseId($course_id)->whereSubjectId($subject_id)->first(['sub_type']);
    if ($value) {
        if ($value->sub_type == 'C') {
            return 'Compulsory';
        } else {
            return 'Optional';
        }
    } else {
        return '';
    }
}

function getFeedbackSections($json = false, $type)
{
    $value = FeedbackSection::orderBy('name');
    if ($type == 'zero') {
        $value = $value->whereUnderSectionId(0);
    }
    $value = $value->pluck('name', 'id')->toArray();
    if ($json) {
        return json_encode($value->load('feedback_questions'));
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getFeedbackWithoutParent($json = false)
{
    $value = FeedbackSection::orderBy('name')->get();

    if ($type == 'zero') {
        $value = $value->whereUnderSectionId(0);
    }
    $value = $value->pluck('name', 'id')->toArray();
    if ($json) {
        return json_encode($value->load('feedback_questions'));
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getAllFeedbackSections($json = false)
{
    $value = FeedbackSection::orderBy('name')->get();
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getRating($que_id, $std_id)
{
    $student_feedback = StudentFeedback::whereStdId($std_id)->whereQuestionId($que_id)->first();
    $rating = '';
    if ($student_feedback->rating == 1) {
        $rating = 'Poor';
    }
    if ($student_feedback->rating == 2) {
        $rating = 'Good';
    }
    if ($student_feedback->rating == 3) {
        $rating = 'Very Good';
    }
    if ($student_feedback->rating == 4) {
        $rating = 'Excellent';
    }

    return $rating;
}
// function getFeedbackRatingStatus($rating, $question_id, $std_id)
// {
//     $std_feedback = StudentFeedback::whereRating($rating)->whereQuestionId($question_id)->whereStdId($std_id)->first();
//     if ($std_feedback == null) {
//         return 'checked';
//     } else {
//         return 'true';
//     }
// }


function getFaculty($json = false)
{
    $value = Faculty::orderBy('faculty')->pluck('faculty', 'id')->toArray();
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getSalutation()
{
    $value = [
        'Mr.' => 'Mr.',
        'Mrs.' => 'Mrs.',
        'Miss.' => 'Miss.',
        'Dr.' => 'Dr.',
        'Prof.' => 'Prof.',

    ];
    return ['' => 'Select'] + $value;
}
function getAreaSpecilization()
{
    $value = [
        'M.Phill' => 'M.Phill',
        'PHD' => 'PHD',
        'Other' => 'Other',
    ];
    return $value;
}

function getSessions()
{
    $value = [
        'session_1' => 'Session I',
        'session_2' => 'Session II',
        'session_3' => 'Session III',
    ];
    return $value;
}


function getCenters()
{
    $value = [
        'center_1' => 'Center I',
        'center_2' => 'Center II',
        'center_3' => 'Center III',
        'center_4' => 'Center IV',
        'center_5' => 'Center V',
    ];
    return [0 => 'Select'] + $value;
}

function getSessionName($session_key)
{
    $sessions = getSessions();
    foreach ($sessions as  $key => $value) {
        if ($key == $session_key) {
            return $value;
        }
    }
}

function getCenterName($center_key)
{
    $centers = [
        'center_1' => 'Center I',
        'center_2' => 'Center II',
        'center_3' => 'Center III',
        'center_4' => 'Center IV',
        'center_5' => 'Center V',
    ];
    foreach ($centers as  $key => $value) {
        if ($key == $center_key) {
            return $value;
        }
    }
}

function getExamName($exam_key)
{
    $exams = getExaminations();
    foreach ($exams as  $key => $value) {
        if ($key == $exam_key) {
            return $value;
        }
    }
}

function getStaff($json = true)
{
    if ($json) {
        return Staff::orderBy('name')->get();
    }
    return [0 => 'Select'] + \App\Staff::orderBy('name')->pluck('name', 'id')->toArray();
}


function getForeignCategory()
{
    return \App\Category::whereName("FOREIGN NATIONAL")->value('id');
}


function getBlocks($json = false)
{
    $blocks = Block::orderBy('name')->pluck('name', 'id')->toArray();
    return ['0' => 'Select'] + $blocks;
}

function getPassingYears()
{
    $years = AlumniStudent::orderBy('passout_year')->distinct('passout_year')->pluck('passout_year')->toArray();
    // dd($years);
    return ['' => 'Select'] + $years;
}

function getLeftStatus()
{
    $value = [
        'retirement' => 'Retirement',
        'transfer' => 'Transfer',
        'death' => 'Death',
        'promoted' => 'Promoted',
        'new appointment' => 'New Appointment',
    ];
    return $value;
}

function getStoreLocations()
{
    if (auth()->user()->id != 1 && Gate::denies('all-store-loc-access')) {
        $locations =  Location::where("operated_by", auth()->user()->id)->pluck('location', 'id')->toArray();
    } else {
        $locations =  Location::where("operated_by", '>', 0)->pluck('location', 'id')->toArray();
    }
    return ['' => 'Select'] + $locations;
}

function getResultModel($ids, $modelToEff, $fillable)
{
    $id = array_splice($ids, 0, 1);
    if (count($id) > 0) {
        $id1 = $id[array_keys($id)[0]];
        $model = $modelToEff::findOrFail($id1);
    } else {
        $model = new $modelToEff();
    }
    $model->fill($fillable);
    return [$model, $ids];
}

function getUserStores()
{
    if (auth()->user()->id != 1 && Gate::denies('all-store-loc-access')) {
        return Location::where('operated_by', auth()->user()->id)->pluck('id')->toArray();
    }
    return Location::pluck('id')->toArray();
}

function getGrants($json = false)
{
    $value = [
        'stardbtgrant' => 'Star DBT Grant',
        'mainhead' => 'Main Head',
        'mschead' => 'Msc Head',
        'ugchead' => 'UGC Head',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getAgencyType($json = false)
{
    $agency = AgencyType::orderBy('name')->get(['name', 'id']);
    if ($json) {
        return $agency;
    }
    return $agency->pluck('name', 'id')->toArray();
}

function getOrgType($json = false)
{
    $org = Orgnization::orderBy('name')->get(['name', 'id']);
    if ($json) {
        return $org;
    }
    return $org->pluck('name', 'id')->toArray();
}

function getOrgBy($json = false)
{
    $org_by = AgencyType::orderBy('name')->where('master_type', '=', 'Organization')->get(['name', 'id']);
    if ($json) {
        return $org_by;
    }
    return $org_by->pluck('name', 'id')->toArray();
}

function getActivity($json = false)
{
    $act_by = AgencyType::orderBy('name')->where('master_type', '=', 'Activity')->get(['name', 'id']);
    if ($json) {
        return $act_by;
    }
    return $act_by->pluck('name', 'id')->toArray();
}

function getSponsor($json = false)
{
    $spon_by = AgencyType::orderBy('name')->where('master_type', '=', 'Sponsor')->get(['name', 'id']);
    if ($json) {
        return $spon_by;
    }
    return $spon_by->pluck('name', 'id')->toArray();
}

function getSemestersName($semester)
{
    switch ($semester) {
        case 1:
            return "First";
        case 2:
            return "Second";
        case 3:
            return "Third";
        case 4:
            return "Fourth";
        case 5:
            return "Fifth";
        case 6:
            return "Sixth";
        default:
            return "";
    }
}

function getNewItems($json = false)
{
    $item = Item::orderBy('item', 'asc')->get(['item', 'id'])->toArray();
    if ($item != '[]') {
        if ($json) {
            return json_encode($item);
        } else {
            return $item;
        }
    }
    return [];
}

function getRegional($json = false)
{
    $value = [
        'HOSHIARPUR' => 'HOSHIARPUR',
        'LUDHIANA' => 'LUDHIANA',
        'MOGA' => 'MOGA',
        'FEROZPUR' => 'FEROZPUR',
        'MUKTSAR' => 'MUKTSAR',
        'FAZILKA' => 'FAZILKA',
        'ABOHAR' => 'ABOHAR',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}


function getProvisionalCentre($json = false)
{
    $value = [
        'Gopi Chand Arya Mahila College, Abohar' => 'Gopi Chand Arya Mahila College, Abohar',
        'D.A.V. College, Abohar' => 'D.A.V. College, Abohar',
        'G.N. Khalsa College, Abohar' => 'G.N. Khalsa College, Abohar',
        'Bhag Singh Khalsa College for Women, Vill. Kala Tibba, Abohar' => 'Bhag Singh Khalsa College for Women, Vill. Kala Tibba, Abohar',
        'Satyam College for Girls , Sayadwala' => 'Satyam College for Girls , Sayadwala',
        'Syon College , Hanumangarh Road, Abohar' => 'Syon College , Hanumangarh Road, Abohar',
        'Waheguru College, Burj Muhar Road, Abohar' => 'Waheguru College, Burj Muhar Road, Abohar',
        'Bhai Nagahia Singh Memorial Girls College , Alamgir (Ldh)' => 'Bhai Nagahia Singh Memorial Girls College , Alamgir (Ldh)',
        'Gobindgarh Public College' => 'Gobindgarh Public College',
        'Jagat Sewak Khalsa College for Women Amargarh Parao Mehna(Moga)' => 'Jagat Sewak Khalsa College for Women Amargarh Parao Mehna(Moga)',
        'Dashmesh Girls College, Badal' => 'Dashmesh Girls College, Badal',
        'Baba Balraj Panjab University Constituent College Balachaur (SBS Nagar)' => 'Baba Balraj Panjab University Constituent College Balachaur (SBS Nagar)',
        'Saini Bar College, Bulhowal (HSP)' => 'Saini Bar College, Bulhowal (HSP)',
        'Siri Guru Har Rai Sahib College for Women. Chabbewal(Hsp.)' => 'Siri Guru Har Rai Sahib College for Women. Chabbewal(Hsp.)',
        'Sant Hari Singh Memo. Coll. for (W), Chella  Makhsuspur' => ' Sant Hari Singh Memo. Coll. for (W), Chella  Makhsuspur',
        'National Degree College ,  Chowarrianwali' => 'National Degree College ,  Chowarrianwali',
        'GTB National College Dakha (Ludhiana)' => 'GTB National College Dakha (Ludhiana)',
        'Shri Ram College, Dalla' => 'Shri Ram College, Dalla',
        'Guru Teg Bahadur Khalsa College  for Women Dasuya' => 'Guru Teg Bahadur Khalsa College  for Women Dasuya',
        'J.C.D.A.V. College, Dasuya' => 'J.C.D.A.V. College, Dasuya',
        'L.L.R. Govt. College, Dhudike' => 'L.L.R. Govt. College, Dhudike',
        'Arjan Dass College. Dharamkot (Moga)' => 'Arjan Dass College. Dharamkot (Moga)',
        'Panjab University Constituent College, Moga' => 'Panjab University Constituent College, Moga',
        'Guru Nanak National College, Doraha' => 'Guru Nanak National College, Doraha',
        'M.R. Govt. College, Fazilka' => 'M.R. Govt. College, Fazilka',
        'D.A.V. College for Women, Ferozepur Cantt' => 'D.A.V. College for Women, Ferozepur Cantt',
        'Guru Nanak College,, Ferozepur Cantt' => 'Guru Nanak College,, Ferozepur Cantt',
        'Dev Samaj College for Women, Ferozepur City' => 'Dev Samaj College for Women, Ferozepur City',
        'R.S.D. College, Ferozepur City' => 'R.S.D. College, Ferozepur City',
        'Panjab University Constituent College , Village Mohkam Khan Wala , District Ferozpur' => 'Panjab University Constituent College , Village Mohkam Khan Wala , District Ferozpur',
        'D.A.V. College for Girls. Garhshankar' => 'D.A.V. College for Girls. Garhshankar',
        'B.A.M. Khalsa College Garhshankar' => 'B.A.M. Khalsa College Garhshankar',
        'Panjab University Constituent College, Guru Har Sahai (Fzr.)' => 'Panjab University Constituent College, Guru Har Sahai (Fzr.)',
        'H.K.L. College of education , Godhar Dhandi Road, Guru har sahai' => 'H.K.L. College of education , Godhar Dhandi Road, Guru har sahai',
        'M.M.D.D.A.V. College. Gidderbaha' => 'M.M.D.D.A.V. College. Gidderbaha',
        'G.G.S.  Degree College for Women Gidderbaha' => 'G.G.S.  Degree College for Women Gidderbaha',
        'Khalsa College Garhdiwala' => 'Khalsa College Garhdiwala',
        'G.H.G. Khalsa College,   Gurusar Sudhar' => 'G.H.G. Khalsa College,   Gurusar Sudhar',
        'G.G.D.S.D. College, Hariana (Hsp.)'  => 'G.G.D.S.D. College, Hariana (Hsp.)',
        'Shree Atam Vallabh Jain College , Hussainpura (Ldh)' => 'Shree Atam Vallabh Jain College , Hussainpura (Ldh)',
        'Govt. College, Hoshiarpur' => 'Govt. College, Hoshiarpur',
        'D.A.V. College, Hoshiarpur' => 'D.A.V. College, Hoshiarpur',
        'S.D. College, Hoshiarpur' => 'S.D. College, Hoshiarpur',
        'S. Govt. College of Science Education& Research. Jagraon' => 'S. Govt. College of Science Education& Research. Jagraon',
        'L.R.D.A.V. College, Jagraon' => 'L.R.D.A.V. College, Jagraon',
        'G.G.S. D.A.V. College, Jalalabad' => 'G.G.S. D.A.V. College, Jalalabad',
        'G.G.S.Khalsa College for Women. Jhar Sahib' => 'G.G.S.Khalsa College for Women. Jhar Sahib',
        'G.G.S. Khalsa College for Women, Kamalpura (Ldh.)' => 'G.G.S. Khalsa College for Women, Kamalpura (Ldh.)',
        'Public Khalsa College for Women. Kandhala Jattan' => 'Public Khalsa College for Women. Kandhala Jattan',
        'Govt. College. Karamsar' => 'Govt. College. Karamsar',
        'Panjab University Rural Centre, Sri Muktsar Sahib, Kauni (Mkt.)' => 'Panjab University Rural Centre, Sri Muktsar Sahib, Kauni (Mkt.)',
        'A.S. College for Women, Khanna' => 'A.S. College for Women, Khanna',
        'A.S. College, Khanna' => 'A.S. College, Khanna',
        'Guru Nanak College, Killianwali  (Mkt.)' => 'Guru Nanak College, Killianwali  (Mkt.)',
        'M.G.K. College for Girls, Kottan' => 'M.G.K. College for Girls, Kottan',
        'Govt. College for Girls, Ludhiana' => 'Govt. College for Girls, Ludhiana',
        'Khalsa College for Women, Civil Lines, Ludhiana' => 'Khalsa College for Women, Civil Lines, Ludhiana',
        'S.D.P. College for Women, Ludhiana' => 'S.D.P. College for Women, Ludhiana',
        'M.T.S. Memo. College for Women, Ludhiana' => 'M.T.S. Memo. College for Women, Ludhiana',
        'Guru Nanak Khalsa College for Women, Model Town, Ludhiana' => 'Guru Nanak Khalsa College for Women, Model Town, Ludhiana',
        'Ramgarhia Girls College, Millerganj, Ludhiana' => 'Ramgarhia Girls College, Millerganj, Ludhiana',
        'D.D. Jain Memorial College for Women, Ludhiana' => 'D.D. Jain Memorial College for Women, Ludhiana',
        'Guru Nanak Girls College, Model Town, Ludhiana' => 'Guru Nanak Girls College, Model Town, Ludhiana',
        'Arya College,(Girls Section), Ludhiana' => 'Arya College,(Girls Section), Ludhiana',
        'S.C.D. Govt. College, Ludhiana' => 'S.C.D. Govt. College, Ludhiana',
        'G.G.N. Khalsa College, Civil Lines, Ludhiana'  => 'G.G.N. Khalsa College, Civil Lines, Ludhiana',
        'Kamla Lohtia S.D. College, Ludhiana' => 'Kamla Lohtia S.D. College, Ludhiana',
        'Bajaj College, Vill. Gurah Chauki Mann, Ferozepur Road, Ludhiana' => 'Bajaj College, Vill. Gurah Chauki Mann, Ferozepur Road, Ludhiana',
        'S.D.S. College for Women. Lopon' => 'S.D.S. College for Women. Lopon',
        'National College for Women. Machhiwara' => 'National College for Women. Machhiwara',
        'S.G.G.S. Khalsa College, Mahilpur (Hsp.)' => 'S.G.G.S. Khalsa College, Mahilpur (Hsp.)',
        'D.A.V. College, Malout Mandi' => 'D.A.V. College, Malout Mandi',
        'Maharaja Ranjit Singh College. Malout Mandi' => 'Maharaja Ranjit Singh College. Malout Mandi',
        'M.B.B.G.R.C. Girls College, Mansowal [Hsp ]' => 'M.B.B.G.R.C. Girls College, Mansowal [Hsp ]',
        'Sant Majha Singh Karamjot Coll. for Women, Miani [ Hsp ]' => 'Sant Majha Singh Karamjot Coll. for Women, Miani [ Hsp ]',
        'Guru Nanak College for Girls, Muktsar' => 'Guru Nanak College for Girls, Muktsar',
        'Dashmesh Khalsa College, Muktsar' => 'Dashmesh Khalsa College, Muktsar',
        'Govt. College, Muktsar' => 'Govt. College, Muktsar',
        'P.U. Regional Centre, Muktsar' => 'P.U. Regional Centre, Muktsar',
        'Govt. College, Muktsar' => 'Govt. College, Muktsar',
        'S.D. College for Women, Moga' => 'S.D. College for Women, Moga',
        'D.M. College, Moga' => ' D.M. College, Moga',
        'Guru Nanak College, Moga' => 'Guru Nanak College, Moga',
        'C.G.M.  College, Mohlan' => 'C.G.M.  College, Mohlan',
        'Shaheed Ganj College for Women, Mudki' => 'Shaheed Ganj College for Women, Mudki',
        'Baba Kundan Singh Co-Education College, Muhar' => 'Baba Kundan Singh Co-Education College, Muhar',
        'Swami Premanand Mahavidyalaya,Mukerian' => 'Swami Premanand Mahavidyalaya,Mukerian',
        'Dashmesh Girls College, Chak Alla Baksh, Mukerian' => 'Dashmesh Girls College, Chak Alla Baksh, Mukerian',
        'Govind National College, Govind Nagar, Narangwal' => 'Govind National College, Govind Nagar, Narangwal',
        'Panjab University Constituent College, Nihal Singh Wala(Moga)' => 'Panjab University Constituent College, Nihal Singh Wala(Moga)',
        'M.B.G. Govt. College, Pojewal' => 'M.B.G. Govt. College, Pojewal',
        'Mai Bhago College for Women., Ramgarh' => 'Mai Bhago College for Women., Ramgarh',
        'M.B.B.G.G.G. Girls College. Rattewal (Hsp)' => 'M.B.B.G.G.G. Girls College. Rattewal (Hsp)',
        'Swami Ganga Giri Janta Girls College, Raikot' => 'Swami Ganga Giri Janta Girls College, Raikot',
        'Sri Aurbindo College of Commerce, P.O. Thirk, Ldh-FZR Rd, V.Jhande (Ldh)' => 'Sri Aurbindo College of Commerce, P.O. Thirk, Ldh-FZR Rd, V.Jhande (Ldh)',
        'Malwa College (Bondli) Samrala' => 'Malwa College (Bondli) Samrala',
        'Khalsa College for Women, Sidhwan Khurd' => 'Khalsa College for Women, Sidhwan Khurd',
        'Guru Nanak Khalsa College for Women' => 'Guru Nanak Khalsa College for Women',
        'B.S.S.G. Govt. College, (P.O. Nizampur), Sidhsar(Ldh.)' => 'B.S.S.G. Govt. College, (P.O. Nizampur), Sidhsar(Ldh.)',
        'Panjab University Constituent College, Sikhwala (Sri Muktsar Sahib)' => 'Panjab University Constituent College, Sikhwala (Sri Muktsar Sahib)',
        'S.B.B.S. Memo. Girls College Sukhanand (Moga)' => 'S.B.B.S. Memo. Girls College Sukhanand (Moga)',
        'Govt. Arts & Science College, Talwara' => 'Govt. Arts & Science College, Talwara',
        'G.K.S.M. Govt. College, Tanda Urmar' => 'G.K.S.M. Govt. College, Tanda Urmar',
        'M.L.D.B.N.B.G.D. Girls College, Tapperian Khurd (HSP)' => 'M.L.D.B.N.B.G.D. Girls College, Tapperian Khurd (HSP)',
        'Mata Sahib Kaur Girls College Talwandi Bhai (FZR)' => 'Mata Sahib Kaur Girls College Talwandi Bhai (FZR)',
        'Govt. College Zira' => 'Govt. College Zira',

    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}


function getYearCourse($json = false)
{
    $course = Course::where('course_year', '=', '1')->where('id', '=', '14')->orWhere('id', '=', '19')->orWhere('id', '=', '20')->orWhere('id', '=', '22')->orWhere('id', '=', '23')->orWhere('id', '=', '25')->orWhere('id', '=', '26')->orWhere('id', '=', '29')->get(['class_code', 'id']);
    if ($json) {
        return $course;
    }
    return ['' => 'Select'] + $course->pluck('class_code', 'id')->toArray();
}


function getNewStaff($json = false)
{
    if ($json) {
        return Staff::where('source', '=', 'non-sanctioned/permanent-unaided')->orWhere('source', '=', 'sanctioned/permanent-aided')->orWhere('source', '=', 'adhoc')->orderBy('name')->get()->load('dept');
    }
    return [0 => 'Select'] + \App\Staff::orderBy('name')->pluck('name', 'id')->toArray();
}

function getResearchType($json = false)
{
    $value = [
        'Journal' => 'Journal',
        'Book' => 'Book',
        'Book Chapter' => 'Book Chapter',
        'Conference' => 'Conference',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function getPayScale($json = false)
{
    $value = [
        '15600to39100 + AGP 6000' => '15600to39100 + AGP 6000',
        '15600to39100 + AGP 7000' => '15600to39100 + AGP 7000',
        '15600to39100 + AGP 8000' => '15600to39100 + AGP 8000',
        '15600to39100 + AGP 9000' => '15600to39100 + AGP 9000',
        '37400to60000 + AGP 10000' => '37400to60000 + AGP 10000',
    ];
    if ($json) {
        return json_encode($value);
    } else {
        return ['' => 'Select'] + $value;
    }
}

function setAmountAttribute($amount)
{
    if (strlen($amount) > 0) {
        return $amount;
    }
    return 0;
}


function getActGroup($json = false)
{
    $act_grp_by = AgencyType::orderBy('name')->where('master_type', '=', 'Activity Group')->get(['name', 'id']);
    if ($json) {
        return $act_grp_by;
    }
    return $act_grp_by->pluck('name', 'id')->toArray();
}

function getAddResCategory($json = false)
{
    $val = App\ResCategory::orderBy('name')->get(['name', 'id']);
    if ($json) {
        return $val;
    }
    return $val->pluck('name', 'id')->toArray();
}

function getCompanies()
{
    $comp = ['' => 'Select'] + Company::orderBy('name')->pluck('name', 'id')->toArray();
    return $comp;
}


function getYearlyDbConnFromDb($database)
{
    $db = config('database.data_name').$database;
    return $db;
}

function getSubjectCombination($course_id)
{

    $sub = SubjectCombinationDetail::join('sub_combination','sub_combination_dets.sub_combination_id','=','sub_combination.id')
                                    ->join(getSharedDb().'subjects','subjects.id','=','sub_combination_dets.subject_id')
                                    ->where('sub_combination.course_id','=',$course_id)
                                    ->select('sub_combination.id','sub_combination.combination','sub_combination.code',
                                    DB::raw("group_concat(subjects.subject) as subject") )->groupBy('sub_combination.id','sub_combination.combination')->get()->toArray();
    return $sub ;
    
}