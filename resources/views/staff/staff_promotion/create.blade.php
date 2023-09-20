@extends('app')

@can('department-list')
  @section('toolbar')
    @include('toolbars._staff_toolbar')
  @stop
@endcan

@section('content')
<div id="prom">
  <div class="box box-info" v-cloak>
    <div class="box-header with-border">
      <h3 class="box-title">@{{ form.form_id == 0 ? 'New' : 'Update' }} Promotion    ( @{{ desig.salutation }}  @{{ desig.name }}  @{{desig.middle_name}} @{{desig.last_name}} ) ( @{{desig.desig.name}} ) ( @{{desig.dept.name}} )</h3>
    </div>
    <div class="box-body">
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
      @include('staff.staff_promotion.form')

    </div>
    <div class="box-footer">
      <input class="btn btn-primary" type="submit" value="@{{ form.form_id == 0 ? 'ADD' : 'UPDATE' }}" @click.prevent="save">
      {!! Form::close() !!}
    </div>
  </div>
 
    @include('staff.staff_promotion.index')

  </div>
@stop

@section('script')
  <script>
  function getNewForm() {
        return {
            form_id:0,
            staff_id:'',
            promotion_date:'',
            new_desig_id:'',
            old_desig_id:'',
        }
    }
  var vm = new Vue({
    el:'#prom',
    data:{
        form: getNewForm(),
        errors: {},
        success: false,
        staff_id:"{{$staff_id}}",
        url: "{{ url('staff-promotion')}}",
        boards: {!! getBoardlist(true) !!},
        promotion:{!! isset($prom) && $prom ? json_encode($prom) :'0' !!},
        desig:{!! isset($desig) && $desig ? json_encode($desig) :'0' !!},
        // last_desig:{!! isset($last) && $desig ? json_encode($last) :'0' !!}

    },
    ready(){
      var self = this;
        self.form.staff_id = self.staff_id;
    //   if(self.promotion){
        self.form.old_desig_id = self.desig.desig_id;
    //   }
    },
    methods:{
        save:function(){
            this.errors = {};
            this.$http[this.getMethod()](this.getUrl(), this.form)
            .then(function(response) {
                if (response.data.success) {
                    console.log('dffsdfsd');
                this.success = true;
                this.form.form_id = 0;
                this.form.promotion_date = '';
                this.form.new_desig_id = '';
                this.promotion = response.data.prom;
                this.desig = response.data.desig;
                console.log(this.promotion);
                setTimeout(function() {
                self.success = false;
                }, 500);
            }
            }, 
            function(response) {
                console.log(response);
                this.errors = response.body;
            });
        },
      edit: function(id) {
        this.errors = {};
        this.$http.get("{{ url('staff-promotion') }}/"+id+"/edit")
        .then(function (response) {
          this.staff = response.data.staff;
          this.form.form_id = this.staff.id;
          this.form.staff_id = this.staff.staff_id;
          this.form.promotion_date = this.staff.promotion_date;
          this.form.new_desig_id = this.staff.new_desig_id;
        }, function (response) {
          this.fails = true;
          self = this;
          if(response.status == 422) {
            $('body').scrollTop(0);
            this.errors = response.data;
          }              
        });
      },
      getUrl: function() {
        if(this.form.form_id > 0)
          return this.url+'/'+this.form.form_id;
        else
          return this.url;
      },
      getMethod: function() {
        if(this.form.form_id > 0)
          return 'patch';
        else
          return 'post';
      },

      hasError: function() {
            if(this.errors && _.keys(this.errors).length > 0)
                return true;
            else
                return false;
      },
    }
  }); 
  </script>
@stop