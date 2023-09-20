@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div id= "app" v-cloak>
	<div class="box box-default box-solid" >
		<div class="box-header with-border">
			<span v-if="form.id > 0"> Edit </span> <span v-if="form.id == 0"> Add </span>Out Entry
			<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
				<i class="fa fa-minus"></i></button>
			</div>
		</div>
		<div class="box-body">
			{!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
			<div class="form-group">
                {!! Form::label('roll_no','Roll No',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2"  v-bind:class="{ 'has-error': errors['roll_no'] }">
                    {!! Form::text('roll_no',null,['class' => 'form-control', 'v-model' => 'form.roll_no' ,'@blur'=>'changedRollno']) !!}
                    <span id="basic-msg" v-if="errors['roll_no']" class="help-block">@{{ errors['roll_no'][0] }}</span>
                </div>
                {!! Form::label('name','Name',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['name'] }">
                    {!! Form::text('name',null,['class' => 'form-control', 'v-model' => 'name','readOnly']) !!}
                    <span id="basic-msg" v-if="errors['name']" class="help-block">@{{ errors['name'][0] }}</span>
                </div>
			</div>
			<div class="form-group">
                {!! Form::label('room_no','Room No.',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['room_no'] }">
                    {!! Form::text('room_no',null,['class' => 'form-control', 'v-model' => 'room_no','readOnly']) !!}
                </div>
                {!! Form::label('block','Block',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['block'] }">
                    {!! Form::text('block',null,['class' => 'form-control', 'v-model' => 'block','readOnly']) !!}
                </div>
			</div>
            <div class="form-group">
				{!! Form::label('departure_date','Departure Date',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-2" v-bind:class="{ 'has-error': errors['departure_date'] }">
				    {!! Form::text('departure_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.departure_date']) !!}
                    <span id="basic-msg" v-if="errors['departure_date']" class="help-block">@{{ errors['departure_date'][0] }}</span>
                </div>
                {!! Form::label('departure_time','Departure Time',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-2" v-bind:class="{ 'has-error': errors['departure_time'] }">
				    {!! Form::time('departure_time',null,['class' => 'form-control', 'v-model' => 'form.departure_time']) !!}
                    <span id="basic-msg" v-if="errors['departure_time']" class="help-block">@{{ errors['departure_time'][0] }}</span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('expected_return_date','Expected Return Date',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['expected_return_date'] }">
                    {!! Form::text('expected_return_date',tomorrow(),['class' => 'form-control app-datepicker', 'v-model' => 'form.expected_return_date']) !!}
                    <span id="basic-msg" v-if="errors['expected_return_date']" class="help-block">@{{ errors['expected_return_date'][0] }}</span>
                    
                </div>
                {!! Form::label('destination_address','Destination Address',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-4" v-bind:class="{ 'has-error': errors['destination_address'] }">
                    {!! Form::textarea('destination_address',null,['size' => '30x3','class' => 'form-control', 'v-model' => 'form.destination_address']) !!}
                    <span id="basic-msg" v-if="errors['destination_address']" class="help-block">@{{ errors['destination_address'][0] }}</span>
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('remarks','Remarks',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('remarks',null,['class' => 'form-control', 'v-model' => 'form.remarks']) !!}
                    <span id="basic-msg" v-if="errors['remarks']" class="help-block">@{{ errors['remarks'][0] }}</span>
                </div>
            </div>
		</div>
		<div class="box-footer "> 
            <div v-if="form.id > 0">
            {!! Form::submit('UPDATE',['class' => 'btn btn-primary pull-right', '@click.prevent' => 'saveData']) !!}
            </div>
            <div v-else>
                {!! Form::submit('SAVE',['class' => 'btn btn-primary pull-right', '@click.prevent' => 'saveData']) !!}
            </div>
			{!! Form::close() !!}
		</div>
		<ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
			<li v-for='error in errors'>@{{ error[0] }}<li>
		</ul>
	</div>
    <div class="panel panel-default">
        <div class='panel-heading'>
            <strong>Hostel Night Out Students </strong>
        </div>
        <div class="panel-body">
            <table class="table table-bordered" id ="nightOutTable" width="100%">
            </table>
        </div>
        
    </div>
</div>
@stop
@section('script')
<script>
	function getNewForm(){
		return{
            id:0,
			departure_date:"{{ today() }}",
			roll_no:'',
            destination_address:'',
            departure_time:'00:00',
            expected_return_date:'',
            remarks:''
		}
	}
   var dashboard = new Vue({
    el: '#app',
    data: {
		form:getNewForm(),
        name:'',
        room_no: '',
        block:'',
        errors:{},
        tData:[]
    },
    created:function(){
        var self =this;
        this.getData();
        setTimeout(() => {
            this.setTable();
        }, 1000);
        $(document).on('click', '.change-nightout', function(e) {
            self.editNightOut(e.target.dataset.itemId ,e);
        });
    },

    methods: {
        getData: function() {
			var self = this;
			this.errors = {};
			this.fails = false;
			this.$http.get("{{ url('night-out') }}")
			.then(function (response) {
				self.tData = response.data.night_outs;
			}, function (response) {
				this.fails = true;
				this.errors = response.data;
			});
		},

        reloadTable: function() {
            this.table.clear();
            this.table.rows.add(this.tData).draw();
        },

        setTable:function(){
            this.table = $('#nightOutTable').DataTable({
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
                { title: 'Name', targets: 1, data: 'id',
                    "render":function(data,type,row,meta){
                        console.log('table row',row);
                        return row.student ? row.student.name :'';
                    }
                },
                { title: 'Location', targets: 2, data: 'id',
                    "render":function(data,type,row,meta){
                        return row.student.hostelLocation ? row.student.hostelLocation.location :'';
                    }
                },
                { title: 'Block', targets: 3, data: 'id',
                    "render":function(data,type,row,meta){
                        return row.student.hostelLocation.block ? row.student.hostelLocation.block.name :'';
                    }
                },
                { title: 'Roll no', targets: 4, data: 'roll_no'},
                { title: 'Departure Date', targets: 5, data: 'departure_date'},
                { title: 'Departure time', targets: 6, data: 'departure_time'},
                { title: 'Return Status', targets: 7, data: 'return_status',
                    "render":function(data,type,row,meta){
                        return data == 'P' ? 'Pending' :'Returned';
                    }},
                { title: 'Expected return date', targets: 8, data: 'expected_return_date'},
                { title: 'Actual Return date', targets: 9, data: 'actual_return_date'},
                    
                { title: 'Remarks', targets:10, data: 'remarks'},
                { title: 'Action', targets:11,
                    "render":function(data,type,row,meta){
                        if(row.return_status == 'P'){
                            return "<button class='btn btn-primary btn-sm change-nightout' data-item-id ="+row.id+">Edit</button>"
                        }
                        return "";
                    }
                },
                { targets: '_all', visible: true }
                ],
                "sScrollX": true,
            });
            this.reloadTable();
        },
		hasErrors: function() {
			if(this.errors && _.keys(this.errors).length > 0)
				return true;
			else
				return false;
		},
     
		resetData:function(){
			this.form = getNewForm();
            this.name = '';
            this.getData();
            this.reloadTable();
		},

        saveData:function(){
            var self =this;
            this.fails = false;
            this.errors = {};
            self.$http.post("{{ url('night-out') }}" ,self.form)
            .then(function(response){
                if(response.data.success == true){
                    self.resetData();
                    $.blockUI({'message':'<h4>Night Out saved Successfully!</h4>'});
                        setTimeout(() => {
                            $.unblockUI();  
                        }, 1000);
                        
                }
            })
            .catch(function(response){
                this.fails = true;
                this.errors = response.data;
            });
        },

        changedRollno:function(){
            var self = this;
            this.$http.get("{{ url('hostel') }}/"+this.form.roll_no.trim() + '/student')
            .then(function(response){
                var student = response.data.student;
                console.log('rahul',response.data.student);
                if(student){
                    self.name = student.name;
                    self.room_no = student.hostel_location.location;
                    self.block = student.hostel_location.block.name;
                }
                else{
                    self.form.roll_no = '';
                    $.blockUI({'message':'<h4>Roll number not associated with any hostel student</h4>'});
                    setTimeout(() => {
                        $.unblockUI();  
                    }, 1000);
                }
            })
            .catch(function(response){
                this.fails = true;
                this.errors = response.data;
            });
        },

        editNightOut:function(id){
            var self = this;
            this.fails = false;
            this.errors = {};
            this.$http.get("{{ url('night-out') }}/"+id+'/edit')
            .then(function(response){
                var night_out = response.data.night_out;
                self.form =  getNewForm();
                self.form.id = night_out.id;
                self.form.departure_date = night_out.departure_date;
                self.form.roll_no = night_out.roll_no;
                self.form.expected_return_date = night_out.expected_return_date;
                self.form.destination_address = night_out.destination_address;
                self.form.departure_time = night_out.departure_time;
                self.form.remarks = night_out.remarks;
                self.name = night_out.student.name;
            })
            .catch(function(){

            });
        }
    }
  
  });
</script>
@stop