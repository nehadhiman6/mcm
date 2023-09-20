@extends('app')

@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop
@section('content')
<div class="box box-default box-solid " id='filter'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
        {!! Form::open(['method' => 'GET',  'action' => ['Examination\PuExamReportController@index'], 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('exam','Exam:',['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-2">
                        <select class="form-control select-form" v-model="exam" :disabled='showField'>
                            <option value="pu_odd">PU ODD</option>
                            <option value="pu_even">PU EVEN</option>
                        </select>
                        <span id="basic-msg" v-if="errors['exam']" class="help-block">@{{ errors['exam'][0] }}</span>
                    </div>
                    {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
                    <div class="col-sm-4">
                        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id',':disabled'=>'showRoll']) !!}
                    </div>
                </div>
        </div>
        <div class="box-footer">
            {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData()']) !!}
            {!! Form::close() !!}
        </div>
</div>

<div class="box">
  <div class="box-header with-border">
        <h3 class="box-title">PU Exam Report</h3>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
        <div class="table-responsive iw-table">
            <table id="pu_exam" class="table table-bordered " width="100%">
            </table>
        </div>
  </div>

</div>
@stop
@section('script')
<script>

var vm = new Vue({
    el:"#filter",
    data:{
        response: {},
        errors: {},
        table: null,
        success: false,
        columnDefs: [],
        data: [],
        subjects: [],
        tData: [],
        exam:'',
        course_id:''


    },
    
    created:function(){
        var self = this;
    },

    methods: {

        getData: function() {
            var self = this;
            var data = $.extend({}, {
                exam:self.exam,
                course_id:self.course_id
            })
            self.$http.get("{{ url('pu-exam-report') }}", {params: data})
            .then(function (response) {
                // console.log(response.data);
                self.data = (typeof response.data.data) == "string" ? JSON.parse(response.data.data) : response.data.data;
                self.subjects = (typeof response.data.subjects) == "string" ? JSON.parse(response.data.subjects) : response.data.subjects;
                self.reloadTable();
            })
            .catch(function(error){
                self.errors = error.data;
            })
        },

        reloadTable: function() {
            var self = this;
            if(self.table != null) {
                self.table.destroy();
                $('#pu_exam').empty();
            }
            self.setColumns();
            self.setData();
            self.setDataTable();
            self.table.clear();
            self.table.rows.add(self.tData).draw();
        },

        setColumns: function() {
            var self = this;
            var t = 0;
            var data_col = '';
            self.columnDefs = [
                { targets: '_all', visible: true },
                { title: 'Sr No.', targets: t++, data: 'sr_no'},
                { title: 'Roll No', targets: t++, data: 'roll_no'},
                { title: 'College Roll', targets: t++, data: 'college_roll_no'},
                { title: 'Regd No', targets: t++, data: 'reg_no'},
                { title: 'Name', targets: t++, data: 'name'},
                { title: 'Father Name',targets: t++, data: 'father_name'},
                { title: 'Mother Name', targets: t++, data: 'mother_name'},
            ];
            self.subjects.forEach(function(ele){
                data_col = 'marks_'+ele.id;
                self.columnDefs.push({ title: ele.subject+'('+ele.max_marks+')', targets: t++, data: data_col});
            })
        },

        getBlanRec() {
            var self = this;
            var rec = {
                sr_no: '',
                roll_no: '',
                college_roll_no: '',
                reg_no: '',
                name: '',
                father_name: '',
                mother_name: '',
            };
            self.subjects.forEach(function(ele){
                rec['marks_'+ele.id] = '';
            })
            return rec;
        },
        
        setData: function() {
            self = this;
            var std_id = 0;
            var s_no = 1;
            var record = {};
            self.tData = [];
            self.data.forEach(ele => {
                if(std_id == 0 || std_id != ele.std_id) {
                    if(std_id != 0) {
                        self.tData.push(record);
                    }
                    std_id = ele.std_id;
                    record = self.getBlanRec();
                    record['sr_no'] = s_no++;
                    record['roll_no'] = ele.student.roll_no;
                    record['college_roll_no'] = ele.student.adm_no;
                    record['reg_no'] = ele.student.pu_regno;
                    record['name'] = ele.student.name;
                    record['father_name'] = ele.student.father_name;
                    record['mother_name'] = ele.student.mother_name;
                }
                record['marks_'+ele.pu_exam_det_id] = ele.marks;
            });
            if(std_id != 0) {
                self.tData.push(record);
            }
        },


        setDataTable: function(){
            var self = this;
            self.table = $('#pu_exam').DataTable({
                dom: 'Bfrtip',
                lengthMenu: [
                    [ 10, 25, 50, -1 ],
                    [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                ],

                buttons: [
                    'pageLength',
                    {
                        extend: 'excelHtml5',
                        header: true,
                        footer: true,
                        exportOptions: {
                            orthogonal: 'export'
                        },
                    },
                ],

                "processing": true,
                "scrollCollapse": true,
                "ordering": true,
                data: [],
                columnDefs: self.columnDefs,
                "sScrollX": true,
                // "footerCallback": function ( row, data, start, end, display ) {
                //     var api = this.api();
                //     Utilities.sumDataTableCols(api,[1,2,3,4,5,6]);
                // },
            });
            
        },

        
    }
});
</script>
@stop
