
<div class="form-group">
    {!! Form::label('question','Question',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-8">
      {!! Form::text('question',null,['class' => 'form-control no-upper-case', 'id'=> 'noUpperCase']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('section_id','Section',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      <select name="section_id" id="section_id" class="form-control" v-model="section_id">
        <option value="0">Select Section</option>
        <option v-for="s in sections" value="@{{ s.id }}">@{{ s.name }}</option>
      </select>
      {{-- {!! Form::select('section_id',[''=>'Select Section'] + getFeedbackSections(false,'zero'),null, ['class' => 'form-control', '@change'=> 'getSubSections()']) !!} --}}
    </div>
    {!! Form::label('section_id','Sub-Section',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3" >
        <select name="sub_section_id" id="sub_section_id" class="form-control" v-model="sub_section_id">
            <option value="0">Select Section</option>
            <option v-for="s in sub_sections" value="@{{ s.id }}">@{{ s.name }}</option>
          </select>
          {{-- {!! Form::select('section_id',[''=>'Select Section'] + getFeedbackSections(false,'zero'),null, ['class' => 'form-control', '@change'=> 'getSubSections()']) !!} --}}
    </div>
  </div>
  <div class="form-group">
    {!! Form::label('sno','SR NO.',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-2">
      {!! Form::text('sno',null,['class' => 'form-control']) !!}
    </div>
</div>
  
  