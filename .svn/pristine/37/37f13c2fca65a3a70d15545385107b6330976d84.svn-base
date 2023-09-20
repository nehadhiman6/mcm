@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div class="box box-info" id='app' v-cloak>
    {{  Form::open(array('url' =>'inst-attachment/'.$course_id,'files'=>'true'))}}
    <div class="box-header with-border">
            {!! csrf_field() !!}
           <h3>{{ $course->course_name }}</h3> 
        {{-- <h3 class="box-title">Upload Image: {{ auth()->user()->name }}</h3> --}}
    </div>
    <div class="box-body">
        
        {!! Form::label('image','Timetable PDF',['class' => 'col-sm-3 control-label required']) !!}
        <div class= "form-group">
            <div class="col-sm-4"> 
                <input type="file" name="image"  @change ="readURL" class="form-control"/>
                <span style="color:red; padding:10px;"><b>Size : Not more than 300KB</b></span>
            </div>
            <div class= "col-sm-1">
                {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
            </div>
            <div class= "col-sm-2">
                {{-- <img v-if="course_id > 0 && user_src == ''"  :src="getSource()" alt="your image" width="115" height="115"/> --}}
                <a class="btn btn-default" @click.prevent="showImage"  v-if="file == 'yes'" class="btn btn-default">
                    <img src="{{ url('img/pdf.png')}}" width="70px;" />
                </a>
            </div>
        </div>
        
      
    </div>
    <div class='box-footer'>
        </div>
    {!! Form::close() !!}
</div>

@stop
@section('script')
    <script>
        var vm = new Vue({
            el:'#app',
            data:{
                user_src:"",
                course_id:'{{$course_id}}',
                file:'{{$file}}',
                course:{!! json_encode($course) !!}
            },
            ready:function(){
                this.getSource();
            },
            methods:{
                readURL:function(input){
                    var self = this;
                    console.log(input);
                    if (input.target.files && input.target.files[0]) {
                        var reader = new FileReader();
                        reader.onload = this.imageIsLoaded;
                        // reader.onload = this.course_id
                        reader.readAsDataURL(input.target.files[0]);
                    }
                },
                imageIsLoaded:function(e){
                    this.user_src =  e.target.result;
                    setTimeout(() => {
                        $('#user-image').attr('src', e.target.result);
                    }, 300);
                },
                getSource:function(){
                    return MCM.base_url+'/courses/'+this.course_id+'/inst-attachment'+'?'+ new Date().getTime();
                },

                showImage: function() {
                    self = this;
                    window.open(MCM.base_url+'/show-attachment/'+this.course_id+'?'+ new Date().getTime(),'_blank');
                        
                }
            }
        });
    </script>
@stop
