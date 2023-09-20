
<div class="form-group row">
    {!! Form::label('type','Types', ['class' => 'control-label col-sm-2 required'])!!}
    <div class="col-md-4 "  v-bind:class="{ 'has-error': errors['research.type'] }"> 
        {!! Form::select('type',getResearchType(),null, array('required', 'class'=>'form-control','v-model'=>'research.type')) !!}
        <span id="basic-msg" v-if="errors['research.type']" class="help-block">@{{ errors['research.type'][0] }}</span>
    </div>
    <!-- {!! Form::label('title1','Title1', ['class' => 'control-label col-sm-2 required'])!!} -->
    <label for="title1" class="control-label col-sm-2 required">@{{title1}}</label>
    <div class="col-md-4 "  v-bind:class="{ 'has-error': errors['research.title1'] }"> 
        {!! Form::text('title1',null, array('required',  'class'=>'form-control','v-model'=>'research.title1')) !!}
        <span id="basic-msg" v-if="errors['research.title1']" class="help-block">@{{ errors['research.title1'][0] }}</span>
    </div>
</div>

<div class="form-group row">
   
    <!-- {!! Form::label('title2','Title2', ['class' => 'control-label col-sm-2 required'])!!} -->
    <span v-show="research.type != 'Book'">
        <label for="title2" class="control-label col-sm-2 required">@{{title2}}</label>
        <div class="col-md-4"  v-bind:class="{ 'has-error': errors['research.title2'] }"> 
            {!! Form::text('title2',null, array('class'=>'form-control','v-model'=>'research.title2','placeholder' => 'Enter "NA" (if not applicable)')) !!}
            <span id="basic-msg" v-if="errors['research.title2']" class="help-block">@{{ errors['research.title2'][0] }}</span>
        </div>
    </span>
    <span v-show="research.type == 'Conference Paper'">
    {!! Form::label('title3','Title of the Conference Proceedings', ['class' => 'control-label col-sm-2 '])!!}
    <div class="col-md-4 "  v-bind:class="{ 'has-error': errors['research.title3'] }"> 
        {!! Form::text('title3',null, array('class'=>'form-control','v-model'=>'research.title3')) !!}
        <span id="basic-msg" v-if="errors['research.title3']" class="help-block">@{{ errors['research.title3'][0] }}</span>
    </div>
    </span>
</div> 

