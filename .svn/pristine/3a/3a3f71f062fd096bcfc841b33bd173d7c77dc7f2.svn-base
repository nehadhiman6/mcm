@extends('app')
@section('toolbar')
@include('toolbars._message_toolbar')
@stop
@section('content')
<!--<div class="row">
  <a href="{{url('/adm-entries/create')}}">
    <button class="btn  btn-flat margin">
      <span>New Admission Entry</span>
    </button>
  </a>
</div>-->
<div class="box box-default box-solid " id='app'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::label('type','Staff Type',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      {!! Form::select('type',getStaffType(),null,['class' => 'form-control','v-model'=>'form.type']) !!}
    </div>
    {!! Form::label('source','Source',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      {!! Form::select('source',getStaffSource(),null,['class' => 'form-control','v-model'=>'form.source']) !!}
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::close() !!}
  </div>
  <div class='row'>
    <div class='col-sm-8'>
      <div class='panel panel-default' >
        <div class="panel-heading">
          <strong>Staff List</strong>
        </div>
        <div class = "panel-body">
          <table class="table table-bordered" id="example1" width="100%"></table>
        </div>
      </div>
    </div>
    @can('SEND-MESSAGES-STAFF')
      <div class='col-sm-4'>
        <div class="box box-default box-solid ">
          <div class="box-body">
            {!! Form::label('','Subject',['class' => 'col-sm-3 control-label ']) !!}
              <div class="col-sm-12">
                {!! Form::text('',null,['class' => 'form-control','v-model' => 'subject']) !!}
              </div>
          </div>
          <div class="box-body"> 
            {!! Form::label('','Message',['class' => 'col-sm-3 control-label ']) !!}
              <div class="col-sm-12">
                {!! Form::textarea('',null,['class' => 'form-control txt-area','size'=>'31x4','v-model' => 'msg']) !!}
              </div>
          </div>
          <div class="box-footer">
            {!! Form::submit('SEND',['class' => 'btn btn-primary','@click.prevent' => 'sendSms']) !!}
            {!! Form::submit('SEND to All',['class' => 'btn btn-primary','@click.prevent' => 'sendSmsAll']) !!}
            {!! Form::close() !!}
          </div>
        </div>
      </div>
    @endcan
  </div>
</div>
 
<!-- Button trigger modal -->

@stop
@section('script')
<script>
$(document).ready(function() {
  $('body').on('click', '.staff_id', function() {
    var idx;
    idx = _.indexOf(vm.staff_ids,$(this).val());
    if(idx == -1) {
        vm.staff_ids.push($(this).val());
    } else {
        vm.staff_ids.splice(idx,1);
    }
  });
});

var vm = new Vue({
    el: '#app',
    data: {
      form: {
            type: '',       
            source: '',       
          },
      staff_ids: [],
      tData: [],
      table: null,
      formOpen: true,
      msg: '',
      subject: '',
      createUrl: "{{ url('/') . '/staffmsg/' }}",
      success: false,
      fails: false,
      response: {},
      errors: {},
      show: false
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
            { title: 'Select', targets: 0, data: 'id',"width": "5%",
           'render': function (data, type, row, meta){
             console.log(row);
             return '<input type="checkbox" name="id[]" value="'+row.id+'" class="staff_id">';
            }},
            { title: 'Staff Name', targets: 1,
              'render': function (data, type, row, meta){
              var str ="";
              var mid = row.middle_name ? row.middle_name : '';
                str += row.name + ' ';
                str +=  mid + ' ';
                str += row.last_name ? row.last_name :'';

              return str;
            }},
            { title: 'Mobile', targets: 2, data: 'mobile'},
            { targets: '_all', visible: true }
          ],
          "sScrollX": true,
          'order': [[1, 'asc']]
        });
    },
    methods: {
       getData: function() {
        data = $.extend({}, {
          type: this.form.type,
          source:this.form.source,
        })
        this.$http.get("{{ url('staffmsg') }}", {params: data})
          .then(function (response) {
//            this.classes = response.data;
//            console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
      },
      sendSms: function() {
        data = $.extend({}, {
          msg: this.msg,
          subject:this.subject,
          staff_ids:this.staff_ids,
        })
        this.$http.post("{{ url('staffmsg') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            // console.log(response.data);
            this.staff_ids = [];
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
      },
      sendSmsAll: function() {
        data = $.extend({}, {
          msg: this.msg,
          type:this.form.type,
          source:this.form.source,
        })
        this.$http.post("{{ url('staffmsg/type') }}", data)
          .then(function (response) {
//            this.classes = response.data;
            // console.log(response.data);
            this.staff_ids = [];
            this.reloadTable();
          }, function (response) {
//            console.log(response.data);
        });
      },
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    },    
  });
</script>
@stop

 