@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
<div class="box">
        <div class="box-header with-border">
            PU Marks Entry
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('type','Class Type:',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    <select class="form-control select-form" v-model="form.type" :disabled='showClassField'>
                        <option value="GRAD">UG</option>
                        <option value="PGRAD">PG</option>
                    </select>
                    <span id="basic-msg" v-if="errors['type']" class="help-block">@{{ errors['type'][0] }}</span>
                </div>

                {!! Form::label('exam','Exam:',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    <select class="form-control select-form" v-model="form.exam" :disabled='showClassField'>
                        <option value="pu_odd">PU ODD</option>
                        <option value="pu_even">PU EVEN</option>
                    </select>
                    <span id="basic-msg" v-if="errors['exam']" class="help-block">@{{ errors['exam'][0] }}</span>
                </div>
                <div class="col-sm-3">
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'showRoll()','v-if'=>"!showClassField"]) !!}
                    {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetRollData()','v-if'=>'showClassField']) !!}
                </div>
            </div>
            <!-- <div class="form-group">
                
                <span style="color:red">@{{ msg }}</span>
            </div> -->
            <div class="form-group" v-if="showRollField">
                {!! Form::label('college_roll_no','College Roll No',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('college_roll_no',null,['class' => 'form-control', 'v-model' => 'form.college_roll_no',':disabled'=>'showField']) !!}
                    <span id="basic-msg" v-if="errors['college_roll_no']" class="help-block">@{{ errors['college_roll_no'][0] }}</span>
                
                </div>

                {!! Form::label('uni_roll_no','Uni Roll No',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('uni_roll_no',null,['class' => 'form-control', 'v-model' => 'form.uni_roll_no',':disabled'=>'showField']) !!}
                    <span id="basic-msg" v-if="errors['uni_roll_no']" class="help-block">@{{ errors['uni_roll_no'][0] }}</span>
                    <span id="basic-msg" v-if="errors['gen_msg']" class="help-block">@{{ errors['gen_msg'][0] }}</span>
                
                </div>
                <div class="col-sm-3"  v-if="showRollField">
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'getData()','v-if'=>"!showField"]) !!}
                    {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'showField']) !!}
                </div>
            </div>
            <div class="form-group" v-if="showRollField">
                <span style="color:red">@{{ msg }}</span>
            </div>

            

            <div class="form-group" v-if="showDisableField">
                {!! Form::label('student_name','Student',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-2">
                {!! Form::text('student_name',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'student_name']) !!}
                </div>

                {!! Form::label('father_name','Father Name',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('father_name',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'father_name']) !!}
                </div>

                {!! Form::label('roll_no','College Roll NO',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('roll_no',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'roll_no']) !!}
                </div>

        
            </div>
            <div class="form-group" v-if="showDisableField">
                {!! Form::label('uni_roll_no','Uni Roll No',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-2">
                {!! Form::text('uni_roll_no',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'uni_roll_no']) !!}
                </div>

                {!! Form::label('uni_roll_no2','Uni Roll No 2',['class' => 'col-sm-2 control-label ']) !!}
                <div class="col-sm-2">
                {!! Form::text('uni_roll_no2',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'uni_roll_no2']) !!}
                </div>

                {!! Form::label('course_name','Course Name',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('course_name',null,['class' => 'form-control',':disabled'=>'true', 'v-model' => 'course_name']) !!}
                </div>

                
            </div>
            <div class="form-group" v-if="showDisableField">
                {!! Form::label('uni_agregate','University Agregate',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::text('uni_agregate',null,['class' => 'form-control', 'v-model' => 'pu_exam_student.uni_agregate']) !!}
                    <span id="basic-msg" v-if="errors['uni_agregate']" class="help-block">@{{ errors['uni_agregate'][0] }}</span>
                
                </div>
                {!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::text('remarks',null,['class' => 'form-control', 'v-model' => 'pu_exam_student.remarks']) !!}
                    <span id="basic-msg" v-if="errors['remarks']" class="help-block">@{{ errors['remarks'][0] }}</span>
                </div>
                
            </div>
            <div class="form-group" v-if="showDisableField">
                {!! Form::label('fail','Fail',['class' => 'col-sm-2 control-label required']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['fail'] }">
                    <label class="radio-inline">
                        {!! Form::radio('fail','Y',null, ['class' => 'minimal','v-model'=>'pu_exam_student.fail']) !!}
                        Yes
                        </label>
                    <label class="radio-inline">
                    {!! Form::radio('fail', 'N',null, ['class' => 'minimal','v-model'=>'pu_exam_student.fail']) !!}
                        No
                    </label>
                </div>
                <div class="col-sm-2" v-if='pu_exam_student.id > 0 '>
                    {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'submitData()',':disabled'=>'btnDisacbled']) !!}
                </div>
                <div class="col-sm-2" v-else>
                    {!! Form::submit('Save',['class' => 'btn btn-primary','@click.prevent'=>'submitData()',':disabled'=>'btnDisacbled']) !!}
                </div>
            
            </div>
            {!! Form::close() !!}
        </div>
    </div>
   <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>

    <div class="box">
        <div class="box-header with-border">
            <span>PU Marks Entry</span>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="date-sheet" class="table table-bordered" width="100%">
                </table>
            </div>
        </div>
    </div>

</div>
@stop
@section('script')
  <script>
    var datesheet = new Vue({
        el:"#datesheet",
            data:{
                form:{
                    id:0,
                    college_roll_no:'',
                    uni_roll_no:'',
                    exam:'',
                    uni_agregate:'',
                    type:'',
                    
                },  
                
                pu_exam_student:{
                    id:0,
                    pu_exam_id:'',
                    std_id:'',
                    fail:'N',
                    remarks:'',
                    uni_agregate:'',
                },

                marks:{
                    std_id:'',
                    pu_exam_det_id:'',
                    marks:'',
                    compartment:'',
                    max_marks:'',
                    index:'',
                },
                table : null,
                // pu_exam:{!! isset($pu_exam) ? $pu_exam : 0 !!},
                tData:[],
                errors: {},
                createUrl:'pu-marks-entry',
                pupin_no:'',
                showField:false,
                showRollField:false,
                showClassField:false,
                showTable:false,
                showDisableField:false,
                btnDisacbled:false,
                success: false,
                student_name:'',
                father_name:'',
                roll_no:'',
                uni_roll_no:'',
                course_name:'',
                uni_roll_no2:'',
                msg:'',

            },
            ready:function(){
                var self = this;
                self.setDatatable();
                $(document).on('focusout', '.change-compartment', function(e) {
                    console.log(e.target.dataset);
                    if(e.target.value != '')
                    self.setDays(e.target.value,e.target.dataset.stdId,e.target.dataset.puExamDetId,e.target.dataset.index,e.target.dataset.maxMarks,e.target.dataset.marks,'change-compartment');
                });

                $(document).on('change', '.obtain_marks', function(e) {
                    if(e.target.value != '')
                    self.setDays(e.target.value,e.target.dataset.stdId,e.target.dataset.puExamDetId,e.target.dataset.index,e.target.dataset.maxMarks,e.target.dataset.comp,'obtain_marks');
                });
                
            },
           
            methods: {
                showRoll:function(){
                    var self =this;
                    self.showDisableField=false;
                    self.showField=false;
                    self.showClassField= true;
                    self.showRollField=true;
                },
                resetRollData:function(){
                    var self =this;
                    self.showDisableField=false;
                    self.form.exam = '';
                    self.form.type='';
                    self.form.college_roll_no='';
                    self.form.uni_roll_no='';
                    self.showField = false;
                    self.showClassField= false;
                    self.showRollField=false;
                    self.tData = [];
                    self.reloadTable();

                },

                submitData:function(){
                    var self =this;
                    // self.form.index = index;
                    this.$http.post("{{ url('pu-exam-std-entry') }}", this.$data.pu_exam_student)
                    .then(function(response) {
                        if(response.data.success){
                           self.btnDisacbled = true;
                        }
                    },
                    function(response) {
                        // console.log(response);
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                                self.errors = response.data;
                            }    
                    });
                },
                resetData:function(){
                    var self = this;
                    self.showDisableField=false;
                    self.btnDisacbled=false;
                    self.form.college_roll_no = '';
                    // self.form.exam = '';
                    self.form.uni_roll_no= '';
                    // self.form.type='';
                    // self.uni_roll_no2='';
                    self.student_name='',
                    self.father_name='',
                    self.roll_no='',
                    self.uni_roll_no='',
                    self.course_name='',
                    self.uni_roll_no2='',
                    self.pu_exam_student.remarks='',
                    self.pu_exam_student.fail='',
                    self.pu_exam_student.uni_agregate='',
                    // self.exam='';
                    self.tData = [];
                    self.reloadTable();
                    self.showField = false;
                    
                    // self.showTable= false;
                },
                
                
                getData: function() {
                    var self = this;
                    self.$http.get(MCM.base_url +'/'+ self.createUrl,
                    {
                        params: {
                            college_roll_no: self.form.college_roll_no,
                            uni_roll_no: self.form.uni_roll_no,
                            exam: self.form.exam,
                            type: self.form.type,

                        }
                    })
                    .then(function (response)
                    {
                        if(response.data.success) {
                            // console.log(response.data.data);
                            if(response.data.data.length > 0){
                                self.tData = response.data.data;
                                response.data.data.forEach(function(ele){
                                    // console.log(ele);
                                    self.student_name = ele.name;
                                    self.father_name = ele.father_name;
                                    self.roll_no = ele.roll_no;
                                    self.uni_roll_no = ele.pu_regno;
                                    self.uni_roll_no2 = ele.pu_regno2;
                                    self.course_name = ele.course_name;
                                    self.pu_exam_student.pu_exam_id = ele.pu_exam_id;
                                    self.pu_exam_student.std_id = ele.std_id
                                    self.pu_exam_student.fail = ele.fail;
                                    self.pu_exam_student.remarks = ele.remarks;
                                    self.pu_exam_student.uni_agregate = ele.uni_agregate;
                                    self.pu_exam_student.id = ele.pu_exam_std_id == null ? 0 : ele.pu_exam_std_id;
                                    
                                });
                                self.msg = '';
                                self.reloadTable();
                                self.showDisableField=true;
                                
                                if(self.tData.length > 0){
                                    self.showField = true;
                                }
                                else{
                                    self.showField = false;
                                }
                            }
                            else{
                                self.msg = 'Roll No Not exists'
                            }
                           
                            
                        }
                    },
                    function(response) {
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                                self.errors = response.data;
                            }    
                    });
                },

                reloadTable: function() {
                    var self = this;
                    self.table.clear();
                    // console.log(self.tData);
                    self.table.rows.add(self.tData).draw();
                },
                
                setDatatable: function(){
                    var self = this;
                    this.table = $('#date-sheet').DataTable({
                //      "searchDelay": 1000,
                        dom: 'Bfrtip',
                        lengthMenu: [
                            [ 10, 25, 50, -1 ],
                            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                        ],
                        buttons: [
                        'pageLength',
                            {
                                extend: 'excelHtml5',
                                exportOptions: { orthogonal: 'export' }
                            },
                            {
                                header: true,
                                footer: true,
                                extend: 'pdfHtml5',
                                download: 'open',
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                exportOptions: { orthogonal: 'export' }
                                // title: function () {
                                //       var title = '';
                                //         title += "Stock Register Report    ";
                                //         title += self.msg
                                //       return title;
                                // },
                            }
                        ],
                        "processing": true,
                        "scrollCollapse": true,
                //      "serverSide": true,
                        "ordering": true,
                        data: [],
                        columnDefs: [
                        { title: 'S.No.', targets: 0, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }},
                        { title: 'Subject', targets: 1, 
                            "render":function(data, type, row, meta){
                                var str = '';
                                   str += row.subject;
                                return str;

                            }
                        },

                        { title: 'Max Marks', targets: 2,
                            "render":function(data, type, row, meta){
                                var str = '';
                                str += row.max_marks;
                                return str;

                            }
                        },
                        { title: 'Min Marks', targets: 3,
                            "render":function(data, type, row, meta){
                                return row.min_marks;
                            }
                        },

                        { title: 'Obtained Marks', targets: 4,
                            "render":function(data, type, row, meta){
                                var str = '';
                                var marks = row.marks == null ? 0 : row.marks;
                                var index = meta.row;
                                var comp = row.compartment == null ? 'N' : row.compartment;
                                str+= '<input type="text" name="gen_msg.'+index+'.marks" value='+marks+' class="form-control obtain_marks" data-std-id='+row.std_id+' data-pu-exam-det-id='+row.pu_exam_det_id+' data-max-marks='+row.max_marks+' data-index='+index+' data-comp='+comp+' >';
                                return str;
                            }
                        }, 

                        { title:'Compartment', targets: 5,
                            "render":function(data, type, row, meta){
                                var str = '';
                                var index = meta.row;
                                var marks = row.marks == null ? 0 : row.marks;
                                // console.log(marks);
                                str+= "<select class='form-control change-compartment' value="+row.compartment+" data-std-id="+row.std_id+" data-pu-exam-det-id="+row.pu_exam_det_id+"  data-max-marks="+row.max_marks+" data-index="+index+" data-marks="+marks+">";
                                    if(row.compartment == 'N')
                                                str+="<option value='N' selected>No</option>";
                                        else
                                            str+="<option value='N'>No</option>";
                                    if(row.compartment == 'Y')
                                            str+="<option value='Y' selected>Yes</option>";
                                    else
                                        str+="<option value='Y'>Yes</option>";
                                   
                                        // str+="<option value='N' selected>No</option>";
                                  

                                return str;
                            }
                        },

                        { targets: '_all', visible: true }
                        ],

                        "drawCallback": function( settings ) {
                           
                        }



                //      "deferRender": true,
                        // "sScrollX": true,
                    });
                },

                setDays:function(value,stdId,puExamDetId,index,maxMarks,subfield,status){
                    var self = this;
                    self.marks.std_id = stdId;
                    self.marks.pu_exam_det_id = puExamDetId;
                    self.marks.max_marks = maxMarks;
                    self.marks.index = index;
                    if(status == 'obtain_marks' && value > 0){
                        self.marks.marks = value;      
                    }
                    if(status == 'change-compartment'){
                        self.marks.compartment = value;
                        if(self.marks.marks == ''){
                            self.marks.marks = subfield;
                        }
                    }
                    // if(status == 'change-compartment')
                    //     self.marks.compartment = value;
                    if(self.marks.marks > 0 && self.marks.compartment){
                        self.saveData()
                    }else{
                        self.marks.compartment ='';
                        // self.marks.marks = '';
                    }
                   
                },

                saveData:function(){
                    var self =this;
                    // self.form.index = index;
                    this.$http.post("{{ url('pu-marks-entry') }}", this.$data.marks )
                    .then(function(response) {
                        if(response.data.success){
                            self.marks.marks = '';
                            self.marks.compartment = '';
                            self.marks.std_id = 0;
                            self.marks.max_marks = '';
                            self.marks.index = '';
                            var pu_exam= response.data.mark;
                                self.errors = '';
                                self.success = true;
                                setTimeout(function() {
                                    self.success = false;
                                }, 3000);

                            
                        }
                    },
                    function(response) {
                        // console.log(response);
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                                self.errors = response.data;
                                $.each(response.data, function(i, v) {
                                    // console.log(i);
                                    var msg = '<span class="help-block" for="'+i+'">'+v+'</span>';
                                    $('input[name="' + i + '"], select[name="' + i + '"]').after(msg);
                                    $('input[name="' + i + '"], select[name="' + i + '"]').addClass('help-block');
                                });
                            }    
                    });
                    
                },

            
            }
    });
  </script>
@stop
