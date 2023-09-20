@extends($dashboard)
@section('content')
<div id="app" v-cloak>
    <div v-show="student_feedback.length > 0" class="alert alert-warning">
        <span>Your feedback is submitted Successfully</span>
    </div>
    <div class='panel panel-default'>
        <div class='panel-heading'>
            <strong>Student Satisfaction Survey</strong>
        </div>
        <div class='panel-body'>
            <div class="col-sm-4">
                <p><strong class='p-head'>Name of the Student: </strong> {{ $adm_form->name or '' }}</p>
            </div>
            <div class="col-sm-4">
                <p><strong class='p-head'>Roll No: </strong> {{ $adm_form->student->roll_no or '' }}</p>
            </div>
            <div class="col-sm-4">
                <p><strong class='p-head'>Class: </strong> {{ $adm_form->course->course_name or '' }}</p>
            </div>
            <div class="col-sm-12">
                <p><strong class='p-head'>Directions: </strong></p>
            </div>
            <div class="col-sm-12">
                <p>
                    For each item, please indicate your level of agreement with the following statement by choosing
                    a score between Poor, Good, Very Good, Excellent. <br><strong>Higher score indicates a stronger agreement
                    with the statement.</strong> 
                </p>
            </div>
            <div class="col-sm-12">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr v-for="(i,s) in sections">
                            <td><strong>@{{i+1}} . @{{s.name}}</strong>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr v-for="que in s.feedback_question">
                                        <td width="3%">@{{ que.sno }}</td>
                                        <td>@{{ que.question }}</td>
                                        <td width="35%">
                                            <label class="radio-inline" >
                                                <input :name="'rating'+que.id" type="radio" value = '1' :checked = 'getFeedbackRatingStatus(que.id,1) ' @change="saveRating(1, que.id)">
                                                Poor
                                            </label>
                                            <label class="radio-inline" >
                                                <input :name="'rating'+que.id" type="radio" value = '2' :checked = 'getFeedbackRatingStatus(que.id,2)' @change="saveRating(2, que.id)">
                                                Good
                                            </label>
                                            <label class="radio-inline" >
                                                <input :name="'rating'+que.id" type="radio" value = '3' :checked = 'getFeedbackRatingStatus(que.id,3)' @change="saveRating(3, que.id)">
                                                Very Good
                                            </label>
                                            <label class="radio-inline" >
                                                <input :name="'rating'+que.id" type="radio" value = '4' :checked = 'getFeedbackRatingStatus(que.id,4)' @change="saveRating(4, que.id)">
                                                Excellent
                                            </label>
                                            
                                        </td>
                                        
                                    </tr>

                                    <tr v-for="(index,sub_sec) in s.sub_sections">
                                        <td>@{{ index+1 }} . @{{ sub_sec.name }}
                                            <table class="table table-bordered table-striped">
                                                <tbody>
                                                    <tr v-for="que in sub_sec.feedback_question">
                                                        <td width="3%">@{{ que.sno }}</td>
                                                        <td>@{{ que.question }}</td>
                                                        <td width="35%">
                                                            <label class="radio-inline" >
                                                                <input :name="'rating'+que.id" type="radio" :checked = 'getFeedbackRatingStatus(que.id,1)'  @change="saveRating(1, que.id)" >
                                                                Poor
                                                            </label>
                                                            <label class="radio-inline" >
                                                                <input :name="'rating'+que.id" type="radio" :checked = 'getFeedbackRatingStatus(que.id,2)'  @change="saveRating(2, que.id)" >
                                                                Good
                                                            </label>
                                                            <label class="radio-inline" >
                                                                <input :name="'rating'+que.id" type="radio" :checked = 'getFeedbackRatingStatus(que.id,3)'  @change="saveRating(3, que.id)" >
                                                                Very Good
                                                            </label>
                                                            <label class="radio-inline" >
                                                                <input :name="'rating'+que.id" type="radio" :checked = 'getFeedbackRatingStatus(que.id,4)'  @change="saveRating(4, que.id)" >
                                                                Excellent
                                                            </label>
                                                            
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel-footer" v-if="student_feedback.length == 0">
            <button class="btn btn-primary" @click.prevent="submitForm" :disabled="saving">Submit Feedback</button>
        </div>
    </div>
</div>

@stop
@section('script')
<script>
    var vm = new Vue({
        el: '#app',
        data: {
            std_id: {!! $adm_form->student->id or 0 !!},
            sections: {!! $feedback_sections !!},
            student_feedback: {!! $student_feedback !!},
            saving: false,
            data:[],
            errors: []
        },
        ready:function(){
            var self = this;
            var row = {};
            self.sections.forEach(function(e){
                if(e.sub_sections.length > 0){
                    e.sub_sections.forEach(function(ele){
                        ele.feedback_question.forEach(function(elem){
                            row = {
                                id: 0,
                                question_id: elem.id,
                                question_name: elem.question,
                                section_id: elem.section_id,
                                under_section_id: ele.under_section_id,
                                std_id: self.std_id,
                                rating: ''
                            };
                            self.data.push(row);
                        });
                    });
                }else{
                    e.feedback_question.forEach(function(ele){
                        row = {
                            id: 0,
                            question_id: ele.id,
                            question_name: ele.question,
                            section_id: ele.section_id,
                            under_section_id: e.under_section_id,
                            std_id: self.std_id,
                            rating: ''
                        };
                        
                        self.data.push(row);
                    });
                }
            });

            if(self.student_feedback.length > 0){
                self.data.forEach(function(e){
                    self.student_feedback.forEach(function(ele){
                        if(e.question_id == ele.question_id){
                            e.rating = ele.rating;
                        }
                    });
                });
            }
        },
        methods:{
            saveRating: function(rating, question_id){
                var self = this;
                self.data.forEach(function(e){
                    if(e.question_id == question_id){
                        e.rating = rating;
                    }
                });

            },

            submitForm: function(section_id, under_section_id, rating, question_id){
                this.saving = true;
                var self = this;
                this.$http.post("{{ url('student-feedback') }}", { feedback: self.data } )
                .then(function (response) {
                    if(response.data.success){
                        self.showMessage('Feedback Saved Successfully');
                        setTimeout(function(){
                            $.unblockUI();
                        },1000);
                        location.reload();
                    }
                })
                .catch(function (response) {
                  self.fails = true;
                  self.errors = response.data;
                  self.showMessage('Kindly Give Feedback of All Questions to submit form !!');
                    setTimeout(function(){
                        $.unblockUI();
                    },3000);
              })
              .then(function() {
                  this.saving = false;
              });

            },

            getFeedbackRatingStatus: function(question_id,rating){
                var self = this;
                var status = false;
                self.student_feedback.forEach(function(e){
                    if(e.question_id == question_id && e.std_id == self.std_id && e.rating == rating){
                        status = true;
                    }
                });
                return status;
            },

            showMessage:function(msg){
                 $.blockUI({ 
                    message: msg,
                    baseZ: 4000, 
                    css: { 
                        border: 'none', 
                        padding: '15px', 
                        backgroundColor: '#000', 
                        '-moz-border-radius': '10px', 
                        opacity: .5, 
                        color: '#fff' 
                    } 
                }); 
            },



        }
    });
</script>
@stop
