@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
<div class="box">
        <div class="box-header with-border">
            Filter
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'form.course_id',':disabled'=>'showRoll']) !!}
                    <span id="basic-msg" v-if="errors['course_id']" class="help-block">@{{ errors['course_id'][0] }}</span>
                
                </div>

                {!! Form::label('exam','Exam:',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    <select class="form-control select-form" v-model="form.exam" :disabled='showRoll'>
                        <option value="pu_odd">PU ODD</option>
                        <option value="pu_even">PU EVEN</option>
                    </select>
                    <span id="basic-msg" v-if="errors['exam']" class="help-block">@{{ errors['exam'][0] }}</span>
                </div>

                <div class="col-sm-3">
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'getData()','v-if'=>"!showRoll"]) !!}
                    {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'showRoll']) !!}
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

   <div v-if="errors">
        <span style="margin-left:40px" id="basic-msg" v-if="errors['gen_msg']" class="help-block">@{{ errors['gen_msg'][0] }}</span>
        <span style="margin-left:40px" id="basic-msg" v-if="errors['marks.min_marks']" class="help-block">@{{ errors['marks.min_marks'][0] }}</span>
        <span style="margin-left:40px" id="basic-msg" v-if="errors['marks.max_marks']" class="help-block">@{{ errors['marks.max_marks'][0] }}</span>

   </div>

   <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <strong>Success!</strong> @{{ response['success'] }}
  </div>

    <div class="box">
        <div class="box-header with-border">
            <span>Exam Master</span>
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
                    course_id:'',
                    exam:'',
                    semester:'',
                    index:'',
                    marks:{
                        pu_exam_id:0,
                        subject_id:0,
                        min_marks:'',
                        max_marks:'',
                       
                    },
                  
                },    
                table : null,
                // pu_exam:{!! isset($pu_exam) ? $pu_exam : 0 !!},
                tData:[],
                errors: {},
                createUrl:'exam-master',
                pupin_no:'',
                showRoll:false,
                showTable:false,
                success: false,

            },
            ready:function(){
                var self = this;
                self.setDatatable();
                $(document).on('blur', '.max_marks', function(e) {
                    if(e.target.value != '')
                    self.setDays(e.target.dataset.sem,e.target.dataset.subId,e.target.value,e.target.dataset.index,'max_marks');
                });

                $(document).on('blur', '.min_marks', function(e) {
                    if(e.target.value != '')
                    self.setDays(e.target.dataset.sem,e.target.dataset.subId,e.target.value,e.target.dataset.index,'min_marks');
                });
                
            },
           
            methods: {
                resetData:function(){
                    var self = this;
                    self.form.course_id = '';
                    self.form.exam = '';
                    self.form.semester= '';
                    self.form.index= '';
                    self.form.pu_exam_id= '';
                    self.form.subject_id= '';
                    self.form.min_marks= '';
                    self.form.max_marks= '';
                    // self.exam='';
                    self.tData = [];
                    self.reloadTable();
                    self.showRoll = false;
                    // self.showTable= false;
                },
                
                
                getData: function() {
                    var self = this;
                    self.$http.get(MCM.base_url +'/'+ self.createUrl,
                    {
                        params: {
                            course_id: self.form.course_id,
                            exam: self.form.exam,
                        }
                    })
                    .then(function (response)
                    {
                        if(response.data.success) {
                            self.tData = response.data.data;
                            self.reloadTable();
                            
                            if(self.tData.length > 0){
                                self.showRoll = true;
                            }
                            else{
                                self.showRoll = false;
                            }
                            
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

                reloadTable: function() {
                    var self = this;
                    self.table.clear();
                    console.log(self.tData);
                    self.table.rows.add(self.tData).draw();
                },
                
                setDatatable: function(){
                    var self = this;
                    var disabled = "disabled";
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

                        { title: 'Uni Code', targets: 1, data: 'uni_code',
                        },
                        
                        { title: 'Subject', targets: 2, 
                            "render":function(data, type, row, meta){
                                var str = '';
                                    // str+= '<input type="text" value='+row.subject.subject+'  '+disabled+' class="form-control subject" data-sem-id='+row.semester+'>';
                                   str += row.subject;
                                return str;

                            }
                        },

                        { title: 'Max Marks', targets: 3,
                            "render":function(data, type, row, meta){
                                var str = '';
                                var index = meta.row;
                                var marks = row.max_marks == null ? 0 : row.max_marks;
                                    str+= '<input type="text" value='+marks+' data-index='+index+'  class="form-control max_marks" data-sem='+row.semester+' data-sub-id='+row.subject_id+'>';
                                return str;

                            }
                        },
                        { title: 'Min Marks', targets: 4,
                            "render":function(data, type, row, meta){
                                var str = '';
                                var index = meta.row;
                                var marks = row.min_marks == null ? 0 : row.min_marks;
                                // console.log(index);
                                    // str+= '<input type="text" value='+marks+' data-index='+index+' name="marks.'+index+'.min_marks" class="form-control min_marks" data-sem='+row.semester+' data-sub-id='+row.subject_id+'>';
                                    str+= '<input type="text" data-index='+index+' name="gen_msg.'+index+'.min_marks" value='+marks+' class="form-control min_marks" data-sem='+row.semester+' data-sub-id='+row.subject_id+'>';
                                return str;
                            }
                        },

                        // { title: 'Action', targets: 5,
                        //     "render":function(data, type, row, meta){
                        //         var str = '';
                        //         var index = meta.row;
                        //         str += '<button data-submit-marks="submit" data-item-action="Submit" class="btn btn-primary submit ">Save</button></a>';
                        //         return str;
                        //     }
                        // },
                        { targets: '_all', visible: true }
                        ],

                        "drawCallback": function( settings ) {
                           
                        }



                //      "deferRender": true,
                        // "sScrollX": true,
                    });
                },

                setDays:function(sem,sub_id,value,index,status){
                    var self = this;
                    self.form.semester = sem;
                    self.form.index = index;
                    self.form.marks.subject_id = sub_id;
                    if(status == 'max_marks' && value > 0)
                        self.form.marks.max_marks = value;
                    else if(status == 'min_marks')
                        self.form.marks.min_marks = value;
                    if(self.form.marks.max_marks > 0 && self.form.marks.min_marks > 0){
                        console.log('0101010');
                        self.saveData()
                    }
                },

                saveData:function(){
                    var self =this;
                    // self.form.index = index;
                    this.$http.post("{{ url('exam-master') }}", this.$data.form )
                    .then(function(response) {
                        if(response.data.success){
                            self.form.marks.max_marks = '';
                            self.form.marks.min_marks = '';
                            self.form.index = '';
                            var pu_exam= response.data.pu_exam;
                                self.errors = '';
                                self.success = true;
                                setTimeout(function() {
                                    self.success = false;
                                }, 3000);

                            
                        }
                    },
                    function(response) {
                        console.log(response);
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                                self.errors = response.data;
                                $.each(response.data, function(i, v) {
                                    console.log(i);
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
