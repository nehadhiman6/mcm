@extends('app')
@section('toolbar')
@include('toolbars._hostels_toolbar')
@stop
@section('content')
<div id= "app" v-cloak>
	<div class="box box-default box-solid" >
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
                {!! Form::label('from_date','From Date',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('from_date',startDate(),['class' => 'form-control app-datepicker', 'v-model' => 'from_date']) !!}
                </div>
                {!! Form::label('upto_date','To Date',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2">
                    {!! Form::text('upto_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'upto_date']) !!}
                </div>
			</div>
			<div class="form-group">
				{!! Form::label('block_id','Block ',['class' => 'col-sm-2 control-label required']) !!}
				<div class="col-sm-2">
				    {!! Form::select('block_id',getBlocks(),null, ['class' => 'form-control',':disabled' => 'students.length > 0','v-model'=>'block_id','@change'=>'changeBlock']) !!}
				</div>
				{!! Form::label('location_id','Location/Room',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-6">
					<select class="form-control select2" v-model="location_id" :disabled = "students.length > 0">
							<option value="0">Select</option>
							<option v-for="loc in locations" :value="loc.id">@{{ loc.location }}</option>
					</select>
				</div>
			</div>
		</div>
		<div class="box-footer "> 
			<div class="pull-right">
				{!! Form::submit('RESET',['class' => 'btn btn-primary ', '@click.prevent' => 'resetData']) !!}
				{!! Form::submit('SHOW',['class' => 'btn btn-primary',':disabled'=>'students.length > 0', '@click.prevent' => 'getData']) !!}
				{!! Form::close() !!}
			</div>
		</div>
		<ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
			<li v-for='error in errors'>@{{ error[0] }}<li>
		</ul>
	</div>
	<div class="panel panel-default" v-if="students.length > 0">
		<div class='panel-heading'>
			<strong>Hostel Students Attendance </strong>
		</div>
		<div class="panel-body">
			<table class="table table-bordered" id ="attendanceTable" >
					<thead>
						<th>Sr. no</th>
						<th>Roll no</th>
                        <th>Student Name</th>
                        <th>Departure Date</th>
                        <th>Departure time</th>
                        <th>Destination Address</th>
                        <th>Expected Return date</th>
                        <th>Remarks</th>
						<th>Action</th>
					</thead>
					<tbody>
						<tr v-for="std in students" :key="std.id">
							<td>
								<span :class="{ 'fa fa-check': std.saved == true}"  style="color:green" >
								</span>@{{ $index+1 }}
							</td>
							<td>@{{ std.roll_no }}</td>
                            <td>@{{ std.name }}</td>
							<td>@{{ std.departure_date }}</td>
                            <td>@{{ std.departure_time }}</td>
							<td>@{{ std.destination_address }}</td>
                            <td>@{{ std.expected_return_date}} </td>
                            <td>@{{ std.remarks}} </td>
                            <td><button class="btn btn-primary return-room"  :data-item-id ="$index">Return</button></td>
						</tr>
					</tbody>
				</table>
        </div>
        
    </div>
    <div id="returnoutModal" class="modal fade tttt" role="dialog">
            <div class="modal-dialog form-horizontal" >
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Student Return Entry</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {!! Form::label('name','Student Name',['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                            {!! Form::text('name',null,['class' => 'form-control', 'v-model' => 'form.name' ,'readOnly']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('roll_no','Roll  No.',['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                            {!! Form::text('roll_no',null,['class' => 'form-control', 'v-model' => 'form.roll_no' ,'readOnly']) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('actual_return_date','Return Date',['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                            {!! Form::text('actual_return_date',today(),['class' => 'form-control app-datepicker', 'v-model' => 'form.actual_return_date' ]) !!}
                            </div>
                        </div>
                        <div class="form-group">
                            {!! Form::label('remarks','Remarks',['class' => 'col-sm-4 control-label']) !!}
                            <div class="col-sm-8">
                            {!! Form::text('remarks',null,['class' => 'form-control', 'v-model' => 'form.remarks' ]) !!}
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
	function getNewForm(){
		return{
            name:'',
            roll_no:'',
            actual_return_date:"{{ today()}}",
            id:0, 
            return_status:'R',
            remarks:''
		}
	}
   var dashboard = new Vue({
    el: '#app',
    data: {
		students: [],
		from_date:"{{ startDate()}}",
        upto_date:"{{ today() }}",
        block_id:'0',
        location_id:'0',
		table: null,
		success: false,
		fails: false,
		errors: {},
		locations:[],
		form:getNewForm(),
        studentIndex:0,
    },
    created: function() {
        var self = this;
        $(document).on('click', '.return-room', function(e) {
            self.returnEntry(e.target.dataset.itemId ,e);
        });
        $('#returnoutModal').on('hidden.bs.modal', function() {
            self.studentIndex = 0;
            self.selected_student = {};
            self.students =[];
            self.getData();
        });
        $('.select2').select2({
            placeholder: 'Select Location',
            width:'100%'
        });
        var abc = $('.select2').on('change',function(e){
            self.location_id = $(this).val();
            console.log(this.location_id)
        }); 
       
    },
  methods: {
      
		getData: function() {
			var self = this;
			this.errors = {};
			this.fails = false;
			this.$http.post("{{ url('night-out-return/show') }}",{'from_date':this.from_date,
                'upto_date' :this.upto_date,
                'block_id' : this.block_id,
                'location_id':this.location_id
            })
			.then(function (response) {
				self.students = response.data.night_outs;
                setTimeout(() => {
                    $('#attendanceTable').DataTable();
                }, 500);
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
      
		changeBlock:function(){
			var self= this;
			this.locations = [];
			this.$http.post("{{ url('hostel-attendance/block-location') }}", {'block_id': self.block_id})
			.then(function (response) {
				self.locations = response.data.locations;
			}, function (response) {
				this.fails = true;
				this.errors = response.data;
			});
		},

		resetData:function(){
			var self= this;
			self.block_id = 0;
			self.location_id = 0;
			self.form = getNewForm();
			self.students = [];
            $('#returnoutModal').modal('hide');
            $('.select2').val(0).trigger('change');     
		},

        returnEntry:function(index){
            this.form.roll_no = this.students[index].roll_no;
            this.form.name = this.students[index].name;
            this.form.id = this.students[index].id;
            this.studentIndex = index;
            setTimeout(() => {
                $('#returnoutModal').modal('show');
            }, 100);
        },
        
        saveData:function(){
            var self = this;
            this.$http.post("{{ url('night-out-return') }}",this.form)
			.then(function(response){
                if(response.ok == true){
                    self.resetData();
                    self.getData();
                }
			})
			.catch(function(error){
				if(error.status == 422) {
					self.errors = error.data;
				}
			});
        }
		
    }
  
  });
</script>
@stop