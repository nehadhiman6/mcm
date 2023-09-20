@extends('app')
@section('toolbar')
@include('toolbars._reports_toolbar')
@stop
@section('content')
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
                {!! Form::label('date','Date',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('date',request('date',today()),['class' => 'form-control app-datepicker', 'v-model'=>'date']) !!}
                </div>
                {!! Form::label('date_by','By',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::select('date_by',['created_at'=>'Created Date', 'updated_at'=>'Updated Date'],'created',['class' => 'form-control', 'v-model'=>'date_by']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('admission_id','Admission Form No.',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('admission_id',null,['class' => 'form-control', 'v-model'=>'admission_id']) !!}
                </div>
                {!! Form::label('roll_no','Roll no',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                        {!! Form::text('roll_no',null,['class' => 'form-control', 'v-model'=>'roll_no']) !!}
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
            <strong>Payments</strong>
        </div>
        <div class='panel-body'>
            <table class="table table-bordered" id="payments" width="100%"></table>
        </div>
    </div>
@stop
@section('script')
<script>
    $(function() {
        $(document).on('click', '.show-file', (function() {
            dashboard.showImage($(this).data('adm-id'), $(this).data('file-type'));
        }));
    });
    var dashboard = new Vue({
        el: '#filter',
        data: {
            tData: [],
            admission_id:'',
            roll_no:'',
            date_by:'created_at',
            // date:'{{today()}}',
            date:'{{today()}}',
            
            createUrl:"{{url('/')}}"
           
        },
        created: function() {
            var self = this;
            var target = 0;
            this.table = $('#payments').DataTable({
                dom: 'Bfrtip',
                ordering:        true,
                scrollY:        "300px",
                scrollX:        true,
                scrollCollapse: true,
                pageLength:    "10",
                paging:         true,
                fixedColumns:   {
                    rightColumns: 1,
                    leftColumns: 0
                },
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
                            return meta.row + 1;
                        }
                    },
                    { title: 'Name', targets: target++, data: 'name' ,
                    },
                    { title: 'Transaction Code', targets: target++, data: 'trcd' ,
                    },
                    { title: 'Transaction Type', targets: target++, data: 'trn_type' ,
                    },
                    { title: 'Transation Date', targets: target++, data: 'trdate1' ,
                    },
                    { title: 'Transaction Time', targets: target++, data: 'trntime' ,
                    },
                    { title: 'Admission No.', targets: target++, data: 'admission_id' ,
                    },
                    { title: 'Roll No.', targets: target++, data: 'roll_no' ,
                    },
                    { title: 'Status', targets: target++, data: 'ourstatus' ,
                    },
                    { title: 'Amount', targets: target++, data: 'amt' ,
                    },
                    { title: 'Gateway', targets: target++, data: 'through' ,
                    },
                    { title: 'Message', targets: target++, data: 'message' ,
                    },
                ],
                "sScrollX": true,
            });
            this.getData();
        },
    methods: {
        reloadTable: function() {
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },
        getData: function() {
            data = $.extend({}, {
                admission_id: this.admission_id,
                roll_no: this.roll_no,
                date: this.date,
                date_by: this.date_by,
            })
            this.$http.get("{{ url('admission-form/payments') }}", {params: data})
                .then(function (response) {
                    this.tData = response.data;
                    this.reloadTable();
                }, function (response) {
            });
        },
    }
  }); 
</script>
@stop