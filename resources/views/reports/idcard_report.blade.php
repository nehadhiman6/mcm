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
      <div class="col-sm-3">
        {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
      </div>
      {!! Form::label('having_card','Students',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('having_card',['Y'=>'Having Card','N'=>'Not Having Card'],null,['class' => 'form-control','v-model'=>'having_card']) !!}
      </div>
    </div>
    <div class="form-group" v-show="having_card == 'Y'">
      {!! Form::label('from_card_no','From Card No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('from_card_no',null,['class' => 'form-control','v-model'=>'from_card_no']) !!}
      </div>
      {!! Form::label('to_card_no','To Card No.',['class' => 'col-sm-2 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('to_card_no',null,['class' => 'form-control','v-model'=>'to_card_no']) !!}
      </div>
    </div>
  </div>
  <div class="box-footer">
    {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
    {!! Form::submit('EXCEL',['class' => 'btn btn-primary', '@click.prevent' => 'getExcel']) !!}
    @can('GEN-IDCARD-NO')
      {!! Form::submit('Generate card No',['class' => 'btn btn-primary', '@click.prevent' => 'generateCardNo']) !!}
    @endcan
    {!! Form::close() !!}
  </div>
  <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
    <li v-for='error in errors'>@{{ error[0] }}<li>
  </ul>
</div>
<div class="panel panel-default">
  <div class='panel-heading'>
    <strong>Reports for ID card</strong>
  </div>
  <div class="panel-body">
     <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
<div id="excel-box"></div>
@stop
@section('script')
<script>
  $(function() {
    $(document).on('click', '.show-file', (function() {
      dashboard.showImage($(this).data('adm-id'), $(this).data('file-type'));
    }));
  });
  var buttonCommon = {
    exportOptions: {
      format: {
        body: function ( data, row, column, node ) {
          // Strip $ from salary column to make it numeric
          return column === 5 ?
            " "+data :
            data;
        }
      }
    }
  };
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData: [],
      course_id: {{ $course->id or request("course_id",0) }},
      having_card: 'Y',
      from_card_no: '',
      to_card_no: '',
      table: null,
      success: false,
      fails: false,
      errors: {},
      url: "{{ url('/') }}/attachment/",
      attachUrl: "{{ url('attachment').'/' }}",
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
          { title: 'Card No.', targets: 1, data: 'card_no'},
          { title: 'Online Form No.', targets: 2, data: 'admission_id'},
          { title: 'Name', targets: 3, data: 'name'},
          { title: 'Father Name', targets: 4, data: 'father_name' },
          { title: 'Course', targets: 5, data: 'course_name'},
          { title: 'Roll No', targets: 6, data: 'roll_no'},
          { title: 'Admission No', targets: 7, data: 'adm_no'},
          { title: 'Contact No', targets: 8, data: 'mobile'},
          { title: 'Blood Group', targets: 9, data: 'blood_grp'},
          { title: 'Father Mobile', targets: 10, data: 'father_mobile' },
          { title: 'Mother Mobile', targets: 11, data: 'mother_mobile' },
          { title: 'Address', targets: 12, data: 'per_address',
            "render": function( data, type, row, meta) {
              return ( row.per_address ? row.per_address+(row.city ? ', '+row.city : '') : '') ;
          }},
          { title: 'Signature', targets: 13, data: 'admission_id',
            "render": function( data, type, row, meta) {
              var obj = null;
              if(row.attachments.length > 0) 
                obj = _.findWhere(row.attachments,{file_type: 'signature'});
              if(obj) {
                return '<a href="#" class="show-file" data-adm-id="'+data+'" data-file-type="signature">Download</a><br>';
                return 'Attached';
                return  '<img width="50%" src="'+self.url+data+'/signature" />';
              }
              return '';
          }},
          { title: 'Photograph', targets: 14, data: 'admission_id',
            "render": function( data, type, row, meta) {
              var obj = null;
              if(row.attachments.length > 0)
                obj = _.findWhere(row.attachments,{file_type: 'photograph'});
              if(obj) {
                return '<a href="#" class="show-file" data-adm-id="'+data+'" data-file-type="photograph">Download</a><br>';
                return 'Attached';
                return  '<img width="50%" src="'+self.url+data+'/photograph" />';
              }
              return '';
          }},
          { title: 'Photo File Name', targets: 15, data: 'roll_no',
            render: function(data, type, row, meta) {
              return 'P178'+data+'.jpg';
            }},
          { title: 'Signature File Name', targets: 16, data: 'roll_no',
            render: function(data, type, row, meta) {
              return 'S178'+data+'.jpg';
            }},
          { targets: '_all', visible: true }
        ],
  //      "deferRender": true,
        "sScrollX": true,
      });
    },
    methods: {
      getData: function() {
        this.errors = {};
        this.fails = false;
        var data = {
          course_id: this.course_id,
          having_card: this.having_card,
          from_card_no: this.from_card_no,
          to_card_no: this.to_card_no,
          excel: 'N'
        };
        this.$http.get("{{ url('idcard-report') }}", {params: data})
          .then(function (response) {
            this.tData = response.data;
            this.reloadTable();
          }, function (response) {
            this.fails = true;
            this.errors = response.data;
        });
      },
      getExcel: function() {
        $('#excel-box').html('');
        $('#excel-box').append('<form id="excel-form" action=\'{{ url("idcard-report") }}\' method="GET" target="_blank">');
        $('#excel-form').append('<input type="hidden" name="course_id" value="' + this.course_id + '">')
            .append('<input type="hidden" name="excel" value="Y">')
            .submit();
        
      },
      generateCardNo: function(){
        console.log('here');
        this.errors = {};
        this.fails = false;
        var data = {
          course_id: this.course_id,
          having_card: this.having_card,
          from_card_no: this.from_card_no,
          to_card_no: this.to_card_no,
        };
        this.$http.get("{{ url('idcard/generate') }}", {params: data})
          .then(function (response) {
            self = this;
            if (response.data.success) {
              self = this;
              this.success = true;
              setTimeout(function() {
                self.success = false;
              }, 3000);
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              this.errors = response.data;
            }              
          });
      },
      showImage: function(form_id, file_type) {
        self = this;
        window.open(
            this.attachUrl+form_id+'/'+file_type,
            '_blank'
          );
        return;
      },
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
      
      reloadTable: function() {
        this.table.clear();
        this.table.rows.add(this.tData).draw();
      }
    }
  
  });
</script>
@stop
