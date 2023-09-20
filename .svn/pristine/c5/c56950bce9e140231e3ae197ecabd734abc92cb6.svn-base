@extends($dashboard)
@section('toolbar')
@include('toolbars._admentry_toolbar')
@stop
@section('content')
<!--<div class="row">
  <a href="{{url('/adm-entries/create')}}">
    <button class="btn  btn-flat margin">
      <span>New Admission Entry</span>
    </button>
  </a>
</div>-->
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
      {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('from_date',request('from_date',today()),['class' => 'form-control app-datepicker', 'v-model'=>'from_date']) !!}
      </div>
      {!! Form::label('upto_date','To Date',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',request('upto_date',today()),['class' => 'form-control app-datepicker', 'v-model'=>'upto_date']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('course_id','Course',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('course_id',getCourses(true),request('course_id'), ['class' => 'form-control', 'v-model' => 'course_id']) !!}
      </div>
      {!! Form::label('status','Status',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('status',[''=>'All', 'A'=>'Admitted', 'N'=>'Not-Admitted'],request('status'),['class' => 'form-control', 'v-model'=>'status']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
</div>
<div class="panel panel-default" id='app'>
  <div class="panel-heading">
    <strong>Admission Entries</strong>
  </div>
  <div class = "panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
<!-- Button trigger modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Update Your Email</h4>
      </div>
      <div class="modal-body">
        {!! Form::open(['url' => '' ,'method' => 'patch' , 'class' => 'form-horizontal','id'=>'notify']) !!}
        <div class="form-group">
          <label for="email" class="col-sm-3 control-label">Enter Email:</label>
          <div class="col-sm-5">
            <input type="text" class="form-control" name='email'>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Update</button>
        {!! Form::close() !!}
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
//$(function() {
//    $(document).on('click', '.show-file', (function() {
//      dashboard.showImage($(this).data('id'), $(this).data('email'));
//    }));
//  });
 var dashboard = new Vue({
    el: '#filter',
    data: {
      permissions: {!! json_encode(getPermissions()) !!},
        tData: [],
        from_date: '',
        upto_date: '',
        status: '',
        course_id: {{ $course->id or request("course_id",0) }},
        table: null,
        url: "{{ url('/') . '/adm-entries/' }}",
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
                  exportOptions: { orthogonal: 'export' }
              },
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: [
            { title: 'S.No.', targets: target++, data: 'id',
            "render": function( data, type, row, meta) {
              if(type == 'export')
                return meta.row + 1;
              var str = '';
              if(self.permissions['EDIT-ADMISSION-ENTRY']){
                str +=  data + "<br><a href='" + self.url + row.id + "/printslip'" + " class='btn btn-primary btn-xs' target = _blank>Print Slip</a><br><a href='" + self.url + row.id + "/edit'" + " class='btn btn-primary btn-xs'>Edit</a>";
              }
              return str;
            }},
            { title: 'Online Form No', targets: target++, data: 'admission_id'},
            { title: 'Manual Form No', targets: target++, data: 'manual_formno'},
            { title: 'DHE No', targets: target++, data: 'dhe_form_no'},
            { title: 'Cent.Rec.No./Date', targets: target++, data: 'centralized',
            "render": function( data, type, row, meta) {
              if(row.centralized == 'Y'){
                return row.adm_rec_no + ' / ' + row.rcpt_date;
              }else
                return '';
            }},
            { title: 'Roll No.', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.adm_form ? row.adm_form.lastyr_rollno : '') ;
             }},
            { title: 'Name', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.adm_form ? row.adm_form.name : '') ;
             }},
            { title: 'Course', targets: target++, data: 'course_id',
              "render": function ( data, type, row, meta ) {
               return (row.adm_form ? row.adm_form.course.course_name : '') ;
             }},
            { title: 'Father Name', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.adm_form ? row.adm_form.father_name : '') ;
             }},
            { title: 'Mobile', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               return (row.adm_form ? row.adm_form.mobile : '') ;
             }},
            { title: 'Email', targets: target++, data: 'adm_form',
            "render": function ( data, type, row, meta ) {
              var str = '';
              // if(data && row.adm_form.std_user) {
              //   s = row.adm_form.std_user.email;
              //   s += "<br><a href='" + self.url + row.adm_form.std_user.id + "/editemail'" + " class='btn btn-primary btn-xs' target = _blank>Change Email</a>";
              // }
              // return s;
              if(self.permissions['EMAIL-ADMISSION-ENTRY']){
                str += data && row.adm_form.std_user  
                  ? row.adm_form.std_user.email + "<br><a href='" + self.url + row.adm_form.std_user.id + "/editemail'" + " class='btn btn-primary btn-xs' target = _blank>Change Email</a>"
                  : '';
              }
              else{
                str += data && row.adm_form.std_user  ? row.adm_form.std_user.email : '';
              }
              return str;
            }},
            { title: 'Status', targets: target++, data: 'admission_id',
              "render": function ( data, type, row, meta ) {
               if(row.adm_form && row.adm_form.status == 'A'){
                  return 'ADMITTED '+(row.bal_amt ? '<br>Bal: '+row.bal_amt : '');
                }
                else if(row.adm_form && row.adm_form.status == 'C'){
                  return 'CANCELLED';}
                else{
                  return 'NOT ADMITTED';
                }
            }},
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
        });
    },
    methods: {
      getData: function() {
          data = $.extend({}, {
            from_date: this.from_date,
            upto_date: this.upto_date,
            status: this.status,
            course_id: this.course_id,
          })
          this.$http.get("{{ url('adm-entries') }}", {params: data})
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
    }
  }); 
  
  var vm = new Vue({
    el: '#app',
    methods: {
      showForm: function() {
        console.log('here');
      }
    }
  });
</script>
@stop