<div class="form-group row">
    <span v-show="research.type == 'Conference Paper'">
    {!! Form::label('paper_status','Status of Paper', ['class' => 'control-label col-sm-2'])!!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="research.paper_status">
            <option value="" Selected>Select</option>
            <option value="Presented">Presented</option>
            <option value="Published">Published</option>
            <option value="Presented & Published">Presented & Published (both)</option>
        </select>
        <span id="basic-msg" v-if="errors['research.paper_status']" class="help-block">@{{ errors['research.paper_status'][0] }}</span>
    </div>
    </span>
    {!! Form::label('level','Level', ['class' => ' control-label col-sm-2 required'])!!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['research.level'] }">
        <select class="form-control select-form" v-model="research.level" >
            <option value="" Selected>Select</option>
            <option value="International">International</option>
            <option value="National">National</option>
            <option value="State">State</option>
            <option value="Local">Local</option>
            <!-- <option value="Regional">Regional</option> -->
        </select>
        <span id="basic-msg" v-if="errors['research.level']" class="help-block">@{{ errors['research.level'][0] }}</span>
    </div>
  
</div> 

<div class="form-group row" >
    {!! Form::label('publisher','Publisher', ['class' => 'control-label col-sm-2 '])!!}
    <div class="col-md-4"  v-bind:class="{ 'has-error': errors['research.publisher'] }"> 
        {!! Form::text('publisher',null, array('class'=>'form-control','v-model'=>'research.publisher')) !!}
        <span id="basic-msg" v-if="errors['research.publisher']" class="help-block">@{{ errors['research.publisher'][0] }}</span>
    </div>
    <!-- {!! Form::label('pub_date','Year of publication/presentation', ['class' => ' control-label col-sm-2 required'])!!} -->
    <label for="title1" class="control-label col-sm-2 required">@{{title3}}</label>
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research..pub_date'] }"> 
        {!! Form::text('pub_date',null,array('class' => 'form-control app-datepicker', 'v-model'=>'research.pub_date')) !!}
        <span id="basic-msg" v-if="errors['research.pub_date']" class="help-block">@{{ errors['research.pub_date'][0] }}</span>
        <span style="color:red;">If day is not known, choose 1 as day of the date</span>
    </div>
   
   
</div>

<div class="form-group row" >
    {!! Form::label('pub_mode','Mode of publication', ['class' => ' control-label col-sm-2 '])!!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['research.pub_mode'] }">
        <select class="form-control select-form" v-model="research.pub_mode">
            <option value="" Selected>Select</option>
            <option value="Offline">Offline</option>
            <option value="Online">Online</option>
            <option value="Print">Print</option>
            <option value="Both">Both(Online & Print)</option>
            
        </select>
        <span id="basic-msg" v-if="errors['research.pub_mode']" class="help-block">@{{ errors['research.pub_mode'][0] }}</span>
    </div>
    {!! Form::label('isbn','ISBN/ISSN', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.isbn'] }"> 
        {!! Form::text('isbn',null, array('required', 'class'=>'form-control','v-model'=>'research.isbn')) !!}
        <span id="basic-msg" v-if="errors['research.isbn']" class="help-block">@{{ errors['research.isbn'][0] }}</span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('authorship','Authorship', ['class' => 'control-label col-sm-2 required'])!!}
    <div class="col-sm-4" v-bind:class="{ 'has-error': errors['research.authorship'] }">
        <select class="form-control select-form" v-model="research.authorship">
            <option value="" Selected>Select</option>
            <option value="Sole Author">Sole Author</option>
            <option value="First Author">First Author</option>
            <option value="Co-author">Co-Author</option>
            <option value="Corres-author">Corres-author</option>
            <option value="Editor">Editor</option>
            <option value="Co-Editor">Co-editor</option>
            <option value="Reviewer">Reviewer</option>

            
        </select>
        <span id="basic-msg" v-if="errors['research.authorship']" class="help-block">@{{ errors['research.authorship'][0] }}</span>
    </div>
    {!! Form::label('institute','Affiliating institute', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.institute'] }"> 
        {!! Form::text('institute',null, array('required', 'class'=>'form-control','placeholder' => 'At the time of publication/presentation','v-model'=>'research.institute')) !!}
        <span id="basic-msg" v-if="errors['research.institute']" class="help-block">@{{ errors['research.institute'][0] }}</span>
    </div>
</div>

<div class="form-group row">
    {!! Form::label('ugc_approved','UGC Approved/Not Approved', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="research.ugc_approved">
            <option value="" Selected>Select</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
            <option value="NA">NA</option>
        </select>
        <span id="basic-msg" v-if="errors['research.ugc_approved']" class="help-block">@{{ errors['research.ugc_approved'][0] }}</span>

    </div>
    
    {!! Form::label('peer_review','Peer Reviewed',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select-form" v-model="research.peer_review">
            <option value="" Selected>Select</option>
            <option value="Y">Yes</option>
            <option value="N">No</option>
            
        </select>
        <span id="basic-msg" v-if="errors['research.peer_review']" class="help-block">@{{ errors['research.peer_review'][0] }}</span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('indexing','Indexing',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control select2" id='indexing'  multiple="multiple">
            <option value="Scopus">Scopus</option>
            <option value="Web of Science">Web of Science</option>
            <option value="SCI">SCI</option>
            <option value="ESCI">ESCI</option>
            <option value="MEDLINE">MEDLINE</option>
            <option value="Others">Others</option>
        </select>
        <span id="basic-msg" v-if="errors['research.indexing']" class="help-block">@{{ errors['research.indexing'][0] }}</span>
        <span style="color:red;"> Multi Select *</span>
    </div>
    <span v-show="getIndexing()">
        {!! Form::label('indexing_other','Other Indexing', ['class' => ' control-label col-sm-2'])!!}
            <div class="col-md-4 " v-bind:class="{ 'has-error': errors['indexing_other'] }"> 
            {!! Form::text('indexing_other',null, array('class'=>'form-control','v-model'=>'research.indexing_other')) !!}
            <span id="basic-msg" v-if="errors['research.indexing_other']" class="help-block">@{{ errors['research.indexing_other'][0] }}</span>
            </div>
    </span>
</div>

<div class="form-group row">
    
    {!! Form::label('doi_no','DOI no.', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['esearch.doi_no'] }"> 
        {!! Form::text('doi_no',null, array('class'=>'form-control','v-model'=>'research.doi_no')) !!}
        <span id="basic-msg" v-if="errors['esearch.doi_no']" class="help-block">@{{ errors['esearch.doi_no'][0] }}</span>
    </div>

</div>
<div class="form-group row">
    {!! Form::label('impact_factor','Impact Factor', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.impact_factor'] }"> 
        {!! Form::text('impact_factor',null, array('class'=>'form-control','v-model'=>'research.impact_factor')) !!}
        <span id="basic-msg" v-if="errors['research.impact_factor']" class="help-block">@{{ errors['research.impact_factor'][0] }}</span>
    </div>
    {!! Form::label('citations','Citations (Excluding self-citations)', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.citations'] }"> 
        {!! Form::text('citations',null, array('class'=>'form-control','v-model'=>'research.citations')) !!}
        <span id="basic-msg" v-if="errors['research.citations']" class="help-block">@{{ errors['research.citations'][0] }}</span>
    </div>
</div> 

<div class="form-group row">
    {!! Form::label('h_index','H-index', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.h_index'] }"> 
        {!! Form::text('h_index',null, array('class'=>'form-control','v-model'=>'research.h_index')) !!}
        <span id="basic-msg" v-if="errors['research.h_index']" class="help-block">@{{ errors['research.h_index'][0] }}</span>
    </div>
    {!! Form::label('i10_index','i10 Index', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-4 " v-bind:class="{ 'has-error': errors['research.i10_index'] }"> 
        {!! Form::text('i10_index',null, array('class'=>'form-control','v-model'=>'research.i10_index')) !!}
        <span id="basic-msg" v-if="errors['research.i10_index']" class="help-block">@{{ errors['research.i10_index'][0] }}</span>
    </div>
</div>
<div class="form-group row">
    {!! Form::label('res_award','Award (if any)',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
        <select class="form-control" name="res_award" v-model="research.res_award">
            <option value="" Selected>Select</option>
            <option value="Best Paper Award - Ist">Best Paper Award - Ist</option>
            <option value="Best Paper Award - 2nd">Best Paper Award - 2nd</option>
            <option value="Appreciation">Appreciation</option>
        </select>
        <span id="basic-msg" v-if="errors['research.res_award']" class="help-block">@{{ errors['research.res_award'][0] }}</span>
        
    </div>
</div>
<div class="form-group row">
    {!! Form::label('relevant_link','Relevant link of Research Paper', ['class' => ' control-label col-sm-2'])!!}
    <div class="col-md-10 " v-bind:class="{ 'has-error': errors['research.relevant_link'] }"> 
        {!! Form::text('relevant_link',null, array('class'=>'form-control','placeholder'=>'Web URL or Google Drive link','v-model'=>'research.relevant_link')) !!}
        <span id="basic-msg" v-if="errors['research.relevant_link']" class="help-block">@{{ errors['research.relevant_link'][0] }}</span>
    </div>

    <!-- {!! Form::button('Remove',['class' => 'btn btn-success', '@click.prevent' => 'removeResearchRow($index)','v-if'=>'$index > 0']) !!} -->
</div>

<!-- <div class="form-group row">
    <div class="col-sm-12">
    {!! Form::button('Add Research',['class' => 'btn btn-success pull-right', '@click' => 'addResearchRow']) !!}
    </div>
</div> -->

