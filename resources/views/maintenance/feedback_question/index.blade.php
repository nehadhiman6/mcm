@extends('app')
@section('toolbar')
@include('toolbars._maintenance_toolbars')
@stop
@section('content')
<div id="app">
    @can('ADD-FEEDBACK-QUESTIONS')
        @if(isset($feedback_question))
            @include('maintenance.feedback_question.edit')
        @else
            @include('maintenance.feedback_question.create')
        @endif
    @endcan
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Feedback Sections</h3>
        </div>
        <div class="box-body">
            <table class='table table-bordered' id="example1">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($feedback_questions as $feedback_que)
                    <tr>
                        <td>{{$feedback_que->sno}}</td>
                        <td>{{$feedback_que->question}}</td>
                        <td>{{$feedback_que->feedback_section->name or ''}}</td>
                        @can('ADD-FEEDBACK-QUESTIONS')
                            <td><a href="{{ url('feedback-questions/' . $feedback_que->id . '/edit') }}" class="btn btn-primary btn-xs">Edit</a></td>
                        @endcan
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
@section('script')
<script>
    var vm = new Vue({
        el: '#app',
        data: {
            feedback_section: {!! isset($feedback_question) ? $feedback_question : 0 !!},
            sections: {!! App\Models\Maintenance\FeedbackSection::whereUnderSectionId(0)->with('sub_sections')->get() !!},
            section_id: {!! isset($feedback_question) ? $feedback_question->section_id : 0 !!},
            sub_section_id: {!! isset($feedback_question) ? $feedback_question->section_id : 0 !!},
        },
        ready:function(){
            $('#example1').DataTable();
            var self = this;
            if(self.feedback_section != 0){
                self.section_id = self.feedback_section.feedback_section.under_section_id;
            }
        },
        computed: {
            sub_sections: function() {
                var self = this;
                var secs = [];
                $.each(this.sections, function(i, s) {
                    if(s.id == self.section_id) {
                        secs = s.sub_sections;
                    }
                });
                return secs;
            }
        }
        
    });
</script>
@stop