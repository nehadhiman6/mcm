@extends('app')
@section('toolbar')
@include('toolbars._admission_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-4">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
<!--      {!! Form::label('fund_type','Fund',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_type',['C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model'=>'fund_type']) !!}
      </div>
      {!! Form::label('order','Order',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('order',['name'=>'Name','rollno'=>'Roll No'],request('institution'),['class' => 'form-control','v-model'=>'order']) !!}
      </div>-->
      {!! Form::label('category','Category',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('category',getCategory(),null,['class' => 'form-control','v-model'=>'category']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Students List</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
var dashboard = new Vue({
el: '#app',
data: {
      tData: [],
      course_id: {{ $course->id or request("course_id",0) }},
      category: '',
      order: '',
      table: null,
      url: "{{ url('/') . 'admregister/' }}",
     },
created: function() {
      self = this;
      var target = 1;
      this.table = $('#example1').DataTable({
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
          { title: 'Class', targets: target++, data: 'course_name'},
          { title: 'Adm.Date', targets: target++, data: 'adm_date' },
          { title: 'Online Form No', targets: target++, data: 'admission_id' },
          { title: 'Adm.No', targets: target++, data: 'adm_no' },
          { title: 'College Roll No.', targets: target++, data: 'roll_no' },
          { title: 'Pupin No.', targets: target++, data: 'pupin_no' },
          { title: 'Name', targets: target++, data: 'name' },
          { title: 'Father Name', targets: target++, data: 'father_name' },
          { title: 'Annual Income', targets: target++, data: 'annual_income' ,
            "render": function ( data, type, row, meta ) {
              return (row.adm_form ? row.adm_form.annual_income ? row.adm_form.annual_income:'' : '') ;
            }
          },
          { title: 'Relevant Category', targets: target++, data: 'loc_cat' },
          { title: 'Rural/Urban', targets: target++, data: 'geo_cat' },
          { title: 'Category', targets: target++, data: 'cat_id',
          "render": function ( data, type, row, meta ) {
            return (row.category ? row.category.name : '') ;
          }},
          { title: 'Reserved Category', targets: target++, data: 'resvcat_id',
          "render": function ( data, type, row, meta ) {
            return (row.res_category ? row.res_category.name : '') ;
          }},
          { title: 'Date Of Birth', targets: target++, data: 'dob' },
          { title: 'Gender', targets: target++, data: 'gender' },
          { title: 'Religion', targets: target++, data: 'religion' },
          { title: 'AAdhar No.', targets: target++, data: 'aadhar_no' },
          { title: 'Epic No.', targets: target++, data: 'epic_no' },
          { title: 'Blood Group', targets: target++, data: 'blood_grp' },
          { title: 'Mother Name', targets: target++, data: 'mother_name' },
          { title: 'Address', targets: target++, data: 'per_address',
          "render":function( data, type, row, meta){
               var  state = row.state ? row.state.state:''
              return data+','+row.city+','+state+','+row.pincode;
            } },
          { title: 'City', targets: target++, data: 'city' },
          { title: 'State', targets: target++, data: 'state_id',
            "render":function( data, type, row, meta){
              return row.state ? row.state.state:'';
            }
          },

          { title: 'Pin Code', targets: target++, data: 'pincode' },
          { title: 'Phone', targets: target++, data: 'father_phone' },
          { title: 'Mobile', targets: target++, data: 'mobile' },
          { title: 'Email', targets: target++, data: 'std_user' ,
            "render": function( data, type, row, meta ) {
              return (data ? data.email : '');
            }
          },
          { title: 'Last Exam', targets: target++, data: 'last_exam',
            "render": function ( data, type, row, meta ) {
              return (row.last_exam ? row.last_exam.exam : '') ;
            }},
          { title: 'University/Board Roll No', targets: target++, data: 'rollno',
          "render": function ( data, type, row, meta ) {
            return (row.last_exam ? row.last_exam.rollno : '') ;
          }},
          { title: 'Board', targets: target++, data: 'id' ,
          "render": function ( data, type, row, meta ) {
            return (row.last_exam && row.last_exam.board ? row.last_exam.board.name : '') ;
          }},
          { title: 'Result', targets: target++, data: 'result',
          "render": function ( data, type, row, meta ) {
            return (row.last_exam ? row.last_exam.result : '') ;
          }},
          { title: 'Year/Session', targets: target++, data: 'year',
          "render": function ( data, type, row, meta ) {
            return (row.last_exam ? row.last_exam.year : '') ;
          }},
          { title: 'Marks Obtained', targets: target++, data: 'marks_obtained',
          "render": function ( data, type, row, meta ) {
            return (row.last_exam ? row.last_exam.marks_obtained : '') ;
          }},
          { title: 'Category', targets: target++, data: 'cat_id',
          "render": function ( data, type, row, meta ) {
            return (row.category ? row.category.name : '') ;
          }},
          { title: 'Subjects', targets: target++, data: 'subjects',
            "render": function ( data, type, row, meta ) {
            return (row.last_exam ? row.last_exam.subjects : '') ;
          }},
         { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
 methods: {
    getData: function() {
        data = $.extend({}, {
          course_id: this.course_id,
          institution:this.institution,
          category:this.category
        })
        this.$http.get("{{ url('admregister') }}", {params: data})
          .then(function (response) {
            //      this.classes = response.data;
            //      console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (error) {
            console.log(error);
        });
      },
      
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop