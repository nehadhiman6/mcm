@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
    <div class="box box-default box-solid" >
        <div class="box-header with-border">
            <h3 class="box-title" v-if="exam_location.id">Edit Exam location</h3>
            <h3 class="box-title" v-else> Add Exam Location</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                <i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('center','Center',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['center'] }">
                    {!! Form::select('center', getCenters(), null, ['class' => 'form-control', 'v-model' => 'form.center']) !!}
                    <span id="basic-msg" v-if="errors['center']" class="help-block">@{{ errors['center'][0] }}</span>
                </div>
                {!! Form::label('loc_id','Location',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-6" v-bind:class="{ 'has-error': errors['loc_id'] }">
                	{!! Form::select('loc_id',getLocations(),0,['class' => 'form-control selectLocation','v-model'=>'loc_id']) !!}
                	<span id="basic-msg" v-if="errors['loc_id']" class="help-block">@{{ errors['loc_id'][0] }}</span>
              	</div>
			</div>
            <div class="form-group">
                {!! Form::label('no_of_rows','Total Number of Rows',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['no_of_rows'] }">
                    {!! Form::number('no_of_rows',null,['class' => 'form-control', 'v-model' => 'form.no_of_rows','min'=>1,'max'=>100,'@change'=>'setDetails']) !!}
                	<span id="basic-msg" v-if="errors['no_of_rows']" class="help-block">@{{ errors['no_of_rows'][0] }}</span>
                </div>
				{!! Form::label('seating_capacity','Total Seating Capacity',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-2" v-bind:class="{ 'has-error': errors['seating_capacity'] }">
                    {!! Form::number('seating_capacity',null,['class' => 'form-control', 'disabled','v-model' => 'seatingCapacity']) !!}
                	<span id="basic-msg" v-if="errors['seating_capacity']" class="help-block">@{{ errors['seating_capacity'][0] }}</span>
                </div>
			</div>
			<fieldset v-if="form.no_of_rows > 0">
				<legend>Seats Detail</legend>
			<div class="form-group" v-for="dets in form.dets ">
				{!! Form::label('row_no','Row no.',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-2" v-bind:class="{ 'has-error': errors['dets.'+$index+'.row_no'] }">
					{!! Form::number('row_no',null,['class' => 'form-control', 'v-model' => 'dets.row_no','min'=>1,'max'=>100]) !!}
                	<span id="basic-msg" v-if="errors['dets.'+$index+'.row_no']" class="help-block">@{{ errors['dets.'+$index+'.row_no'][0] }}</span>
                </div>
				{!! Form::label('seats_in_row','Capacity in Row',['class' => 'col-sm-2 control-label']) !!}
				<div class="col-sm-2" v-bind:class="{ 'has-error': errors['dets.'+$index+'.seats_in_row'] }">
					{!! Form::number('seats_in_row',null,['class' => 'form-control', 'v-model' => 'dets.seats_in_row','min'=>1,'max'=>100]) !!}
                	<span id="basic-msg" v-if="errors['dets.'+$index+'.seats_in_row']" class="help-block">@{{ errors['dets.'+$index+'.seats_in_row'][0] }}</span>
                </div>
			</div>
		</fieldset>
            <div class="form-group col-sm-12">
                <div class="col-sm-2 pull-right" v-if="exam_location.id">
                    {!! Form::submit('Update',['class' => 'btn btn-primary','@click.prevent'=>'saveData()']) !!}
                </div>
                <div class="col-sm-2 pull-right" v-else >
                    {!! Form::submit('SAVE',['class' => 'btn btn-primary','@click.prevent'=>'saveData()']) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        </div>
        <div class="box">
            <div class="box-header with-border">
                Exam  Locations
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="exam-locations" class="table table-bordered" width="100%">
                    </table>
                </div>
            </div>
        </div>
</div>
@stop
@section('script')
  <script>
      var datesheet = new Vue({
            el:"#datesheet",
            data:{
                form:{
                  id:0,
                  loc_id:0,
                  seating_capacity:"",
                  no_of_rows:'',
                  center:'',
				  dets:[],
                },        
                exam_location:{!! isset($exam_location) ? $exam_location : "{}" !!},
                errors: {},
                centers:{!! json_encode(getCenters(true)) !!},
                permissions: {!! json_encode(getPermissions()) !!},
            },
            created:function(){
                var self = this;
                $('.selectLocation').select2({
                    placeholder: 'Select Location',
                    width:'100%'
                });
                $('.selectLocation').on('change',function(){
                    self.form.loc_id = $(this).val();
                });
                this.setTable();
                if(this.exam_location.id){
                    this.setdata();
                }
            },
			computed:{
				seatingCapacity:function(){
					var self = this;
					var tot_capacity = 0;
					this.form.dets.forEach(function(element){
						tot_capacity += (element.seats_in_row*1);
					});
					this.form.seating_capacity =  tot_capacity;
					return tot_capacity;
				}
			},
            methods: {
				setDetails:function(){
					var self = this;
					if(self.form.no_of_rows > 0 && this.form.dets.length < self.form.no_of_rows ){
						for(var i=this.form.dets.length;i<self.form.no_of_rows;i++){
							self.form.dets.push({'row_no':i+1,'seats_in_row':''});
						}
					}
					else{
						var remove =  this.form.dets.length - self.form.no_of_rows;
						// this.form.dets.splice( self.form.no_of_rows-1,remove);
                        for(i=0;i<remove;i++){
                            this.form.dets.pop(1);
                        }
					}
				},
                saveData:function(){
                    var self =this;
                    this.$http.post("{{ url('exam-locations') }}", this.$data.form )
                    .then(function(response){
                        if(response.status == 200){
                            self.resetData();
                            window.location.href = MCM.base_url+'/exam-locations';
                        }
                    })
                    .catch(function(error){
                        if(error.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = error.data;
                        }   
                    });
                },
                resetData:function(){
                    this.form = {
                        id:0,
                        loc_id:0,
                        seating_capacity:"",
                        no_of_rows:'',
                        center:'',
                        dets:[],
                    };
                    $('.selectLocation').val(0).trigger('change');
                },
                setTable:function(){
                    var self= this;
                    var target = 0;
                    self.table = $('#exam-locations').DataTable({
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
                        "ajax": {
                            "url": MCM.base_url+'/exam-locations',
                            "type": "GET",
                        },
                        "scrollX": true,
                        buttons: ['pdf'],
                        columnDefs: [
                            { title: '#',width:50, targets: target++, data: 'id',
                                "render": function( data, type, row, meta) {
                                    // var index = meta.row + parseInt(meta.settings.json.start);
                                    return meta.row +1;
                                }
                            },
                            { title: 'Center', targets:target++,data:'center',
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    $.each(self.centers,function(key ,val){
                                        if(data == key){
                                            str+= val;
                                        }
                                    });
                                    return str;
                                }
                            },
                            { title: 'Location', targets:target++,
                                "render":function(data, type, row, meta){
                                    return  course = row.location ? row.location.location : '' ;
                                }
                            },
                            { title: 'No. of rows', targets:target++, data:'no_of_rows'
                            },
                            { title: 'Total Seating Capacity', targets:target++,data:'seating_capacity'
                            },
                            { title: 'Seating Details', targets:target++,
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    if(row.exam_loc_dets){
                                        row.exam_loc_dets.forEach(function(ele){
                                            str+=' [ ';
                                            str+= 'Row no. ' + ele.row_no +' : ';
                                            str+= 'Seats ' + '<b>'+ele.seats_in_row+'</b>';
                                            str+=' ] ';
                                            // str+='<br>'
                                        })
                                    }
                                    return str;
                                }
                            },
                            { visible: self.checkPermission(), title: 'Action', targets:target++, data: 'id',
                                "render":function(data, type, row, meta){
                                    var str = '';
                                    if(self.permissions['exam-location-modify']){
                                        str += "<a href='"+MCM.base_url+"/exam-locations/"+row.id+"/edit' class='btn btn-primary'>Edit</a>";
                                    }
                                    return str;
                                }
                            }
                        ],
                        // "sScrollX": true,
                    });
                },
                checkPermission:function(){
                    if(this.permissions['exam-location-modify'] == 'exam-location-modify'){
                        return true;
                    }
                    else{
                        return false;
                    }
                },
                setdata:function(){
                    var self =this;
                    $.each(this.exam_location,function(key ,val){
                        if(self.form.hasOwnProperty(key) == true && typeof(self.form[key])  != 'function' && typeof(self.form[key])  != 'object' ){
                            self.form[key] = val;
                        }
                    });
                    this.exam_location.exam_loc_dets.forEach(function(ele){
                        self.form.dets.push({'row_no':ele.row_no,'seats_in_row':ele.seats_in_row});
                    });

                    $('.selectLocation').val(this.exam_location.loc_id).trigger('change');
                }
            }
      });
  </script>
@stop
