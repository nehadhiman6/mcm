@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div id="app" v-cloak>
<div class="box box-default box-solid">
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
            {!! Form::select('course_id',getCourses(),null,['class' => 'form-control select2courses','v-model'=>'course_id']) !!}
        </div>
        
        </div>
        <div class="form-group">
            {!! Form::label('location_id', 'Room', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6" v-bind:class="{ 'has-error': errors['location_id'] }">
                <select class="form-control select2locations" v-model="location_id">
                    <option value="0">Select</option>
                    <option v-for="loc in locations" :value="loc.id">@{{ loc.location }}</option>
                </select>
                <span id="basic-msg" v-if="errors['location_id']" class="help-block">@{{ errors['location_id'][0] }}</span>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getData']) !!}
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
    <div id="changeRoomModal" class="modal fade tttt" role="dialog">
        <div class="modal-dialog form-horizontal" >
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Change Student Room</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {!! Form::label('name','Student Name',['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                        {!! Form::text('name',null,['class' => 'form-control', 'v-model' => 'selected_student.name' ,'readOnly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('roll_no','Roll  No.',['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8">
                        {!! Form::text('roll_no',null,['class' => 'form-control', 'v-model' => 'selected_student.roll_no' ,'readOnly']) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('roll_no','Room  No.',['class' => 'col-sm-4 control-label']) !!}
                        <div class="col-sm-8" v-bind:class="{ 'has-error': errors['hostel_room_id'] }">
                            <select class="form-control selectLocation" v-model="selected_student.hostel_room_id">
                                <option value="0">Select</option>
                                <option v-for="loc in locations" :value="loc.id">@{{ loc.location }}</option>
                            </select>
                            <span id="basic-msg" v-if="errors['hostel_room_id']" class="help-block">@{{ errors['hostel_room_id'][0] }}</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                     {!! Form::submit('SAVE',['class' => 'btn btn-primary', '@click.prevent' => 'saveData']) !!}
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        
        </div>
    </div>
</div>    
@stop
@section('script')
<script>
   var dashboard = new Vue({
    el: '#app',
    data: {
        tData: [],
        course_id: {{ $course->id or request("course_id",0) }},
        from_date: '',
        upto_date: '',
        table: null,
        success: false,
        fails: false,
        errors: {},
        location_id:0,
        locations:[],
        studentIndex:0,
        selected_student:{}
    },

    ready: function() {
        var self = this;
        $('.select2courses').select2({
            placeholder: 'Select Location'
        });
        $('.select2courses').on('change',function(){
            self.course_id = $(this).val();
        });
        $('.select2locations').select2({
            placeholder: 'Select Location'
        });
        $('.select2locations').on('change',function(){
            self.location_id = $(this).val();
        });
    },

    created: function() {
        var self = this;
        this.getLocations();
        $(document).on('click', '.change-room', function(e) {
            self.changeRoom(e.target.dataset.itemId,e);
        });
        $('#changeRoomModal').on('hidden.bs.modal', function() {
            console.log("hidden");
            self.studentIndex = 0;
            self.selected_student = {};
            self.reloadTable();
        });
        this.setTable();
    },
    methods: {
        setTable:function(){
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
                { title: 'Location', targets: 6,
                    "render":function(data,type,row,meta){
                        return row.hostel_location ? row.hostel_location.location :'';
                    }
                },
                { title: 'Action', targets: 7 ,
                    "render":function(data,type,row,meta){
                        return "<button class='btn btn-primary btn-sm change-room' data-item-id ="+meta.row+">Change</button>";
                    
                    }
                },
                { targets: '_all', visible: true }
                ],
                "sScrollX": true,
            });
        },

        getData: function() {
            var self = this;
            this.errors = {};
            this.fails = false;
            data = $.extend({}, {
                course_id: this.course_id,
                from_date: this.from_date,
                upto_date: this.upto_date,
                location_id :this.location_id
            })
            this.$http.get("{{ url('hostels-allocation/students') }}", {params: data})
            .then(function (response) {
                this.tData = response.data;
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
            this.$http.get("{{ url('hostels-locations') }}")
                .then(function (response) {
                    self.locations = response.data.locations;   
                }, function (response) {
                    this.fails = true;
                    this.errors = response.data;
            });
        },

        saveData:function(){
            var self = this;
            this.$http.post("{{ url('hostels-allocation/change') }}",{'student':self.selected_student})
            .then(function(response){
                if(response)
                $.blockUI({'message' : '<h3>Success! Room has been allocated.</h3>'})
                    setTimeout(() => {
                    self.getData();
                    setTimeout(() => {
                        self.reloadTable();
                        $('#changeRoomModal').modal('hide');
                        $.unblockUI();
                    }, 500);
                }, 2000);

            })
            .catch(function(response){
                this.fails = true;
                this.errors = response.data;
                $.unblockUI();
                $('#changeRoomModal').modal('hide');
            })
        },

        changeRoom:function(index){
            this.selected_student = this.tData[index] ;
            this.studentIndex = index;
            setTimeout(() => {
                $('#changeRoomModal').modal('show');
            }, 100);
        }
    }
  
  });
</script>
@stop