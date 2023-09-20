@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div id="app1" class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">{{ isset($sub_combination) ? 'Update' : 'New' }} Subject Combination</h3>
    </div>
    <div class="box-body">

        {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}

        @include('subcombination.form', ['submitButtonText' => 'Save'])

        {!! Form::close() !!}
    </div>
</div>
@stop

@section('script')
<script>
    function getNewForm() {
        return {
            form_id:0,
            course_id:'',
            code:'',
            combination:'',
            subject_ids:[],
        }
    }
    var vm = new Vue({
        el: '#app1',
        data: {
            form: getNewForm(),
            sub_combination: {!! isset($sub_combination) ? $sub_combination : 0 !!},
            errors: {},
            base_url: "{{ url('subject-combination')}}",
            subjects:[]
        },

        created:function(){
            var self = this;
           
        },
        ready: function() {
            var self = this;
            if(self.sub_combination.id > 0){
                self.editSubject();
            }

            $('.selectCourse').select2({
                placeholder: 'Select Course',
                width:'100%'
            });
            $('.selectCourse').on('change',function(){
                self.form.course_id = $(this).val();
                // self.form.subject_ids = 0;
                // $('.subjectSelect').val(0).trigger('change');
                self.getSubjectsList();
            });
            
            // $('.select2').select2({
            //     placeholder: 'Select Subject',
            //     // width:'100%'
            // });
            // $('.select2').on('change',function(){
            //     self.form.subject_ids = $(this).val();
            //     // self.getCombination();
            // });

            var select1 = $(".selectSub")
            .select2({
                placeholder: "Multi Select",
                width:"100%",
            })
            .on("change", function(e) {
				// console.log(e);
                self.form.subject_ids = $(".selectSub").val();
                self.getCombination();
				
				// self.research.indexing = stt.join();
				
			});
        },
        methods: {  

            getSubjectsList: function() {
                var self = this;
                if(this.form.course_id != 0) {
                    this.$http.get("{{ url('subject-courses') }}/"+this.form.course_id)
                    .then(function(response) {
                        console.log(response);
                        self.subjects = response.body.subject;
                        // this.resetData();
                    }, function(response) {
                    });
                }
            },

            getCombination:function(){
                var self = this;
                data = $.extend({}, {
                    course_id:this.form.course_id,
                    subject_id: this.form.subject_ids,
                })
                if(this.form.course_id != 0 && this.form.subject_ids.length > 0) {
                    this.$http.get("{{ url('sub-combination') }}", {params: data})
                        .then(function(response) {
                        var combination = response.body.combination;
                        var comb = '';
                        combination.forEach(function(e){
                                comb += (comb != '') ? ' ' : '';
                                comb += e.uni_code;
                        });
                        
                        self.form.combination = comb;
                            // this.resetData();
                        }, function(response) {
                    });
                }
            },

            submit:function(){
                this.$http.post("{{ url('subject-combination') }}", this.form)
                .then(function(response) {
                    if(response.data.success) {
                        if(response.data.success){
                            this.errors = {};
                            window.location.href = "{{ url('subject-combination')}}";
                        }else{
                            // self.resetForm();
                        }
                    }
                }, 
                function(response) {
                    this.errors = response.body;
                });
            },

            editSubject: function(id){
                var self = this;
                self.form.form_id = self.sub_combination.id;
                self.form.code = self.sub_combination.code;
                self.form.course_id = self.sub_combination.course_id;
                self.form.combination = self.sub_combination.combination;
                $('.selectCourse').val(self.form.course_id).trigger('change');
                self.getSubjectsList();
                self.sub_combination.details.forEach(function (ele) {
                    self.form.subject_ids.push(ele.subject_id);
                });
                setTimeout(function(){
                    $('.selectSub').val(self.form.subject_ids).trigger('change');
                },2000);
                
            },

            hasErrors: function() {
                console.log(this.errors && _.keys(this.errors).length > 0);
                if(this.errors && _.keys(this.errors).length > 0)
                    return true;
                else
                    return false;
            },

            cancel:function(){
                window.location.href = "{{ url('subject-combination')}}";

            }

        }
    });
</script>
@endsection
