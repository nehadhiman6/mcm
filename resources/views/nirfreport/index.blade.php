@extends('app')

@section('toolbar')
  {{-- @include('toolbars.') --}}
@stop

@section('content')
    <div class="box box-default box-solid collapsed-box" id='filter'>
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
                {!! Form::label('course_type','Course Type',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('course_type',[''=>'All', 'UG'=>'UG', 'PG'=>'PG'],request('course_type'),['class' => 'form-control', 'v-model'=>'course_type','@change'=>'onCourseChange()']) !!}
                </div>
                {!! Form::label('period ','Period ',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('period ',[''=>'Select', '1'=>'1', '2'=>'2', '3'=>'3'],request('period'),['class' => 'form-control', 'v-model'=>'period']) !!}
                </div>
                {!! Form::label('financial_year ','Final Year',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('financial_year ',['' => 'Select', '2017-18'=>'2017-18', '2018-19'=>'2018-19', '2019-20'=>'2019-20'],request('financial_year'),['class' => 'form-control', 'v-model'=>'financial_year']) !!}
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
    <strong>NIRF UG/PG Strength Report</strong>
  </div>
  <div class='panel-body'>
    <table class="table table-bordered" id="example1" width="100%"></table>
  </div>
</div>
@stop
@section('script')
<script>
    var dashboard = new Vue({
        el: '#filter',
        data: {
            course_type : '',
            period : '',
            financial_year : '',
            permissions: {!! json_encode(getPermissions()) !!},
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
                { title: 'Male', targets: 1, data: '' },
                { title: 'Female', targets: 2, data: '' },
                { title: 'Total Stu.', targets: 3, data: '' },
                { title: 'Within State', targets: 4, data: '' },
                { title: 'Outside State', targets: 5, data: '' },
                { title: 'Outside Country', targets: 6, data: '' },
                { title: 'EWS', targets: 7, data: '' },
                { title: 'SC/ST/OBC', targets: 8, data: '' },
                { title: 'Full Tution Fee relaxation from Govt', targets: 9, data: '' },
                { title: 'Full Tution Fee relaxation from Institute', targets: 10, data: '' },
                { title: 'Full Tution Fee relaxation from other private Bodies', targets: 11, data: '' },
                { title: 'No full tution fee relaxation', targets: 12, data: '' },
                { targets: '_all', visible: true }
            ],
            "sScrollX": true,
            });
        },

        methods: {
            onCourseChange: function() {
                var self = this;
                if(self.course_type == 'UG') {
                    self.period = 3;
                }
                else if(self.course_type == 'PG'){
                    $('select[name*="period"] option[value="3"]').hide();
                    self.period = ''
                }else{
                    self.period = '';
                    // $('select[name*="period"] option[value="3"]').show();
                }
            },
        }
    });
</script>
@stop