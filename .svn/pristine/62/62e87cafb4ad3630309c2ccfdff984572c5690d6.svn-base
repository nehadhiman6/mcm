<template id="bs-modal-honour">
    <div class="modal fade" id="honourModal" tabindex="-1" role="dialog" aria-labelledby="honourModalLabel" data-backdrop="false">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header with-border">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="rollnoModalLabel">Update RollNo</h4>
        </div>
         {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
         <div class="modal-body" >
           <div class="form-group">
             {!! Form::label('name','Name',['class' => 'col-sm-3 control-label']) !!}
             <div class="col-sm-4">
               <p class="form-control-static">@{{ student.name }}</p>
             </div>
           </div>
           <div class="form-group">
             {!! Form::label('class','Class',['class' => 'col-sm-3 control-label']) !!}
             <div class="col-sm-4">
               <p class="form-control-static">@{{ (student && student.course) ? student.course.course_name : '' }}</p>
             </div>
           </div>
           <div class="form-group">
             {!! Form::label('roll_no','Roll No',['class' => 'col-sm-3 control-label required']) !!}
             <div class="col-sm-2">
               <p class="form-control-static">@{{ student.roll_no }}</p>
               <!-- <input :value = "student.roll_no" type="text" class="form-control"></input> -->
             </div>
           </div>
           <div class="form-group">
              {!! Form::label('honour_sub_id','Honour Subject:',['class' => 'col-sm-3 control-label']) !!}
              <div class="col-sm-8">
                <select class="form-control" v-model='honour_sub_id'>
                  <option value="0">Select Subject</option>
                  <option v-for="sub in honoursSubjects" :value="sub.subject_id">@{{ sub.subject.subject }}</option>
                </select>
                  <!--<strong> @{{ showCompSubs }} </strong>-->
              </div>
           </div>
           <div class="alert alert-success alert-dismissible" role="alert" v-if="success">
             <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <strong>Success!</strong> @{{ response['success'] }}
           </div>
           <ul class="alert alert-error alert-dismissible" role="alert" v-if="hasErrors()">
             <li v-for='error in errors'>@{{ error[0] }}<li>
           </ul>
        </div>
         <div class="modal-footer">
           {!! Form::submit('UPDATE',['class' => 'btn btn-primary pull-left','@click.prevent'=>'updateRollNo']) !!}
           
           {!! Form::close() !!}
           <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
         </div>
      </div>
    </div>
  </div>
</template>

@push('vue-components')
<script>
  Vue.component('honour-modal', {
    template: '#bs-modal-honour',
    props: [],
    data: function () {
        return {
          student_id: 0,
          row: 0,
          col: 0,
          student: {},
          honour_sub_id: 0,
          honoursSubjects: [],
          errors: {},
          success: false,
          response: {}
        }
    },
    
    methods: {
      getStudent: function() {
        this.errors = {};
        this.$http['get']("{{ url('students') }}/" + this.student_id + '/edithon')
          .then(function (response) {
            self = this;
            if(response.data.success) {
              this.student = response.data.student;
              this.honour_sub_id = this.student.adm_entry.honour_sub_id;
              this.honoursSubjects = response.data.honoursSubjects;
              $('#honourModal').modal('show');
            }
          }, function (response) {
            this.fails = true;
            self = this;
            if(response.status == 422) {
              this.errors = response.data;
            }              
          });
      },
      
      updateRollNo: function() {
          this.errors = {};
            this.$http['patch']("{{ url('students') }}/" + this.student_id + '/updatehon', { std_id: this.student.id, honour_sub_id: this.honour_sub_id })
            .then(function (response) {
              self = this;
              if(response.data.success) {
                this.response = response.data;
                this.success = true;
                if(response.data.roll_no)
                  dashboard.table.cell(this.row, this.col).data(response.data.roll_no).draw();
                setTimeout(function() {
                  self.success = false;
                  $('#rollnoModal').modal('hide');
                  self.student_id = 0;
                  self.response = {};
                }, 3000);
              }
            }, function (response) {
              this.fails = true;
              self = this;
              if(response.status == 422) {
                this.errors = response.data;
              }              
            });
      },
      
      hasErrors: function() {
        console.log(this.errors && _.keys(this.errors).length > 0);
        if(this.errors && _.keys(this.errors).length > 0)
          return true;
        else
          return false;
      },
    },
    events: {
      'show-honour': function(student_id, row, col) {
        // `this` in event callbacks are automatically bound
        // to the instance that registered it
        this.student_id = student_id;
        this.row = row;
        this.col = col;
        this.getStudent();
      }
    
    }
  });
  
</script>
@endpush