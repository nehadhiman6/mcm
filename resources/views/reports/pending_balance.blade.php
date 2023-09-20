@extends('app')
@section('toolbar')
@include('toolbars._fees_reports_toolbar')
@stop
@section('content')
    <div id="app">
        <div class="box default box-solid">
            <div class="box-header with-border">
            Filter
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                    <i class="fa fa-minus"></i></button>
                </div>
            </div>
            <div class="box-body">
                {!! Form::open(['url'=>'', 'class' => 'form-horizontal']) !!}
            <!-- <div class="form-group">
                {!! Form::label('institution','Institution',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                {!! Form::select('institution',['sggs'=>'S.G.G.S', 'others'=>'Others'],request('institution'),['class' => 'form-control','v-model'=>'institution']) !!}
                </div>
            </div> -->
                <div class='form-group' v-show="institution == 'sggs' ">
                    {!! Form::label('course_id','Class',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                    {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
                    </div>
                    {!! Form::label('fund_type','Fund Type',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                    {!! Form::select('fund_type',[''=>'All','C'=>'College','H'=>'Hostel'],null,['class' => 'form-control','v-model' => 'fund_type']) !!}
                    </div>
                    <div class="col-sm-2">
                    {!! Form::submit('SHOW',['class' => 'btn btn-primary box-footer', '@click.prevent' => 'getData']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('text_area','Content',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        {{ Form::textarea('text_area', null, ['id'=>'textarea','rows' => 4, 'cols' => 31]) }}
                        <p id="count"></p>
                        <span style="color: #f10909;">If more than 160 characters then it will be sent in another SMS.</span>
                    </div>
                    <div class="col-sm-2">
                    {!! Form::submit('SEND SMS',['class' => 'btn btn-primary box-footer']) !!}
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>List of Students having pending balance</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered" id="example1" width="100%">
                <tfoot><th></th><th></th><th></th><th></th><th></th><th></th><th>Total:</th><th></th><th></th></tfoot>
            </table>
        </div>
    </div>
@stop
@section('script')
<script>
    $("#textarea").keyup(function(){
        $("#count").text("Characters Count: " + $(this).val().length);
    });
</script>
<script>
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData: [],
      course_id: {{ $course->id or request("course_id",0) }},
      fund_type: '',
      upto_date: '',
      institution: 'sggs',
      table: null,
      url: "{{ url('/') . 'pendbalance/' }}",
    },
    
    created: function() {
      self = this;
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
          { title: 'S.No.', targets: 0, data: 'id',
            "render": function( data, type, row, meta) {
              return meta.row + 1;
            }},
          { title: 'Adm.No.', targets: 1, data: 'adm_no' },
          { title: 'Roll No.', targets: 2, data: 'roll_no' },
          { title: 'Name', targets: 3, data: 'name'},
          { title: 'Father Name', targets: 4, data: 'father_name' },
          { title: 'Mobile', targets: 5, data: 'mobile' },
          { title: 'Course', targets: 6, data: 'course_id',
            "render": function ( data, type, row, meta ) {
              return data ? row.course.course_name : row.course_name ;
            }},
          { title: 'Amount', targets: 7, data: 'bal_amt' },
          { title: 'Remarks', targets: 8, data: 'remarks',
            "render": function ( data, type, row, meta ) {
              return '';
            }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
        "footerCallback": function (row, data, start, end, display) {
          var api = this.api();
          var colNumber = [4];
                   
          // Remove the formatting to get integer data for summation
          var intVal = function (i) {
              return typeof i === 'string' ? 
                  i.replace(/[\$,]/g, '') * 1 :
                  typeof i === 'number' ?
                  i : 0;
          };

//          for (i = 0; i < colNumber.length; i++) {
//              var colNo = colNumber[i];
//              var total2 = api
//                      .column(colNo)
//                      .data()
//                      .reduce(function (a, b) {
//                          return intVal(a) + intVal(b);
//                      }, 0);
//          }
          var tot = 0.00;
          $.each(self.tData, function(index, row){
//            $.each(row.fee_bills, function(index, fee_bill){
              tot += intVal(row.bal_amt);
//            });
          });
          $(api.column(7).footer()).html(tot);
          
        }
      });
    },
    
    methods: {
      getData: function() {
        data = $.extend({}, {
          course_id: this.course_id,
          institution: this.institution,
          fund_type: this.fund_type
        })
        this.$http.get("{{ url('pendbalance') }}", {params: data})
          .then(function (response) {
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
        });
      },
      reloadTable: function() {
        console.log('here');
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  });

  $('#class_ids').on('change',function(){
    dashboard['class_ids'] = $(this).val();
  });
</script>
@stop
