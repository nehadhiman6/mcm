@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div class="box box-default box-solid" id='app' v-cloak>
    <div class="box-header with-border">
        Hostel Allocation
        <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
            <i class="fa fa-minus"></i></button>
        </div>
    </div>
    <div class="box-body">
        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
        <div class="form-group">
            {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-2">
            {!! Form::text('from_date',startDate(),['class' => 'form-control app-datepicker', 'v-model' => 'from_date']) !!}
            </div>
            {!! Form::label('upto_date','To Date',['class' => 'col-sm-1 control-label']) !!}
            <div class="col-sm-2">
            {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
            </div>
            {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
        <div class="col-sm-3">
            {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id']) !!}
        </div>
        
        </div>
        <div class="form-group">
            {!! Form::label('block_id','Block ',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-2">
                {!! Form::select('block_id',getBlocks(),null, ['class' => 'form-control',':disabled' => 'tData.length > 0','v-model'=>'block_id','@change'=>'changeBlock']) !!}
            </div>
            {!! Form::label('location_id', 'Room', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-4" v-bind:class="{ 'has-error': errors['location_id'] }">
                <select class="form-control selectLocation" v-model="location_id">
                    <option value="0">Select</option>
                    <option v-for="loc in locations" :value="loc.id">@{{ loc.location }}</option>
                </select>
                <span id="basic-msg" v-if="errors['location_id']" class="help-block">@{{ errors['location_id'][0] }}</span>
            </div>
        </div>
    </div>
    <div class="box-footer">
        
        {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
        {!! Form::submit('SAVE',['class' => 'btn btn-primary', '@click.prevent' => 'saveData']) !!}
        {!! Form::close() !!}
    </div>
    <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
        <li v-for='error in errors'>@{{ error[0] }}<li>
    </ul>
</div>
<div class="panel panel-default">
    <div class='panel-heading'>
        <strong>Hostel Allocation Students List</strong>
    </div>
    <div class="panel-body">
        <table class="table table-bordered" id="example1" width="100%"></table>
    </div>
</div>
@stop
@section('script')
<script>
   var dashboard = new Vue({
    el: '#app',
    data: {
        tData: [],
		block_id:0,
        course_id: {{ $course->id or request("course_id",0) }},
        from_date: '',
        upto_date: '',
        table: null,
        success: false,
        fails: false,
        errors: {},
        location_id:0,
        locations:[]
    },

    ready: function() {
        var self = this;
        $('.selectLocation').select2({
            placeholder: 'Select Location'
        });
        $('.selectLocation').on('change',function(){
            self.location_id = $(this).val();
        });    
    },

    created: function() {
        var self = this;
        // this.getLocations();
        $(document).on('click', '.status-change', function(e) {
            self.changeStatus(e.target.dataset.itemId,e);
        });
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
            { title: 'Adm.No.', targets: 1, data: 'adm_no'},
            { title: 'Course', targets: 2, data: 'course_name'},
            { title: 'Name', targets: 3, data: 'name'},
            { title: 'Father Name', targets: 4, data: 'father_name'},
            { title: 'Roll No.', targets: 5, data: 'roll_no'},
            { title: 'selection', targets: 6 ,
                "render":function(data,type,row,meta){
                    if(row.checked == true){
                        return "<input type='checkbox' checked class='status-change' data-item-id ="+meta.row+">";
                    }
                    return "<input type='checkbox' class='status-change' data-item-id ="+meta.row+">";
                }
            },
            { targets: '_all', visible: true }
            ],
            "sScrollX": true,
        });
        
    },
    methods: {      
        changeBlock:function(){
            var self= this;
            self.locations = [];
            this.$http.post("{{ url('hostel-attendance/block-location') }}", {'block_id': self.block_id})
            .then(function (response) {
                self.locations = response.data.locations;
            }, function (response) {
                this.fails = true;
                this.errors = response.data;
            });
        },

        getData: function() {
            var self = this;
            this.errors = {};
            this.fails = false;
            data = $.extend({}, {
                course_id: this.course_id,
                from_date: this.from_date,
                upto_date: this.upto_date
            })
            this.$http.get("{{ url('hostels-allocation') }}", {params: data})
            .then(function (response) {
                this.tData = response.data;
                self.tData.forEach(element => {
                    element['checked'] = false;
                });
                self.reloadTable();
            }, function (response) {
                this.fails = true;
                    this.errors = response.data;
            });
        },
        hasErrors: function() {
            if(this.errors && _.keys(this.errors).length > 0)
            return true;
            else
            return false;
        },
        
        reloadTable: function() {
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },

        getLocations:function(){
            var self= this;
            // console.log(response.data.locations);
            self.locations = '';
            this.$http.get("{{ url('hostels-locations') }}")
            .then(function (response) {
                console.log(response.data.locations);
                self.locations = response.data.locations;
            }, function (response) {
                this.fails = true;
                this.errors = response.data;
            });
        },

        changeStatus:function(index,event){
            this.tData[index].checked = event.target.checked;
        },
        
        saveData:function(){
            var self = this;
            this.$http.post("{{ url('hostels-allocation') }}",{'data':self.tData,'location_id':self.location_id})
            .then(function(response){
                console.log(response);
                if(response)
                $.blockUI({'message' : '<h3>Success! Rooms has been allocated.</h3>'})
                    setTimeout(() => {
                    $.unblockUI();
                    self.getData();
                    setTimeout(() => {
                        self.reloadTable();
                    }, 1000);
                }, 2000);

            })
            .catch(function(response){
                this.fails = true;
                this.errors = response.data;
            })
        }
    }
  
  });
</script>
@stop