@extends('app')

@section('toolbar')
	@include('toolbars._bill_receipt_toolbar')
@stop

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
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
  </div>
  {!! Form::close() !!}
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Students Subject Charges Detail</strong>
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
    //  institution:'',
      course_id: {{ $course->id or request("course_id",0) }},
   //   fund_type:'',
      table: null,
      url: "{{ url('/') . '/stdsubcharges/' }}",
      success: false,
      fails: false,
      errors: {},
      permissions: {!! json_encode(getPermissions()) !!},
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
          { title: 'Chargable Subjects', targets: 2, data: 'std_subs_charges',
          "render": function ( data, type, row, meta ) {
            var list = '';
            var sno = 1;
            if(data && data.length) {
              $.each(data, function(index, subs) {
                list += index+1+'. '+subs.subject.subject+'<br>'
                sno = index+1;
              });
            }
            if(row.std_hons_charges) {
              list += sno+'. '+row.std_hons_charges.subject;
            }
            return list;
          }},
          { title: 'Subjects Charged', targets:3, data: 'std_subs_charged',
          "render": function ( data, type, row, meta ) {
            var list = '';
            var sno = 1;
            if(data && data.length) {
              $.each(data, function(index, subs) {
                list += index+1+'. '+subs.subject.subject+'<br>'
                sno = index+1;
              });
            }
            if(row.std_hons_charged) {
              list += sno+'. '+row.std_hons_charged.subject;
            }
            return list;
          }},
          { title: '', targets: 4, data: 'id',
            "render": function( data, type, row, meta){
              // var str = '';
              if(type == 'export')
              return data;
                // if(self.permissions['ADD-SUBJECT-CHARGES']){
                return "<br><a href='#' data-row-index='"+meta.row+"' data-col-index='"+meta.col+"' data-std-id='"+row.id+"' class='btn btn-primary btn-xs charges-link'>Add Subject Charges</a>";
                // return str;
              // }
          }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
    computed: {
      hasErrors: function() {
        // console.log(this.errors && _.keys(this.errors).length > 0);
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
          
        this.$http.get("{{ url('stdsubcharges') }}/"+this.course_id)
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
      makeCharges: function(student_id, row, col) {
        this.errors = {};
        this.$http.post("{{ url('stdsubcharges') }}", { "student_id": student_id })
          .then(function (response) {
            if (response.data.success) {
              // console.log(response.data);
              // this.table.cell(row, col-1).data(response.data).draw(false);
              this.table.row(row).data(response.data.student).draw(false);
            }
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