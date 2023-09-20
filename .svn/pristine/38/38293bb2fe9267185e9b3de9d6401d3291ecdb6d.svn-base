@extends('app')
{{-- @section('toolbar')
    @include('toolbars._users_toolbar')
@stop --}}
@section('content')
<div class="box box-info" id='app' v-cloak>
    {{  Form::open(array('url' =>'user-upload','files'=>'true'))}}
    <div class="box-header with-border">
            {!! csrf_field() !!}
        {{-- <h3 class="box-title">Upload Image: {{ auth()->user()->name }}</h3> --}}
    </div>
    <div class="box-body">
        {!! Form::label('image','Upload Image',['class' => 'col-sm-3 control-label required']) !!}
        
        <div class= "form-group">
            <div class="col-sm-4"> 
                <input type="file" name="image"  @change ="readURL" class="form-control"/>
            </div>
            <div class= "col-sm-1">
                {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
            </div>
            <div class= "col-sm-2">
                <img v-if = "user_src != ''" id="user-image" src="#" alt="your image" width="115" height="115"/>
                <img v-if="user_image_id > 0 && user_src == ''"  :src="getSource()" alt="your image" width="115" height="115"/>
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
                user_image_id:{{isset( auth()->user()->image) ? auth()->user()->image->id:0}}
            },
            methods:{
                readURL:function(input){
                    console.log(input);
                    if (input.target.files && input.target.files[0]) {
                        var reader = new FileReader();
                        reader.onload = this.imageIsLoaded;
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
                    return MCM.base_url+'/user-image/'+this.user_image_id+'?'+ new Date().getTime();
                }
            }
        });
    </script>
@stop
