@extends($dashboard)
@section('content')
<div class='panel panel-default'>
  <div class='panel-heading'>
    <strong>Alumni Detail</strong>
  </div>
  <div class='panel-body' id="#app">
    <fieldset>
      <legend>Alumni Details</legend>
        <div class="col-sm-4">
            <p><strong class='p-head'>Name:</strong> {{ $alumni->name }}</p>
            <p><strong class='p-head'>Father's Name:</strong> {{ $alumni->father_name }}</p>
            <p><strong class='p-head'>Mobile:</strong> {{ $alumni->mobile }}</p>
        </div>
        <div class="col-sm-4">
            <p><strong class='p-head'>Date Of Birth:</strong> {{ $alumni->dob }}</p>
            <p><strong class='p-head'>Mother's Name:</strong> {{ $alumni->mother_name }}</p>
            <p><strong class='p-head'>Email:</strong> {{$alumni->email}}</p>
        </div>
        <div class="col-sm-4">
            <p><strong class='p-head'>Gender:</strong> {{$alumni->gender}}</p>
            <p><strong class='p-head'>Address:</strong> {{ $alumni->per_address }}</p>
            <p><strong class='p-head'>PU Pupin No:</strong> {{$alumni->pu_pupin}}</p>
        </div>
        <div class="col-sm-4">
            <p><strong class='p-head'>PU Reg No:</strong> {{ $alumni->pu_regno }}</p>
        </div>
    </fieldset>
    <fieldset>
        <legend>Qualifications</legend>
        <fieldset>
            <legend><h4>Graduation</h4></legend>
            @foreach($alumni->graduatecourse as $graduatecourse)
                <div class="col-sm-12">
                    <div class="col-sm-4"><strong class='p-head'>Course:</strong> {{ graduateCourses($graduatecourse->course_id) }}</div>
                    <div class="col-sm-4"><strong class='p-head'>Passing Year:</strong> {{ $graduatecourse->passing_year }}</div>
                    <div class="col-sm-4"><strong class='p-head'>MCM College:</strong> {{ $graduatecourse->mcm_college == "Y" ? 'Yes' : 'No'}}</div>
                </div>
                <div class="col-sm-12">
                    @if($graduatecourse->mcm_college == 'N')
                    <div class="col-sm-4"><strong class='p-head'>Institute:</strong> {{ $graduatecourse->other_institute }}</div>
                    @endif
                </div>
            @endforeach
        </fieldset>
        @if(count($alumni->postgradcourses))
        <fieldset>
                <legend><h4>Post Graduation</h4></legend>
                @foreach($alumni->postgradcourses as $postgradcourses)
                    <div class="col-sm-12">
                        <div class="col-sm-4"><strong class='p-head'>Course:</strong> {{ postGraduateCourses($postgradcourses->course_id) }}</div>
                        <div class="col-sm-4"><strong class='p-head'>Passing Year:</strong> {{ $postgradcourses->passing_year }}</div>
                        <div class="col-sm-4"><strong class='p-head'>MCM College:</strong> {{ $postgradcourses->mcm_college == "Y" ? 'Yes' : 'No'}}</div>
                    </div>
                    <div class="col-sm-12">
                        @if($postgradcourses->mcm_college == 'N')
                            <div class="col-sm-4" ><strong class='p-head'>Institute:</strong> {{ $postgradcourses->other_institute }}</div>
                        @endif
                    </div>
                @endforeach
        </fieldset>
        @endif
        {{-- <fieldset>
                <legend><h4>Professional Courses</h4></legend>
                @foreach($alumni->professionalcourses as $professionalcourses)
                    <div class="col-sm-12">
                        <div class="col-sm-4"><strong class='p-head'>Course:</strong> {{ professionalCourses($professionalcourses->course_id) }}</div>
                        <div class="col-sm-4"><strong class='p-head'>Passing Year:</strong> {{ $professionalcourses->passing_year }}</div>
                        <div class="col-sm-4"><strong class='p-head'>MCM College:</strong> {{ $professionalcourses->mcm_college == "Y" ? 'Yes' : 'No'}}</div>
                    </div>
                    <div class="col-sm-12">
                        @if($professionalcourses->mcm_college == 'N')
                            <div class="col-sm-4" ><strong class='p-head'>Institute:</strong> {{ $professionalcourses->other_institute }}</div>
                        @endif
                    </div>
                @endforeach
        </fieldset> --}}
        {{-- <fieldset>
                <legend><h4>Research Degrees</h4></legend>
                @foreach($alumni->researches as $researches)
                    <div class="col-sm-12">
                        <div class="col-sm-4"><strong class='p-head'>Course:</strong> {{ researchCourses($researches->course_id) }}</div>
                        <div class="col-sm-4"><strong class='p-head'>Passing Year:</strong> {{ $researches->passing_year }}</div>
                        <div class="col-sm-4"><strong class='p-head'>MCM College:</strong> {{ $researches->mcm_college == "Y" ? 'Yes' :'No'}}</div>
                    </div>
                    <div class="col-sm-12">
                        @if($researches->mcm_college == 'N')
                            <div class="col-sm-4" v-if="{{$researches->other_institute}}"><strong class='p-head'>Institute:</strong> {{ $researches->other_institute }}</div>
                        @endif
                    </div>
                @endforeach
        </fieldset>
    </fieldset>
    <fieldset>
            <legend>Experience</legend>
            @foreach($alumni->almexperience as $exp)
                <div class="col-sm-12">
                    <div class="col-sm-4"><strong class='p-head'>Organization:</strong> {{ $exp->org_name }}</div>
                    <div class="col-sm-4"><strong class='p-head'>Employment Type:</strong> {{ $exp->emp_type }}</div>
                    <div class="col-sm-4"><strong class='p-head'>Start Date :</strong> {{ $exp->start_date }}</div>
                    @if($exp->currently_working == "N")
                        <div class="col-sm-4" ><strong class='p-head'>Leave Date :</strong> {{ $exp->end_date }}</div>
                    @endif
                </div>
            @endforeach
        </fieldset> --}}
    <div class="col-sm-12">
        @if(isset($guard) && $guard == 'alumnies')
        <a href="{{ url('alumni-student/' . $alumni->id . '/edit') }}" 
            class="btn btn-primary" id="add_attachment">
            Edit Detail
        </a>
        {{-- <a href="{{ url('alumni-student/' . $alumni->id ) }}" 
            class="btn btn-primary" id="add_attachment">
            Preview
        </a> --}}
        @endif
    </div>
</div>
    <!--<button class="btn btn-primary" id="add_attachment">Add Attachment</button>-->
  
</div>
@stop

@section('script')
    <script>
        var vm = new Vue({
            el:"#app",
        });
    </script>
@stop

