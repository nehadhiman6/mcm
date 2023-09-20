<template id="for-mig-alumni-template">
<div>
    <fieldset v-if="foreign_national == 'Y'">
        <legend><strong>For Foreign Students Only</strong></legend>
        <div class='form-group'>
        {!! Form::label('foreign_national','Foreign National',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-1 checkbox-inline">
            <input type="checkbox" disabled readonly name="foreign_national"  v-model='foreign_national' 
                v-bind:true-value="'Y'"
                v-bind:false-value="'N'"
                class="minimal" />
        </div>
        </div>
        <div class="form-group">
        {!! Form::label('icssr_sponser','ICSSR Sponser',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-4 " v-bind:class="{ 'has-error': errors['icssr_sponser'] }">
            <label class="radio-inline">
                {!! Form::radio('icssr_sponser', 'Y',null, ['class' => 'minimal','v-model'=>'icssr_sponser']) !!}
                Yes
            </label>
            <label class="radio-inline">
                {!! Form::radio('icssr_sponser', 'N',null, ['class' => 'minimal','v-model'=>'icssr_sponser']) !!}
                No
            </label>
            <span id="basic-msg" v-if="errors['icssr_sponser']" class="help-block">@{{ errors['icssr_sponser'][0] }}</span>
            </div>
        </div>
        <div class="form-group">
        {!! Form::label('equivalence_certificate', 'Equivalence Certificate',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-4 " v-bind:class="{ 'has-error': errors['equivalence_certificate'] }">
            <label class="radio-inline">
                {!! Form::radio('equivalence_certificate', 'Y',null, ['class' => 'minimal','v-model'=>'equivalence_certificate']) !!}
                Yes
            </label>
            <label class="radio-inline">
                {!! Form::radio('equivalence_certificate', 'N',null, ['class' => 'minimal','v-model'=>'equivalence_certificate']) !!}
                No
            </label>
            <span id="basic-msg" v-if="errors['equivalence_certificate']" class="help-block">@{{ errors['equivalence_certificate'][0] }}</span>
            </div>
        </div>
        <div class='form-group'>
        {!! Form::label('passportno','Passport No.',['class' => 'col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['passportno'] }">
            {!! Form::text('passportno',null,['class' => 'form-control','v-model'=>'passportno']) !!}
            <span id="basic-msg" v-if="errors['passportno']" class="help-block">@{{ errors['passportno'][0] }}</span>
        </div>
        {!! Form::label('passport_validity','Passport Valid upto',['class' => '  col-sm-2 control-label']) !!}
        <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['passport_validity'] }">
            {!! Form::text('passport_validity',null,['class' => 'app-datepicker form-control','v-model'=>'passport_validity']) !!}
            <span id="basic-msg" v-if="errors['passport_validity']" class="help-block">@{{ errors['passport_validity'][0] }}</span>
        </div>
        </div>
        <div class='form-group'>
            {!! Form::label('visa','Visa No.',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['visa'] }">
                {!! Form::text('visa',null,['class' => 'form-control','v-model'=>'visa']) !!}
                <span id="basic-msg" v-if="errors['visa']" class="help-block">@{{ errors['visa'][0] }}</span>
            </div>
            {!! Form::label('visa_validity','Visa Valid upto',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3"  v-bind:class="{ 'has-error': errors['visa_validity'] }">
                {!! Form::text('visa_validity',null,['class' => 'app-datepicker form-control','v-model'=>'visa_validity']) !!}
                <span id="basic-msg" v-if="errors['visa_validity']" class="help-block">@{{ errors['visa_validity'][0] }}</span>
            </div>
        </div>
        <div class='form-group' v-bind:class="{ 'has-error': errors['res_permit'] }">
            {!! Form::label('res_permit','Resident Permit',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('res_permit',null,['class' => 'form-control','v-model'=>'res_permit']) !!}
                <span id="basic-msg" v-if="errors['res_permit']" class="help-block">@{{ errors['res_permit'][0] }}</span>
            </div>
            {!! Form::label('res_validity','Resident Permit Valid upto',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['res_validity'] }">
                {!! Form::text('res_validity',null,['class' => ' app-datepicker form-control','v-model'=>'res_validity']) !!}
                <span id="basic-msg" v-if="errors['res_permit']" class="help-block">@{{ errors['res_validity'][0] }}</span>
            </div>
        </div>
        
        <div class="row">
        <div class="col-lg-7 "><strong>Please Attach Copy Of Passport And Eligibility Certificate From Punjab University.</strong>
        </div>
        </div>
    </fieldset>
    
    <fieldset >
        <legend><strong>For Migration Cases Only</strong></legend>
        {!! Form::label('migration','Migration',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-1">
            <label class="checkbox">
                <input type="checkbox" name="migration" v-model = 'migration' value='Y' class="minimal" v-bind:true-value="'Y'"
                    v-bind:false-value="'N'">
            </label>
            </div>
        <div v-if="migration == 'Y'">
            <div class="col-sm-12">
            {!! Form::label('migration_certificate','Migrartion certificate',['class' => 'col-sm-2 control-label']) !!}
            <label class="radio-inline">
                {!! Form::radio('migration_certificate', 'A',null, ['class' => 'minimal','v-model'=>'migration_certificate']) !!}
                Attached
            </label>
            <label class="radio-inline">
                {!! Form::radio('migration_certificate', 'W',null, ['class' => 'minimal','v-model'=>'migration_certificate']) !!}
            Awaited
            </label>
            </div>
            {!! Form::label('migrate_from','Former Board/University',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('migrate_from',null,['class' => 'form-control','v-model'=>'migrate_from']) !!}
            </div>
            {!! Form::label('migrate_deficient_sub','Deficient Subject(s)(if Any)',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
            {!! Form::text('migrate_deficient_sub',null,['class' => 'form-control','v-model'=>'migrate_deficient_sub']) !!}
            </div>
            <div class="col-sm-12">
            <p><br>
                <b>Note:- Original copy of migration to be submitted to the college, whenever notified.</b><br>
                    In case of deficient subjects you have to clear the subjects within the permissible chances.
            </p>
            </div>
        </div>
    </fieldset>

    {{-- <fieldset>
        <legend><strong>Alumni</strong></legend>
        (Ex-Student of MCM DAV)
        <div class='form-group'>
        {!! Form::label('alumani','Do you know any Alumna(Ex-student) of this College?',['class' => 'col-sm-4 control-label']) !!}
        <label class="radio-inline">
            {!! Form::radio('know_alumani', 'Y',null, ['class' => 'minimal','v-model'=>'know_alumani']) !!}
            Yes
            </label>
            <label class="radio-inline">
            {!! Form::radio('know_alumani', 'N',null, ['class' => 'minimal','v-model'=>'know_alumani']) !!}
            No
            </label>
        </div>
        <div  v-if="know_alumani == 'Y'">
            <div class='form-group' >
            {!! Form::label('','Name',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                {!! Form::text('',null,['class' => 'form-control','v-model'=>'alumani.name']) !!}
                </div>
                {!! Form::label('passing_year','Year of passing',['class' => 'col-sm-2 control-label']) !!}
                <div class="col-sm-3">
                {!! Form::text('',null,['class' => 'form-control','v-model'=>'alumani.passing_year']) !!}
                </div>
            </div>
            <div class='form-group'>
            {!! Form::label('occupation','Occupation',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('occupation',null,['class' => 'form-control','v-model'=>'alumani.occupation']) !!}
            </div>
            {!! Form::label('designation','Designation',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('designation',null,['class' => 'form-control','v-model'=>'alumani.designation']) !!}
            </div>
            </div>
            <div class='form-group'>
            {!! Form::label('contact','Contact',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('contact',null,['class' => 'form-control','v-model'=>'alumani.contact']) !!}
            </div>
            {!! Form::label('email','Email',['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-3">
                {!! Form::text('email',null,['class' => 'form-control','v-model'=>'alumani.email']) !!}
            </div>
            </div>
            <div class='form-group'>
            {!! Form::label('others','Any Other Information',['class' => 'col-sm-3 control-label']) !!}
            <div class="col-sm-7">
            {!! Form::textarea('others', null, ['size' => '30x2' ,'class' => 'form-control','v-model'=>'alumani.other']) !!}
            </div>
            </div>
        </div>
    </fieldset> --}}
    
     <fieldset v-if="admForm.course.final_year == 'Y' && admForm.course.status == 'PGRAD'">
        <legend><strong>For PG Final Year Students Only</strong></legend>
        <div class='form-group'>
            {!! Form::label('mcm_graduate','Are You Graduated (UG) from MCM DAV CW, Sector 36, Chandigarh',['class' => 'col-sm-5 control-label']) !!}
            <div class="col-sm-1 checkbox-inline">
                <input type="checkbox" name="mcm_graduate"  v-model='mcm_graduate' 
                    v-bind:true-value="'Y'"
                    v-bind:false-value="'N'"
                    class="minimal" />
            </div>
        </div>
    </fieldset>
    {{-- <span id="basic-msg" class="help-block">Please 'Update' data, in case of any changes, before leaving the current tab !</span> --}}
    <span id="basic-msg" class="help-block">Click the "Update" button before leaving the current tab, in case there have been any changes.</span>

    <input v-on:click="rediretPreviousTab" v-show="active_tab >= 4" class="btn btn-primary"  type="button" value="Previous" >
    <input class="btn btn-primary"  type="button" :value="admForm.active_tab >= 5 ? 'Update' : 'Submit'" @click.prevent="submit">
    <input v-on:click="rediretNextTab" v-show="active_tab >= 5" class="btn btn-primary"  type="button" value="Next" >

    <div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-show="hasErrors">
            <li  v-for='error in errors'>@{{ error }} </li>
        </ul>
    </div>

</div>
</template>

@push('vue-components')
    <script>
        var no = 1000;
        var forMigAlumniComponent = Vue.extend({
            template: '#for-mig-alumni-template',
            props:['courses', 'course_id','active_tab', 'form_id', 'admForm'],
            data: function(){
                return {
                    migration: "N" ,
                    foreign_national: "{{ $adm_form->foreign_national == 'Y' ? 'Y' : 'N' }}",
                    passportno: '',
                    passport_validity:'',
                    visa: '',
                    visa_validity:'',
                    res_validity:'',
                    res_permit: '',
                    migration_certificate:"W",
                    migrate_from:'',
                    migrate_deficient_sub:'',
                    know_alumani:"{!! isset($adm_form->alumani) ? 'Y': 'N' !!}",
                    alumani: {!! isset($alumani) ? json_encode($alumani) : " {name:'',passing_year:'',occupation:'', designation:'', contact:'', email:'', other:'' }" !!},
                    icssr_sponser:"N",
                    equivalence_certificate:"N",
                    //basic
                    response: {},
                    success: false,
                    fails: false,
                    msg: '',
                    errors: {},
                    mcm_graduate:'N',
                }
            },
            ready: function(){
                var self = this;
                console.log(self.admForm);
                if(self.admForm && self.admForm.active_tab >= 5){
                    self.setDataForForm(self.admForm);
                }
            },

            computed: {
                hasErrors: function() {
                    return Object.keys(this.errors).length > 0;
                },
            },

            methods:{
                rediretNextTab: function(){
                    $('a[href="#declaration"]').click();
                },

                rediretPreviousTab: function(){
                    $('a[href="#acedmic-detail"]').click();
                },

                submit: function() {
                    var self = this;
                    self.errors = {};
                    var data = self.setFormData();
                    self.$http[self.getMethod()](self.getUrl(), data)
                    .then(function (response) {
                        if (response.data.success) {
                        self.form_id = response.data.form_id;
                        self.active_tab = response.data.active_tab;
                        self.admForm.active_tab = response.data.active_tab;
                        // self.admForm = response.data.adm_form;
                        $.blockUI({ message: '<h3> Record successfully saved !!</h3>' });
                        setTimeout(function(){
                            $.unblockUI();
                        },1000);
                        
                        // setTimeout(function() {
                        //   self.success = false;
                        //   window.location = self.admitUrl+'/' +self.form_id +'/details';
                        // }, 3000);
                        }
                    }, function (response) {
                        self.fails = true;
                        if(response.status == 422) {
                            $('body').scrollTop(0);
                            self.errors = response.data;
                        }              
                    });
                },

                setFormData: function(){
                    return {
                        active_tab: 5,
                        form_id : this.form_id,
                        migration:this.migration,
                        foreign_national: this.foreign_national,
                        passportno: this.passportno,
                        passport_validity: this.passport_validity,
                        visa: this.visa,
                        visa_validity: this.visa_validity,
                        res_validity: this.res_validity,
                        res_permit: this.res_permit,
                        migration_certificate: this.migration_certificate,
                        migrate_from: this.migrate_from,
                        migrate_deficient_sub: this.migrate_deficient_sub,
                        know_alumani:this.know_alumani,
                        alumani: this.alumani,
                        icssr_sponser:this.icssr_sponser,
                        equivalence_certificate:this.equivalence_certificate,
                        mcm_graduate:this.mcm_graduate,
                    }
                },

                setDataForForm: function(adm_det){
                    console.log(adm_det.visa);
                        this.form_id  =  adm_det.form_id;
                        this.migration = adm_det.migration;
                        this.foreign_national =  adm_det.foreign_national;
                        this.passportno =  adm_det.passportno;
                        this.passport_validity =  adm_det.passport_validity;
                        this.visa =  adm_det.visa;
                        this.visa_validity =  adm_det.visa_validity;
                        this.res_validity =  adm_det.res_validity;
                        this.res_permit =  adm_det.res_permit;
                        this.migration_certificate =  adm_det.migration_certificate;
                        this.migrate_from =  adm_det.migrate_from;
                        this.migrate_deficient_sub =  adm_det.migrate_deficient_sub;
                        // this.know_alumani = adm_det.alumani;
                        // this.alumani =  adm_det.alumani;
                        this.icssr_sponser = adm_det.icssr_sponser;
                        this.equivalence_certificate = adm_det.equivalence_certificate;
                        this.mcm_graduate= adm_det.mcm_graduate;
                },

                getMethod: function() {
                    if(this.admForm.active_tab >= 5)
                    return 'patch';
                    else
                    return 'post';
                },

                getUrl: function() {
                    if(this.admForm.active_tab >= 5)
                    return 'for-mig-alumni-details/'+this.form_id;
                    else
                    return 'for-mig-alumni-details';
                },
            },

        });

        Vue.component('foreign-migration-alumni', forMigAlumniComponent)
    </script>
@endpush
