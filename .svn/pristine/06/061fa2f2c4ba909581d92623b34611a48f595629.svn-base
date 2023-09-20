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
				{!! Form::label('attendance_date','Date',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-2">
				{!! Form::text('attendance_date',today(),['class' => 'form-control app-datepicker',':disabled' => 'students.length>0', 'v-model' => 'attendance_date']) !!}
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
						<th>{{daybeforeyesterday()}}</th>
						<th>Yesterday : {{yesterday()}}</th>
						<th>Attendance Status</th>
						<th>Remarks</th>
					</thead>
					<tbody>
						<tr v-for="std in students" :key="std.id">
							<td>
								<span :class="{ 'fa fa-check': std.saved == true}"  style="color:green" >
								</span>@{{ $index+1 }}
							</td>
							<td>@{{ std.roll_no }}</td>
							<td>@{{ std.name }}</td>
							<td>
								<span v-if= "std.before_prev_status == 'P'">
									Present  </span>
								<span v-if= "std.before_prev_status == 'A'">
									Absent  </span>
								<span v-if= "std.before_prev_status == 'N'">
									Night Out  </span>
							</td>
							<td>
								<span v-if= "std.prev_status == 'P'">
									Present  </span>
								<span v-if= "std.prev_status == 'A'">
									Absent  </span>
								<span v-if= "std.prev_status == 'N'">
									Night Out  </span>
							</td>
							<td>
								<select class="form-control" v-model="std.status" @change="studentattendance(std,$index)">
									<option value='P'>Present</option>
									<option value='A'>Absent</option>
									<option value='N'>Night Out</option>
								</select>
							</td>
							<td>
								<input type="text" class="form-control" placeholder="optional" v-model="std.remarks" @blur.prevent="studentattendance(std,$index)">
							</td>
						</tr>
					</tbody>
				</table>
		</div>
	</div>
</div>
@stop
@section('script')
<script>
	function getNewForm(){
		return{
			attendance_date:"{{ today() }}",
			roll_no:'',
			status:'',
			student:{},
			status:'',
			remarks:''
		}
	}
   var dashboard = new Vue({
    el: '#app',
    data: {
		students: [],
		block_id:0,
		location_id:0,
		attendance_date:'',
		table: null,
		success: false,
		fails: false,
		errors: {},
		locations:[],
		form:getNewForm()
    },
    created: function() {
		var self = this;
      $('.select2').select2({
          placeholder: 'Select Location',
          width:'100%'
      });
      $('.select2').on('change',function(e){
          self.location_id = $(this).val();
		  console.log(this.location_id)
      });   
    },
  methods: {
		getData: function() {
			var self = this;
			this.errors = {};
			this.fails = false;
			this.$http.post("{{ url('hostel-attendance/show') }}",{'attendance_date':this.attendance_date,
				'block_id':this.block_id,
				'location_id':this.location_id
			 })
			.then(function (response) {
				response.data.forEach(element => {
					// element['status'] = '';
					if(element['status']){
						element['saved'] = true;
					}
					else{
						element['saved'] = false;
					}
					
				});
				self.students = response.data;
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

		studentattendance:function(std,index){
			var self = this;
			this.form.roll_no = std.roll_no;
			this.form.course_id = std.course_id;
			this.form.student = std;
			this.form.status = self.students[index].status;
			this.form.remarks = self.students[index].remarks;
			this.form.attendance_date = self.attendance_date;
			this.$http.post("{{ url('hostel-attendance') }}",this.form)
			.then(function(response){
					if(response.ok == true){
						self.students[index].saved = true;
						self.form = getNewForm();
						
					}
			})
			.catch(function(error){
				if(error.status == 422) {
					self.errors = error.data;
				}
			});
		},

		resetData:function(){
			var self= this;
			self.block_id = 0;
			self.location_id = 0;
			self.form = getNewForm();
			self.students = [];
			$('.select2').val(0).trigger('change');
		}
		
    }
  
  });
</script>
@stop