@extends('app')

@section('toolbar')
  @include('toolbars._academics_toolbar')
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
    {!! Form::open(['method' => 'GET',  'action' => ['Reports\StdStrengthController@subStdStrength'], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
      </div>
        {!! Form::label('course_id','Course',['class' => 'col-sm-1 control-label ']) !!}
      <div class="col-sm-3">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control selectCourse','v-model' => 'course_id']) !!}
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary','@click.prevent'=>'getData()']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Student Strength(Subjectwise)
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%">
      <tfoot><th></th><th>Total:</th><th></th></tfoot>
    </table>
  </div>
</div>
</div>
<div id="subject-box"></div>
@stop
@section('script')
<script>
  $(document).on('click','.sections-link',function(e) {
    e.preventDefault();
    $('#subject-box').html('');
    $('#subject-box').append('<form id="subject-form" action=\'{{ url("secallot") }}\' method="GET" target="_blank">');
    $('#subject-form').append('<input type="hidden" name="subject_id" value="' + $(this).data('subject-id') + '">')
    $('#subject-form').append('<input type="hidden" name="subject" value="' + $(this).data('subject-name') + '">')
      .append('<input type="hidden" name="course_id" value="' + dashboard.course_id + '">')
      .submit();
  });

  $(document).on('click','.teachers-link',function(e) {
    e.preventDefault();
    $('#subject-box').html('');
    $('#subject-box').append('<form id="subject-form" action=\'{{ url("secallocations") }}\' method="GET" target="_blank">');
    $('#subject-form').append('<input type="hidden" name="subject_id" value="' + $(this).data('subject-id') + '">')
    $('#subject-form').append('<input type="hidden" name="subject" value="' + $(this).data('subject-name') + '">')
      .append('<input type="hidden" name="course_id" value="' + dashboard.course_id + '">')
      .submit();
  });
  
var dashboard = new Vue({
  el: '#app',
  data: {
      tData: [],
      upto_date: '',
      course_id: '',
      table: null,
      permissions: {!! json_encode(getPermissions()) !!},
    },
  created: function() {
      var self = this;
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
          { title: 'Subjects', targets: 1, data: 'subject'},
          { title: 'Admissions', targets: 2, data: 'students' },
          { title: '', targets: 3, data: 'subject',
             "render": function( data, type, row, meta) {
              var str = '';
              if(self.permissions['SECTIONS-SWSS']){
                str += "<button class='btn btn-primary btn-xs sections-link' data-subject-name='"+row.subject+"' data-subject-id='"+row.subject_id+"' >Sections</button>";
              }
              if(self.permissions['TEACHERS-SWSS']){
                str += "<button class='btn btn-primary btn-xs teachers-link' data-subject-name='"+row.subject+"' data-subject-id='"+row.subject_id+"' >Teachers</button>";
              }
              return str;
          }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [2];
                   
          // Remove the formatting to get integer data for summation
          var intVal = function (i) {
              return typeof i === 'string' ? 
                  i.replace(/[\$,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
          };

          for (i = 0; i < colNumber.length; i++) {
              var colNo = colNumber[i];
//              console.log(colNo);
              var total2 = api
                      .column(colNo)
                      .data()
                      .reduce(function (a, b) {
                          return intVal(a) + intVal(b);
                      }, 0);
              $(api.column(colNo).footer()).html(total2);
          }
        }
      });


      $('.selectCourse').select2({
          placeholder: 'Select Course',
          width:'100%'
      });
      $('.selectCourse').on('change',function(){
          self.course_id = $(this).val();
      });
  },
  methods: {
    getData: function() {
        data = {
          upto_date: this.upto_date,
          course_id: this.course_id,
        };
        this.$http.get("{{ url('stdsublist') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
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