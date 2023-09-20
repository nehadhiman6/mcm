@extends('app')
@section('toolbar')
@include('toolbars._students_toolbar')
@stop
@section('content')
<div id='app' v-cloak>
  <div class="box box-default box-solid">
    <div class="box-header with-border">
      Filter
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
          <i class="fa fa-minus"></i></button>
      </div>
    </div>
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="box-body">
      <div class="form-group">
        {!! Form::label('type','Type',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-2">
          {!! Form::select('type',['0'=> 'Select', 'overall' => 'Overall', 'student_wise' => 'Student Wise','student_suggestion' => 'Student Suggestion'],null,['class' => 'form-control', 'v-model' => 'type', '@change'=>'changeTableView']) !!}
        </div>
      </div>
    </div>
    <div class="box-footer">
      {!! Form::submit('SHOW',['class' => 'btn btn-primary', '@click.prevent' => 'getDataByType']) !!}
      {!! Form::close() !!}
    </div>
  </div>
  <div class="panel panel-default" v-show="showOverall">
    <div class='panel-heading'>
      <strong>Overall Report</strong>
    </div>
    <div class="panel-body">
      <table id="example1" class="table table-bordered" width="100%"></table>
    </div>
  </div>
  <div class="panel panel-default" v-show="showStuWise">
    <div class='panel-heading'>
      <strong>Student Wise Report</strong>
    </div>
    <div class="panel-body">
      <table id="example2" class="table table-bordered" width="100%">
        <thead>
          <tr>
            <th>SNo</th>
            <th>Roll No.</th>
            <th>Name</th>
            <th v-for='q in questions'><span style="max-width:500px;white-space: initial;">@{{ q.question.substring(0,30)+'('+q.feedback_section.name.substring(0,7)+')' }}</span></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="s in students">
            <td>@{{ $index+1 }}</td>
            <td>@{{ s.roll_no }}</td>
            <td>@{{ s.name }}</td>
            <td v-for='q in questions'>
              @{{ getFeedback(q.id, s.feedback) }}
            </td>
          </tr>
        </tbody>
        
      </table>
    </div>
  </div>

  <div class="panel panel-default" v-show="showSuggestion">
    <div class='panel-heading'>
      <strong>Student Suggestion Report</strong>
    </div>
    <div class="panel-body">
      <table id="example3" class="table table-bordered" width="100%">
        <thead>
          <tr>
            <th style="min-width:20px">SNo</th>
            <th style="min-width:150px">Class</th>
            <th style="min-width:150px">Roll No.</th>
            <th style="min-width:200px">Name</th>
            <th style="min-width:400px">Suggestion</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="s in suggestion">
            <td>@{{ $index+1 }}</td>
            <td>@{{ s.course_name }}</td>
            <td>@{{ s.roll_no }}</td>
            <td>@{{ s.name }}</td>
            <td>@{{ s.suggestion }}</td>
          </tr>
        </tbody>
        
      </table>
    </div>
  </div>
</div>
@stop
@section('script')
<script>
  var q_rating = ['Poor','Good', 'Very Good', 'Excellent','Average'];
  var dashboard = new Vue({
    el: '#app',
    data: {
      tData1: [],
      tData2: [],
      table1: null,
      table2: null,
      questions: [],
      students: [],
      suggestion:[],
      success: false,
      fails: false,
      showOverall: false,
      showStuWise: false,
      showSuggestion: false,
      errors: {},
      type: '',
      showTable: false,
      sections: {!! getAllFeedbackSections(true) !!},
    },
    ready:function(){
        this.setDataTable1();
    },
    methods: {
      changeTableView: function(){
        var self = this;
        if(self.type == 'overall'){
          self.showOverall = true;
          self.showStuWise = false;
          self.showSuggestion = false;
        }else if(self.type == 'student_wise'){
          self.showOverall = false;
          self.showStuWise = true;
          self.showSuggestion = false;
        }
        else{
          self.showOverall = false;
          self.showStuWise = false;
          self.showSuggestion = true;
        }
      },

      getDataByType: function(){
        var self = this;
        if(self.type == 'overall'){
          self.getOverallData();
        }else if(self.type == 'student_wise'){
          self.getStudentWiseFeedbackData();
        }
        else{
          self.getStudentWiseFeedbackSuggestionData();
        }
      },

      getOverallData: function(){
        var self = this;
          self.$http.get("{{ url('student-feedback-overall') }}")
            .then(function (response) {
              self.showOverall = true;
              self.showStuWise = false;
              self.tData1 = response.data.overall_stu_feed;
              self.reloadTable1();
              setTimeout(function(){
                $('#example1').DataTable().columns.adjust();
              },100);
            }, function (error) {
          });
      },

      setDataTable1: function(){
        var self = this;
        var target = 0;
        $('#example1').append('<tfoot>'+'<th></th>'.repeat(10)+'</tfoot>')
        self.table1 = $('#example1').DataTable({
          dom: 'Bfrtip',
          lengthMenu: [
              [ 10, 25, 50, -1 ],
              [ '10 rows', '25 rows', '50 rows', 'Show all' ]
          ],
          buttons: [
            'pageLength',
              {
                  extend: 'excelHtml5',
                  exportOptions: { orthogonal: 'export' }
              },
              {
                header: true,
                footer: true,
                extend: 'pdfHtml5',
                download: 'open',
                title: 'Student Feedback',
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: { orthogonal: 'export' }
            }
            ],
          "processing": true,
          "scrollCollapse": true,
          "ordering": true,
          data: [],
          columnDefs: [
            { title: 'S.No.', targets: target++,
              "render": function( data, type, row, meta) {
                return meta.row + 1;
              }},
              { title: 'Section', targets: target++,
              "render": function( data, type, row, meta) {
                var section = '';
                if(row.feedback_section.under_section_id > 0){
                  section = self.getSectionName(row.feedback_section.under_section_id);
                }else{
                  section = row.feedback_section.name;
                }
                return section;
              }},
              { title: 'Sub-Section', targets: target++,data: 'feedback_section',
              "render": function( data, type, row, meta) {
                var name = '';
                if(data.under_section_id > 0){
                  name = data.name;
                }
                return name;
              }},
              { title: 'Questions', targets: target++,
              "render": function( data, type, row, meta) {
                return row.question;
              }},
              { title: 'Poor', targets: target++, data: 'student_feedback',
              "render": function( data, type, row, meta) {
                var poor_count = 0;
                if(row.student_feedback.length > 0){
                  row.student_feedback.forEach(function(e){
                    if(e.rating == 1){
                      poor_count++;
                    }
                  });
                }
                return poor_count;
              }},
              { title: 'Average', targets: target++, data: 'student_feedback',
              "render": function( data, type, row, meta) {
                var poor_count = 0;
                if(row.student_feedback.length > 0){
                  row.student_feedback.forEach(function(e){
                    if(e.rating == 5){
                      poor_count++;
                    }
                  });
                }
                return poor_count;
              }},
              { title: 'Good', targets: target++,data: 'id',
              "render": function( data, type, row, meta) {
                var good_count = 0;
                if(row.student_feedback.length > 0){
                  row.student_feedback.forEach(function(e){
                    if(e.rating == 2){
                      good_count++;
                    }
                  });
                }
                return good_count;
              }},
              { title: 'Very Good', targets: target++,data: 'id',
              "render": function( data, type, row, meta) {
                var very_count = 0;
                if(row.student_feedback.length > 0){
                  row.student_feedback.forEach(function(e){
                    if(e.rating == 3){
                      very_count++;
                    }
                  });
                }
                return very_count;
              }},
              { title: 'Excellent', targets: target++, data: 'id',
              "render": function( data, type, row, meta) {
                var excellent_count = 0;
                if(row.student_feedback.length > 0){
                  row.student_feedback.forEach(function(e){
                    if(e.rating == 4){
                      excellent_count++;
                    }
                  });
                }
                return excellent_count;
              }},
              { title: 'Total', targets: target++,data: 'id',
              "render": function( data, type, row, meta) {
                var count = 0;
                if(row.student_feedback.length > 0){
                  count = row.student_feedback.length;
                }else{
                  count = 0;
                }
                return count;
              }},
            
            { targets: '_all', visible: true }
          ],
          //      "deferRender": true,
          "sScrollX": true,
          "footerCallback": function ( row, data, start, end, display ) {
              var api = this.api();
              var intVal = function ( i ) {
                  return typeof i === 'string' ?
                      i.replace(/[\$,]/g, '')*1 :
                      typeof i === 'number' ?
                          i : 0;
              };

              rating = {
                for_1: 0,
                for_5: 0,
                for_2: 0,
                for_3: 0,
                for_4: 0,
                
              };
              var total = api
                    .column(5)
                    .data()
                    .each(function (e, i) {
                      e.forEach(function(v, index) {
                        if(v.rating) {
                          rating['for_'+v.rating]++;
                        }
                      });
                    });
              $(api.column(4).footer()).html(rating.for_1);
              $(api.column(5).footer()).html(rating.for_5);
              $(api.column(6).footer()).html(rating.for_2);
              $(api.column(7).footer()).html(rating.for_3);
              $(api.column(8).footer()).html(rating.for_4);
              $(api.column(9).footer()).html(rating.for_1+rating.for_5+rating.for_2+rating.for_3+rating.for_4);
              return;
          }
        });
      },

      reloadTable1: function() {
        this.table1.clear();
        // this.tData1 = this.overall_stu_feed;
        this.table1.rows.add(this.tData1).draw();
      },

      getStudentWiseFeedbackData: function(){
        var self = this;
          self.$http.get("{{ url('student-wise-feedback') }}")
            .then(function (response) {
              self.showOverall = false;
              self.showStuWise = true;
              self.students = response.data.students;
              self.questions = response.data.questions;
            }, function (response) {
          });
      },

      getStudentWiseFeedbackSuggestionData: function(){
        var self = this;
          self.$http.get("{{ url('student-wise-feedback-suggestion') }}")
            .then(function (response) {
              self.showOverall = false;
              self.showStuWise = false;
              self.showSuggestion = true;
              self.suggestion = response.data.students;
            }, function (response) {
          });
      },

      getFeedback(question_id, feedback) {
        var rating = 'NA';
        feedback.every(function(ele, index) {
          if(ele.question_id === question_id) {
            rating = q_rating[ele.rating - 1];
            // return false;
          }
          return ele.question_id !== question_id;
        });
        return rating;
      },

      getSectionName:function(id){
        var name = '';
        this.sections.forEach(function(e){
          if(id == e.id){
            name =  e.name;
          }
        });
        return name;
      }
    }
  });
</script>
@stop