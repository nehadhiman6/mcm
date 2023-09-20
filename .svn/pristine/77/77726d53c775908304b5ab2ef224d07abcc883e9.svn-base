@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
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
      {!! Form::label('category_id','Category',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('category_id',getCategory(),null,['class' => 'form-control category','v-model'=>'category_id']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
<div class="panel panel-default">
  <div class='panel-heading'>
  <span class="oveloaded-text-center"> <strong><span style="font-size:20px">CONSOLIDATED LIST OF @{{category_name}} STUDENTS FOR THE SESSION @{{session}} </span></br>
    NAME OF THE INSTITUTION/DEPARTMENT MCM DAV COLLEGE FOR WOMEN,SECTOR-36-A,CHANDIGARH</strong></span>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
</div>

@stop
@section('script')
<script>
 $(document).on('change', '.category ', function(e) {
   dashboard.category_name = $('.category option:selected').text();
});
var dashboard = new Vue({
el: '#app',
data: {
      tData: [],
      course_id: {{ $course->id or request("course_id",0) }},
      category_id: '',
      category_name: '',
      order: '',
      session: {!! json_encode(get_fy_label()) !!},
      table: null,
      url: "{{ url('/') . 'consolidated-students/' }}",
     },
    created: function() {
     this.setDatatable();
    },
 methods: {
     setDatatable(){
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
                messageTop: self.getTitle(),
                exportOptions: { orthogonal: 'export' },
                title: '',

            },{
                extend: 'pdf',
                messageTop: self.getTitle(),
                title: '',
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
          { title: 'Name', targets: target++, data: 'name' },
          { title: 'Class', targets: target++, data: 'course_name'},
          { title: 'Nationality', targets: target++, data: 'nationality'},
          { title: 'College Roll No.', targets: target++, data: 'roll_no' },
          { title: 'Contact No', targets: target++, data: 'mobile' },
         { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
     },
     getTitle(){
        var self = this;
        var str = 'CONSOLIDATED LIST OF ';
        str += ' ' +self.category_name  ; 
        str += ' STUDENTS FOR THE SESSION ' + this.session;
        str += ' .   NAME OF THE INSTITUTION/DEPARTMENT MCM DAV COLLEGE FOR WOMEN,SECTOR-36-A,CHANDIGARH';
        return str;
     },

    getData: function() {
        data = $.extend({}, {
          course_id: this.course_id,
          institution:this.institution,
          category_id:this.category_id
        })
        this.$http.get("{{ url('consolidated-student-list') }}", {params: data})
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
        this.table.destroy()
        this.table.clear();
        this.setDatatable();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop