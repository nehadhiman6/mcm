@extends('app')
@section('content')
<div class="box box-info" id="app">
    <div class="box-header with-border">
        <h3 class="box-title">Subject Combination</h3>
    </div>
    <div class="box-body">
        <div v-for="dets in sub_combination"> 
            <div class="form-group">
                {!! Form::label('sub_combination_id','Subject Preference @{{dets.preference_no}}',['class' => 'col-sm-4 mt-2 control-label']) !!}
                <div class="col-sm-8 mt-2">
                    <select v-model="dets.sub_combination_id" class="form-control" id="abc">
                        <option v-for="sub in subjectCombinations" :value="sub.id">@{{ sub.code }}:- @{{ sub.subject}} </option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row col-md-12">
            <input class="btn btn-primary"  type="button" :value="adm_form.active_tab >= 3 ? 'Update' : 'Submit'" @click.prevent="submit">
        </div>

    </div>
</div>
@stop
@section('script')
  <script>
 
    var vm = new Vue({
      el: '#app',
      data: function(){
        return {
            course_type: '',
            adm_form : {!! json_encode($adm_form) !!},
            form_id: 0,
            course_id: {{ intval($adm_form->course_id) }},
            proceed : false, // by default false
            response: {},
            success: false,
            fails: false,
            msg: '',
            errors: [],
            showIfOldStd: false,
            sub_combination:[],
            subjectCombinations: {!! json_encode(getSubjectCombination($adm_form->course_id)) !!},

        }
      },

    //   created: function() {
    //     console.log(this.admForm);
    //   },
        ready: function(){
            var self = this;
            self.setDataForForm(self.adm_form);
            if(self.adm_form.sub_combinations.length == 0){
                var arr = ['1','2','3','4'];
                var row = {};
                for (let index = 1; index < arr.length; index++) {
                    row={
                        id:0,
                        admission_id:this.adm_form.id,
                        preference_no:index,
                        sub_combination_id:'0',
                    }
                    self.sub_combination.push(row);
                }
            }
        },

        methods:{
            submit: function() {
                    var self = this;
                    self.errors = {};
                    var data = self.setFormData();
                    var submit = true;
                    if(this.adm_form && this.adm_form.course && this.adm_form.course.course_name == 'BAI'){
                        var this_sub_combination_ids = [];
                        data.sub_combination.forEach(function(e, i) {
                            if(e.sub_combination_id == 0) {
                                alert('Minimum 3 Subject Prefrence are Required');
                                submit = false;
                                return;
                            }
                            if(this_sub_combination_ids.includes(e.sub_combination_id)) {
                                alert('Subject Prefrence must be unique!');
                                submit = false;
                                return;
                            }
                            this_sub_combination_ids.push(e.sub_combination_id);
                        })
                    }
                    if(submit){
                        self.$http[self.getMethod()](MCM.base_url+'/'+self.getUrl(), data)
                        .then(function (response) {
                            if (response.data.success) {
                                self.form_id = response.data.form_id;
                                $.blockUI({ message: '<h3> Record successfully saved !!</h3>' });
                                setTimeout(function(){
                                    $.unblockUI();
                                    // window.location = MCM.base_url+'/'+;
                                },1000);
                            }
                        }, function (response) {
                            self.fails = true;
                            if(response.status == 422) {
                                $('body').scrollTop(0);
                                self.errors = response.data;
                            }              
                        });
                    }
                },

                setFormData: function(){
                    return {
                        form_id : this.adm_form.id,
                        course_id : this.course_id,
                        sub_combination:this.sub_combination,
                    }
                },


                setDataForForm: function(sub_op){
                    var self = this;
                    console.log(sub_op.sub_combinations,'Shubham');
                    var row = {};
                    sub_op.sub_combinations.forEach(element => {
                        row={
                            id:element.id,
                            admission_id:element.admission_id,
                            preference_no:element.preference_no,
                            sub_combination_id:element.sub_combination_id,
                        }
                        self.sub_combination.push(row);
                    });

                },

                getMethod: function() {
                    if(this.adm_form.sub_combinations.length > 0)
                    return 'patch';
                    else
                    return 'post';
                },

                getUrl: function() {
                    if(this.adm_form.sub_combinations.length > 0)
                        return 'adm-subject-combination/'+this.form_id;
                    else
                        return 'adm-subject-combination';
                },
            
        }

    });
  </script>
@endsection

