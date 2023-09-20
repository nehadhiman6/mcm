@extends('app')

@section('toolbar')
  @include('toolbars._admform_toolbar')
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
  <div class="box-body">
    {!! Form::open(['class' => 'form-horizontal',]) !!}
    <div class="form-group">
      {!! Form::label('date_from','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_from',request('date_from',getFYStartDate()),['class' => 'form-control app-datepicker', 'v-model'=>'date_from']) !!}
      </div>
      {!! Form::label('date_to','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('date_to',request('date_to',today()),['class' => 'form-control app-datepicker', 'v-model'=>'date_to']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('filled_by','Filled By',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('filled_by',[''=>'Submitted', 'officials'=>'Officials', 'students'=>'Students','to_be_submitted'=>'Not Submitted'],request('filled_by'),['class' => 'form-control', 'v-model'=>'filled_by']) !!}
      </div>
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(),request('course_id'), ['class' => 'form-control', 'v-model' => 'course_id']) !!}
      </div>
    </div>
    <div class="form-group"  >
      {!! Form::label('status','Status',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('status',[''=>'All', 'A'=>'Admitted', 'N'=>'Not-Admitted'],request('status'),['class' => 'form-control', 'v-model'=>'status']) !!}
      </div>
      {!! Form::label('form_status','Form Status',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('form_status',[ 'N'=>'Not Scrutinized', 'Y'=>'Scrutinized', 'SA'=>'Scrutinized All','H'=>'Scrutinized Hostel','A'=>'All'],request('form_status'),['class' => 'form-control', 'v-model'=>'form_status']) !!}
      </div>
      
    </div>
    <div class="form-group"  >
     <div class="col-sm-4 col-sm-offset-1">
        <label class="checkbox" >
          <input type="checkbox" name="hostel_only" v-model="hostel_only" v-bind:true-value="'Y'" v-bind:false-value="'N'">
          Who has paid Hostel Prospectus Fee
        </label>
      </div>
    </div>

  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class='panel panel-default' id='app'>
  <div class='panel-heading'>
    <strong>Admission Forms</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
  $(function() {
    $(document).on('click', '.show-file', (function() {
      dashboard.showImage($(this).data('adm-id'), $(this).data('file-type'));
    }));
    // $(".scrutinized-hostel").unbind('click').on( 'click', function (e) {
    //     dashboard.scrutinizedHostel(e.target.dataset.itemId,e.target.dataset.itemAction,e.target.dataset.itemType);
    // });

    $(document).on('click', '.scrutinized-hostel', (function(e) {
      console.log(e);
      dashboard.scrutinizedHostel($(this).data('item-id'),$(this).data('item-action') ,$(this).data('item-type'));
    }));
  });
  var dashboard = new Vue({
    el: '#filter',
    data: {
        tData: [],
        course_id: {{ $course->id or request("course_id",0) }},
        date_from: '',
        date_to: '',
        status: '',
        form_status:'N',
        filled_by: '',
        table: null,
        hostel_only: 'N',
        url: "{{ url('/') . '/admission-form/' }}",
        dis_url:"{{ url('/') . '/discrepancy/' }}",
        hostel_url: "{{ url('/') . '/admission-form/' }}",
        attachUrl: "{{ (isset($guard) && $guard == 'web' ? url('attachment') : url('stdattachment')).'/' }}",
        files: []  ,
        permissions: {!! json_encode(getPermissions()) !!},
        addrescategory: {!! getAddResCategory(true) !!},
      },
    created: function() {
      var self = this;
      var target = 0;
      this.table = $('#example1').DataTable({
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          buttons: [
             'pageLength',
              {
                  extend: 'excelHtml5',
                  exportOptions: { 
                    orthogonal: 'export',
                    columns: [0,1,4,5,6,77,78,7,8,9,50,52,11,12,13,14,15,16,80,17,18,19,20,26,27,62,
                    63,64,65,66,67,68,69,21,22,23,24,25,28,29,30,31,32,33,34,35,36,37,38,39,40,41,
                    42,43,44,45,46,47,48,49,53,54,55,56,57,58,59,60,61,72,73,74,75,70,76,71,2,79,3,7,81,82,10,83,84,85,86] 
                  },
                  
              },
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: [
             { "visible": false, "targets": [17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,77,78] },
             { title: 'S.No.', targets:target++ , data: 'id',
              "render": function( data, type, row, meta) {
                return meta.row + 1;
              }},
            { title: 'Form ID', targets:target++, data: 'id' ,
              "render": function( data, type, row, meta){
                if(type == 'export') {
                  return data;
                }
                var fld = data;
                if(self.permissions['PREVIEW-ADMISSION-FORMS']){
                  if(row.hostel_form){
                    fld += "<br><a href='" + self.url + data +"'" + " class='btn btn-primary btn-xs mb-1' target = '_blank'>College Form Preview</a>"+
                        "<br><a href='" + self.hostel_url + data +"/hostel'" + " class='btn btn-primary btn-xs mb-1' target = '_blank'>Hostel Form Preview</a>";
                  }
                  else{
                    fld += "<br><a href='" + self.url + data +"'" + " class='btn btn-primary btn-xs mb-1' target = '_blank'>College Form Preview</a>";
                  }
                }
                if(row.scrutinized == 'N'){
                  if(row.final_submission == 'Y' && self.permissions['open-final-submission']) {
                      fld += "<br><a href='" + self.hostel_url + data +"/open-submission'" + " class='btn btn-primary btn-xs' target = '_blank'>Re-open Submitted form</a>";
                  }

                  if(row.attachment_submission == 'Y' && self.permissions['attachment-submission'] ) {
                      fld += "<br><a href='" + self.hostel_url + data +"/attachment-submission'" + " class='btn btn-primary btn-xs' target = '_blank' style='margin: 3px 0 0 0;'>Re-open Attachment tab</a>";
                  }
                }
               
                if(self.permissions['scrutinize-form']) {
                  if(row.final_submission == 'Y' && row.attachment_submission == 'Y' && row.scrutinized != 'H') {
                    if(row.scrutinized == 'Y') {
                        fld += "<br><a href='" + self.hostel_url + data +"/scrutinized'" + " class='btn btn-primary btn-xs' style='margin: 3px 0 0 0;' target = '_blank'>Un-Scrutinized</a>";
                    }
                    else{
                        fld += "<br><a href='" + self.hostel_url + data +"/scrutinized'" + " class='btn btn-primary btn-xs' style='margin: 3px 0 0 0;' target = '_blank'>Scrutinized</a>";
                    }
                  }
                }
                if(self.permissions['adm-discrepancy']) {
                  if(row.scrutinized == 'N')
                    fld += "<br><a href='" + self.dis_url + data +"'" + " class='btn btn-primary btn-xs' style='margin: 3px 0 0 0;' target = '_blank'>Discrepancy</a></br>";
                }

                // console.log(row);

                if(self.permissions['scrutinize-hostel']) {
                  if(row.hostel_form){
                      if(row.hostel_form.fee_paid == 'Y'){
                          if(row.scrutinized == 'H' && row.std_id > 0) {
                            fld += '<a data-item-id='+row.id+' style="margin:6px 0 0 0"  data-item-action="Un-Scrutinized Hostel" data-item-type="Y" class="btn btn-primary btn-xs scrutinized-hostel ">Un-Scrutinized Hostel</a>';
                        }
                        else if(row.scrutinized == 'Y' && row.std_id > 0  ){
                          fld += '<a data-item-id='+row.id+' style="margin:6px 0 0 0"  data-item-action="Scrutinized Hostel" data-item-type="H" class="btn btn-primary btn-xs scrutinized-hostel ">Scrutinized Hostel</a>';
                        }
                      }
                     
                  }
                }
               return fld;
              }
            },
            { title: 'Scrutinized', targets:target++,
              "render": function ( data, type, row, meta ) {
                var str = '';
                    if(row.scrutinized == 'Y'){
                      str = 'Yes';
                    }
                    else if(row.scrutinized == 'H'){
                      str = 'Hostel';
                    }
                    else{
                      str = 'No';
                    }
                    return str;
              // return row.scrutinized == 'Y' ?'Yes' : 'No';
            }},

            { title: 'Discrepancy (If Any)', targets:target++,
              "render": function ( data, type, row, meta ) {
                var val = '';
                row.discrepancy.forEach(function(e) {
                  if(e.opt_value == 'Y' && row.scrutinized == 'N') {
                    console.log('i am here');
                    val = e.opt_value == 'Y' ? 'Yes' : '';
                  }else{
                    val = '';
                  }
                });
                return val;
            }},

            {title:'Last Year Roll no',targets:target++,data:'lastyr_rollno'},
            { title: 'Name', targets:target++, data: 'name',
             "render": function( data, type, row, meta){
                if(type == 'export')
                  return data;
                if(self.permissions['EDIT-ADMISSION-FORMS']){
                   data += "<br><a href='" + self.url + row.id + "/edit'" + " class='btn btn-primary btn-xs mb-1'>Edit</a>";
                } 
                if(row.course && row.course.course_name == 'BAI'){
                   data += "<br><a href='"+MCM.base_url+"/adm-subject-options/" + row.id+"' target='_blank' class='btn btn-primary btn-xs'>Subject Options</a>";
                }

                if(row.course && row.course.course_name == 'BAI'){
                   data += "<br><a href='"+MCM.base_url+"/adm-subject-combination/" + row.id+"' target='_blank' class='btn btn-primary btn-xs'>Subject Combination</a>";
                }
                return data;
            }},
            { title: 'Father Name', targets:target++, data: 'father_name' },
            { title: 'Course', targets:target++, data: 'course',
              "render": function ( data, type, row, meta ) {
              return (row.course ? row.course.course_name : '') ;
            }},
            { title: 'Contact No.', targets:target++, data: 'mobile' },
            { title: 'Attachments', targets:target++, data: 'attachments',
            "render": function ( data, type, row, meta ) {
              var list = '';
              if(data.length) {
                $.each(data, function(index, file) {
                  list += '<a href="#" class="show-file" data-adm-id="'+row.id+'" data-file-type="'+file.file_type+'">'+file.file_type+'</a><br>'
                });
              }
              return list;
              return data.length ? data.file_type : '' ;
            }},

            { title: 'Attachments Combine', targets:target++, data: 'attachments',
              "render": function ( data, type, row, meta ) {
                var str = '';
                if(data.length) {
                  str += "<br><a href='"+MCM.base_url+"/admission-all-attachment-show/" + row.id+"' target='_blank' class='btn btn-primary btn-xs'>View</a>";
                }
                 return str;
                
            }},
            
            { title: 'Exam', targets:target++, data: 'academics[0].exam' },
            { title: 'Institution', targets:target++, data: 'academics[0].institute' },
            { title: 'Board/University', targets:target++, data: 'academics[0].board.name' },
            { title: 'Roll No.', targets: target++, data: 'academics[0].roll_no' },
            { title: 'Year', targets: target++, data: 'academics[0].year' },
            { title: 'Result', targets: target++, data: 'academics[0].result' },
            { title: 'Total Marks', targets: target++, data: 'academics[0].total_marks' },
            { title: 'Marks Obtained', targets: target++, data: 'academics[0].marks_obtained' },
            { title: '%age', targets: target++, data: 'academics[0].marks_per' },
            { title: 'Subjects Offered', targets: target++, data: 'academics[0].subjects' },
            { title: 'DOB', targets: target++, data: 'dob' },
            { title: 'Nationality', targets: target++, data: 'nationality' },
            { title: 'Religion', targets: target++, data: 'religion' },
            { title: 'AAdhar No.', targets: target++, data: 'aadhar_no' },
            { title: 'Blood Group', targets: target++, data: 'blood_grp' },
            { title: 'Migration', targets: target++, data: 'migration', 
            "render": function ( data, type, row, meta ) {
              return (row.migration == 'Y' ? 'YES' : '') ;
            }},
            { title: 'Hostel', targets: target++, data: 'hostel',
            "render": function ( data, type, row, meta ) {
              return (row.hostel == 'Y' ? 'YES' : '') ;
            }},
            { title: 'Blind', targets: target++, data: 'blind', 
            "render": function ( data, type, row, meta ) {
              return (row.blind ? 'YES' : '') ;
            }},
            { title: 'Permanent Address', targets: target++, data: 'per_address' },
            { title: 'Pincode', targets: target++, data: 'pincode' },
            { title: 'Father Occupation', targets: target++, data: 'father_occup' },
            { title: 'Father Designation', targets: target++, data: 'father_desig' },
            { title: 'Father Phone', targets: target++, data: 'father_phone' },
            { title: 'Father Mobile', targets: target++, data: 'father_mobile' },
            { title: 'Father Email', targets: target++, data: 'father_email' },
            { title: 'Father Office Address', targets: target++, data: 'f_office_addr' },
            { title: 'Mother Occupation', targets: target++, data: 'mother_occup' },
            { title: 'Mother Designation', targets: target++, data: 'mother_desig' },
            { title: 'Mother Phone', targets: target++, data: 'mother_phone' },
            { title: 'Mother Mobile', targets: target++, data: 'mother_mobile' },
            { title: 'Mother Email', targets: target++, data: 'mother_email' },
            { title: 'Mother Office Address', targets: target++, data: 'm_office_addr' },
            { title: 'Guardian Occupation', targets: target++, data: 'guardian_occup' },
            { title: 'Guardian Designation', targets: target++, data: 'guardian_desig' },
            { title: 'Guardian Phone', targets: target++, data: 'guardian_phone' },
            { title: 'Guardian Mobile', targets: target++, data: 'guardian_mobile' },
            { title: 'Guardian Email', targets: target++, data: 'guardian_email' },
            { title: 'Guardian Office Address', targets: target++, data: 'g_office_addr' },
            { title: 'PU Registration No.', targets: target++, data: 'pu_regno' },
            { title: 'Pupin No.', targets: target++, data: 'pupin_no' },
            { title: 'Course', targets: target++, data: 'course',
              "render": function ( data, type, row, meta ) {
              return (row.course ? row.course.course_name : '') ;
            }},
            { title: 'Gap Year ', targets: target++, data: 'gap_year' },
            { title: 'Migrated', targets: target++, data: 'migrated',
              "render": function ( data, type, row, meta ) {
              return (row.migrated =='Y' ? 'YES' : '') ;
            }},
            { title: 'Migrate Details', targets: target++, data: 'migrate_detail' },
            { title: 'Disqualified', targets: target++, data: 'disqualified',
            "render": function ( data, type, row, meta ) {
              return (row.disqualified =='Y' ? 'YES' : '') ;
            }},
            { title: 'Disqualified Details', targets: target++, data: 'disqualify_detail' },
            { title: 'Foreign National', targets: target++, data: 'foreign_national',
            "render": function ( data, type, row, meta ) {
              return (row.foreign_national =='Y' ? 'YES' : '') ;
            }},
            { title: 'Foreign Natgionality', targets: target++, data: 'f_nationality' },
            { title: 'Passport No', targets: target++, data: 'passportno' },
            { title: 'Visa Valid Upto', targets: target++, data: 'visa' },
            { title: 'Residential Permit', targets: target++, data: 'res_permit' },
            { title: 'Subject Combination', targets: target++, data: 'combination',
                  "render": function( data, type, row, meta) {
                      var full = '';
                      row.sub_combinations.forEach(e => {
                          var str = '';
                          e.sub_comb.details.forEach(element => {
                              str += str != ''?',' : '';
                              str +=  element.subject ? element.subject.subject : '';
                          });
                          
                          full +=  '('+e.preference_no+') '+e.sub_comb.code+':- '+str+'</br>';
                          
                      });
                      return full;
              }},
            { title: 'Preference 1', targets: target++, data: 'adm_subs',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.sub_group_id == 0) {
                    subjects += e.subject.subject+', '
                  }
                });
              }
              return subjects;
            }},
            { title: 'Preference 2', targets: target++, data: 'admission_sub_preference',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.preference_no == 2) {
                    subjects += e.subject.subject+', ';
                  }
                });
              }
              return subjects;
            } },
            { title: 'Preference 3', targets: target++, data: 'admission_sub_preference',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.preference_no == 3) {
                    subjects += e.subject.subject+', '
                  }
                });
              }
              return subjects;
            } },
            { title: 'Preference 4', targets: target++, data: 'admission_sub_preference',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.preference_no == 4) {
                    subjects += e.subject.subject+', '
                  }
                });
              }
              return subjects;
            } },
            { title: 'Preference 5', targets: target++, data: 'admission_sub_preference',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.preference_no == 5) {
                    subjects += e.subject.subject+', '
                  }
                });
              }
              return subjects;
            } },
            { title: 'Preference 6', targets: target++, data: 'admission_sub_preference',
            "render": function ( data, type, row, meta ) {
              var subjects = '';
              if(data && data.length > 0) {
                data.forEach(function(e) {
                  if(e.preference_no == 6) {
                    subjects += e.subject.subject+', '
                  }
                });
              }
              return subjects;
            } },
            { title: 'Honours Preferences', targets: target++, data: 'id',
            "render": function ( data, type, row, meta ) {
                var str= '';
                if(row.honours.length > 0){
                  row.honours.forEach(function(ele){
                    str+= ele.preference +'.'+ele.subject.subject+'<br>';
                  })
                }
                return str;
            }},
            { title: 'AddOn course', targets: target++, data: 'id',
            "render": function ( data, type, row, meta ) {
                var str= '';
                if(row.add_on_course){
                  str = row.add_on_course.course_name;
                }
                return str;
            }},
            { title: 'Roommate Pref.', targets: target++, data: 'hostel_form',
            "render": function ( data, type, row, meta ) {
                return data && data.room_mate ? data.room_mate : '';
            }},
            { title: 'Form Submission Date', targets: target++, data: 'submission_time'},
            {visible: false, title: 'Category', targets: target++,
            "render": function ( data, type, row, meta ) {
                return  row.category ? row.category.name : '';
            }},

            {visible: false, title: 'Res Category', targets: target++,
            "render": function ( data, type, row, meta ) {
                return row.res_category ? row.res_category.name : '';
            }},
            {visible: false, title: 'Additional Res Category', targets: target++,
            "render": function ( data, type, row, meta ) {
              var cat = '';
              if(row.add_res_cats){
                var tt = row.add_res_cats;
                var add_res = tt.split(',');
                self.addrescategory.forEach(function(ele){
                    add_res.forEach(function(e){
                        if(ele.id == e){
                            cat += ele.name + ', ';
                        }
                    })
                })
              }else{
                  cat += '';
              }
              return cat;
              
                
            }},
            {visible: false, title: 'Ocet Roll No', targets: target++, data: 'ocet_rollno'},
            
            { title: 'College Processing Fee', targets: target++,  
            "render": function ( data, type, row, meta ) {
                return row.fee_paid == 'Y' ? 'Yes' : 'No';
            }},

            { title: 'Mother Name', targets: target++, data:'mother_name' 
            },

            { title: 'Guadian Name', targets: target++, data:'guardian_name' 
            },

            {visible: false, title: 'Anti ragging reference No', targets: target++, data: 'antireg_ref_no'},
            
            {visible: false, title: 'CGPA', targets:target++,
              "render": function ( data, type, row, meta ) {
              return row.academics[0] && row.academics[0].cgpa == 'Y' ?'Yes' : 'No';
            }},
            {visible: false, title: 'AC Room', targets:target++,
              "render": function ( data, type, row, meta ) {
              return row.hostel_form && row.hostel_form.ac_room == 'Y' ?'Yes' : 'No';
            }},
            {visible: false, title: 'Hostel processing fee', targets:target++,
              "render": function ( data, type, row, meta ) {
              return row.hostel_form && row.hostel_form.fee_paid == 'Y' ?'Yes' : 'No';
            }},
            {visible: false, title: 'MCM Graduate', targets:target++,
              "render": function ( data, type, row, meta ) {
              return row.mcm_graduate == 'Y' ?'Yes' : 'No';
            }},

            {visible: false, title: 'Document Pending', targets:target++,
              "render": function ( data, type, row, meta ) {
                var val = '';
                console.log(row.discrepancy);
                row.discrepancy.forEach(function(e) {
                  if(e.opt_value == 'Y' && e.opt_name == "document_pending") {
                    val = e.remarks;
                  }
                });
                
                return val;
            }},

            {visible: false, title: 'Student Email', targets:target++,
              "render": function ( data, type, row, meta ) {
                return row.std_user ? row.std_user.email : '';
            }},



            
            { targets: '_all', visible: true }
          ],
         
          "sScrollX": true,
        });
    },
    methods: {
      scrutinizedHostel(id,action,type){
        var self = this;
            var value = confirm('Are you sure you want to '+action+' ?');
            if(value){
              this.$http.get("{{ url('admission-form/scrutinized-hostel') }}"+'/'+id+'/'+type)
                .then(function (response) {
                  self.getData();
                }, function (response) {
      //            console.log(response.data);
              });
              }
    },
      getData: function() {
          data = $.extend({}, {
            course_id: this.course_id,
            date_from: this.date_from,
            date_to: this.date_to,
            filled_by: this.filled_by,
            hostel_only: this.hostel_only,
            status: this.status,
            form_status: this.form_status,
          })
          this.$http.get("{{ url('admission-form') }}", {params: data})
            .then(function (response) {
//                console.log(response.data);
              this.tData = response.data;
              this.reloadTable();
            }, function (response) {
  //            console.log(response.data);
          });
      },
      reloadTable: function() {
//          console.log('here');
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      },
      showImage: function(form_id, file_type) {
        self = this;
        window.open(
            this.attachUrl+form_id+'/'+file_type,
            '_blank'
          );
        return;
          if(this.url) {
            $.fancybox.open({
              src  : self.attachUrl+form_id+'/'+file_type,
              type : 'iframe',
              opts : {
                beforeLoad: function() {
//                    console.log(this);
                },
                iframe: {
                  css: {
                    width: '100% !important'
                  }
                }
               }
            });
          }
        }
      }
  }); 
</script>
@stop