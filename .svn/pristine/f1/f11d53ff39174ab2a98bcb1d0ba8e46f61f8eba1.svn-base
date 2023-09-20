@extends('app')

@section('content')
<div class="box box-default box-solid" id='app' v-cloak>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
  <div class="box-body">
    <div class="form-group">
      {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
    </div>
    <div class="form-group">
      {!! Form::label('inst_id','Installment',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-3">
        {!! Form::select('inst_id',getInstallment(),null,['class' => 'form-control','v-model'=>'inst_id']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::submit('Save',['class' => 'btn btn-primary', '@click.prevent' => 'saveData']) !!}
  </div>
  {!! Form::close() !!}
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Students Detail</strong>
  </div>
  <div class="panel-body">
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop

@section('script')
<script>
  $('#example1 tbody').on( 'click', 'td', function () {
    alert( table.cell( this ).data() );
  });
  
  $(document).on('click', '.charges-link', function(e) {
    e.preventDefault();
    var student_id = $(this).data('std-id');
    var row = $(this).data('row-index');
    var col = $(this).data('col-index');
    vm.makeCharges(student_id, row, col);
  });
  
  var vm = new Vue({
    el: '#app',
    data: {
      tData: [],
   //   institution:'',
      course_id: {{ $course->id or request("course_id",0) }},
      inst_id: {{ request("course_id",0) }},
   //   fund_type:'',
      table: null,
      url: "{{ url('/') . '/inst-debit/' }}",
      success: false,
      fails: false,
      errors: {},
    },
    created: function() {
      self = this;
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
          { title: 'Adm.No.', targets: 1, data: 'adm_no'},
          { title: 'Name', targets: 2, data: 'name'},
          { title: 'Father Name', targets: 2, data: 'father_name'},
          { title: 'Select', targets:3, data: 'id',
          "render": function ( data, type, row, meta ) {
            
            return '';
          }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
    computed: {
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
    },
    methods: {
      getData: function() {
        this.errors = {};
        this.fails = false;
          
        this.$http.get("{{ url('inst-debit') }}/"+this.course_id, { params: { 'inst_id': this.inst_id}})
          .then(function (response) {
            // this.classes = response.data;
            // console.log(response.data);
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      saveData: function() {
        this.errors = {};
        this.fails = false;
        var data = { course_id: this.course_id, inst_id: this.inst_id };
        this.$http.post("{{ url('inst-debit') }}", data)
          .then(function (response) {
            // this.classes = response.data;
            console.log(response.data);
            // this.tData = response.data;
            // this.reloadTable();
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      makeCharges: function(student_id) {
        this.errors = {};
        this.$http.post("{{ url('stdsubcharges') }}", { "student_id": student_id })
          .then(function (response) {
            console.log(response.data);
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
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