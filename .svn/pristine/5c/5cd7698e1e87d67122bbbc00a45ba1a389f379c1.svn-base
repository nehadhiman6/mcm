<template id="parent-detail-template">

    <fieldset>
        <legend><strong>Parents' Details</strong></legend>
        <div class="row">
        <p style="padding:0 0 0 14px"><b>(Applicant is required to give at least one parent/guardian information in complete)</b></p>
            <div class="col-lg-4 col-sm-12">
                <legend><h4> <strong>Father's Details</strong></h4></legend>
                <div class='form-group'>
                {!! Form::label('father_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::text('father_occup',null,['class' => 'form-control','v-model'=>'father_occup']) !!}
                </div>
                </div>
                <div class='form-group'>
                {!! Form::label('father_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::text('father_desig',null,['class' => 'form-control','v-model'=>'father_desig']) !!}
                </div>
                </div>
                <div class='form-group'>
                {!! Form::label('father_phone','Phone No.(with STD Code)',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-7">
                    {!! Form::text('father_phone',null,['class' => 'form-control','v-model'=>'father_phone']) !!}
                </div>
                </div>
                <div class='form-group'>
                {!! Form::label('father_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
                <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_mobile'] }">
                    {!! Form::text('father_mobile',null,['class' => 'form-control','v-model'=>'father_mobile']) !!}
                    <span id="basic-msg" v-if="errors['father_mobile']" class="help-block">@{{ errors['father_mobile'][0] }}</span>
                </div>
                </div>
                <div class='form-group'>
                {!! Form::label('father_email','Email ID',['class' => 'col-sm-4 control-label required']) !!}
                <div class="col-sm-7" v-bind:class="{ 'has-error': errors['father_email'] }">
                    {!! Form::text('father_email',null,['class' => 'form-control','v-model'=>'father_email']) !!}
                    <span id="basic-msg" v-if="errors['father_email']" class="help-block">@{{ errors['father_email'][0] }}</span>
                </div>
                </div>
                <div class="form-group">
                    {!! Form::label('father_address','Address',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                    {!! Form::textarea('father_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'father_address']) !!}
                    </div>
                </div>
                {{-- <div class="form-group">
                {!! Form::label('f_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
                <div class="col-sm-7" v-bind:class="{ 'has-error': errors['f_office_addr'] }">
                    {!! Form::textarea('f_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'f_office_addr']) !!}
                    <span id="basic-msg" v-if="errors['f_office_addr']" class="help-block">@{{ errors['f_office_addr'][0] }}</span>
                </div>
                </div> --}}
            </div>
        
            <div class="col-lg-4 col-sm-12">
                <legend><h4><strong>Mother's Details</strong></h4></legend>
                <div class='form-group'>
                    {!! Form::label('mother_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('mother_occup',null,['class' => 'form-control','v-model'=>'mother_occup']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('mother_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('mother_desig',null,['class' => 'form-control','v-model'=>'mother_desig']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('mother_phone','Phone No.(with STD Code)',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::text('mother_phone',null,['class' => 'form-control','v-model'=>'mother_phone']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('mother_mobile','Mobile No.',['class' => 'col-sm-4 control-label required']) !!}
                    <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_mobile'] }">
                        {!! Form::text('mother_mobile',null,['class' => 'form-control','v-model'=>'mother_mobile']) !!}
                        <span id="basic-msg" v-if="errors['mother_mobile']" class="help-block">@{{ errors['mother_mobile'][0] }}</span>
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('mother_email','Email ID',['class' => 'col-sm-4 control-label required']) !!}
                    <div class="col-sm-7" v-bind:class="{ 'has-error': errors['mother_email'] }">
                        {!! Form::text('mother_email',null,['class' => 'form-control','v-model'=>'mother_email']) !!}
                        <span id="basic-msg" v-if="errors['mother_email']" class="help-block">@{{ errors['mother_email'][0] }}</span>
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('mother_address','Address',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::textarea('mother_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'mother_address']) !!}
                    </div>
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('m_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                        {!! Form::textarea('m_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'m_office_addr']) !!}
                    
                    </div>
                </div> --}}
            </div>
            
            <div class="col-lg-4 col-sm-12">
                <legend><h4><strong>Guardian's Details</strong></h4></legend>
                <div class='form-group'>
                    {!! Form::label('guardian_occup','Occupation',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                    {!! Form::text('guardian_occup',null,['class' => 'form-control','v-model'=>'guardian_occup']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('guardian_desig','Designation',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                    {!! Form::text('guardian_desig',null,['class' => 'form-control','v-model'=>'guardian_desig']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('guardian_phone','Phone No.(with STD Code)',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                    {!! Form::text('guardian_phone',null,['class' => 'form-control','v-model'=>'guardian_phone']) !!}
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('guardian_mobile','Mobile No.',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7"  v-bind:class="{ 'has-error': errors['guardian_mobile'] }">
                    {!! Form::text('guardian_mobile',null,['class' => 'form-control','v-model'=>'guardian_mobile']) !!}
                    <span id="basic-msg" v-if="errors['guardian_mobile']" class="help-block">@{{ errors['guardian_mobile'][0] }}</span>
                    </div>
                </div>
                <div class='form-group'>
                    {!! Form::label('guardian_email','Email ID',['class' => 'col-sm-4 control-label ']) !!}
                    <div class="col-sm-7">
                    {!! Form::text('guardian_email',null,['class' => 'form-control','v-model'=>'guardian_email']) !!}
                    </div>
                </div>
                <div class="form-group" >
                    {!! Form::label('guardian_address','Address',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7" v-bind:class="{ 'has-error': errors['guardian_address'] }">
                    {!! Form::textarea('guardian_address', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'guardian_address']) !!}
                    <span id="basic-msg" v-if="errors['guardian_address']" class="help-block">@{{ errors['guardian_address'][0] }}</span>
                    
                    </div>
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('g_office_addr','Office Address',['class' => 'col-sm-4 control-label']) !!}
                    <div class="col-sm-7">
                    {!! Form::textarea('g_office_addr', null, ['size' => '30x3' ,'class' => 'form-control','v-model'=>'g_office_addr']) !!}
                    </div>
                </div> --}}
            </div>
        </div>

        <hr>

        <div class='form-group'>
            {!! Form::label('annual_income','Annual Income From All Sources (INR)',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-lg-3 col-sm-5" v-bind:class="{ 'has-error': errors['annual_income'] }">
                {!! Form::select('annual_income',getAnnualIncome(),null,['class' => 'form-control','v-model'=>'annual_income']) !!}
                <span id="basic-msg" v-if="errors['annual_income']" class="help-block">@{{ errors['annual_income'][0] }}</span>
            </div>
        </div>

        <div class='form-group'>
            {!! Form::label('belongs_bpl','Belongs to BPL(Below Poverty Line)',['class' => 'col-sm-2 control-label required']) !!}
            <div class="col-sm-3" v-bind:class="{ 'has-error': errors['belongs_bpl'] }">
                <label class="radio-inline">
                {!! Form::radio('belongs_bpl', 'Y',null, ['class' => 'minimal','v-model'=>'belongs_bpl']) !!}
                Yes
                </label>
                <label class="radio-inline">
                {!! Form::radio('belongs_bpl', 'N',null, ['class' => 'minimal','v-model'=>'belongs_bpl']) !!}
                No
                </label>
                <span id="basic-msg" v-if="errors['belongs_bpl']" class="help-block">@{{ errors['belongs_bpl'][0] }}</span>
            </div>
       
            <div class="col-sm-12">
                <p><i style="color: #a94442;
                    font-weight: 900;">If Yes Please Attach Proof.</i></p>
            </div>
               
        </div>
        {{-- <span id="basic-msg" class="help-block">Please 'Update' data, in case of any changes, before leaving the current tab !</span> --}}
        <span id="basic-msg" class="help-block">Click the "Update" button before leaving the current tab, in case there have been any changes.</span>

        <input v-on:click="rediretPreviousTab" v-show="active_tab >= 1" class="btn btn-primary"  type="button" value="Previous" >
        <input class="btn btn-primary"  type="button" :value="admForm.active_tab >= 2 ? 'Update' : 'Submit'" @click.prevent="submit">
        <input v-on:click="rediretNextTab" v-show="active_tab >= 2" class="btn btn-primary"  type="button" value="Next" >
    </fieldset>
    <div>
        <ul class="alert alert-error alert-dismissible" role="alert" v-show="hasErrors">
            <li  v-for='error in errors'>@{{ error }} </li>
        </ul>
    </div>
    
</template>

@push('vue-components')
    <script>
        var parentDetail = Vue.extend({
            template: '#parent-detail-template',

            props:['courses','course_id', 'active_tab', 'admForm', 'form_id'],

            data: function(){
                return {
                    father_occup: '',
                    mother_occup: '',
                    father_desig: '',
                    mother_desig: '',
                    father_phone: '',
                    mother_phone: '',
                    father_mobile: '',
                    mother_mobile: '',
                    f_office_addr: '',
                    m_office_addr: '',
                    guardian_occup: '',
                    guardian_desig: '',
                    guardian_phone: '',
                    g_office_addr: '',
                    guardian_mobile: '',
                    annual_income: '',
                    father_email: '',
                    mother_email: '',
                    guardian_email: '',
                    father_address: '',
                    mother_address: '',
                    guardian_address: '',

                    //from controller
                    belongs_bpl:"{{ $adm_form->belongs_bpl == 'Y' ? 'Y' : 'N' }}",


                    //basic
                    response: {},
                    success: false,
                    fails: false,
                    msg: '',
                    errors: {},
                }
            },

            ready: function(){
                var self = this;
               
                if(self.admForm && self.admForm.father_mobile != null){
                    self.setDataForForm(self.admForm);
                }
                else if(self.admForm.lastyr_rollno != null){
                    self.getStudentDetails();
                }
            },

            computed: {
                hasErrors: function() {
                    return Object.keys(this.errors).length > 0;
                },
            },
            
            methods:{
                rediretNextTab: function(){
                    $('a[href="#subject-options"]').click();
                },

                rediretPreviousTab: function(){
                    $('a[href="#student-detail"]').click();
                },

                // annualIncomeChanged:function(){
                //     var self = this;
                //     if(self.annual_income == 'below 2 lac'){
                //         self.belongs_bpl  = 'Y'
                //         return;
                //     }
                //     self.belongs_bpl = 'N';
                // },

                submit: function() {
                    var self = this;
                    self.errors = {};
                    var data = self.setFormData();
                    self.$http[self.getMethod()](self.getUrl(), data)
                    .then(function (response) {
                        if (response.data.success) {
                        self.form_id = response.data.form_id;
                        // self.admForm = response.data.adm_form;
                        self.admForm.active_tab = response.data.active_tab;
                        self.active_tab = response.data.active_tab;
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
                        active_tab: 2,
                        form_id : this.form_id,
                        father_occup: this.father_occup,
                        mother_occup: this.mother_occup,
                        father_desig: this.father_desig,
                        mother_desig: this.mother_desig,
                        father_phone: this.father_phone,
                        mother_phone: this.mother_phone,
                        father_mobile: this.father_mobile,
                        mother_mobile: this.mother_mobile,
                        f_office_addr: this.f_office_addr,
                        m_office_addr: this.m_office_addr,
                        guardian_occup: this.guardian_occup,
                        guardian_desig: this.guardian_desig,
                        guardian_phone: this.guardian_phone,
                        g_office_addr: this.g_office_addr,
                        guardian_mobile: this.guardian_mobile,
                        annual_income: this.annual_income,
                        father_email: this.father_email,
                        mother_email: this.mother_email,
                        guardian_email: this.guardian_email,
                        father_address: this.father_address,
                        mother_address: this.mother_address,
                        guardian_address: this.guardian_address,
                        belongs_bpl: this.belongs_bpl,
                    }
                },

                setDataForForm: function(parent_det){
                    this.active_tab = parent_det.active_tab,
                    this.father_occup = parent_det.father_occup;
                    this.mother_occup = parent_det.mother_occup;
                    this.father_desig = parent_det.father_desig;
                    this.mother_desig = parent_det.mother_desig;
                    this.father_phone = parent_det.father_phone;
                    this.mother_phone = parent_det.mother_phone;
                    this.father_mobile = parent_det.father_mobile;
                    this.mother_mobile = parent_det.mother_mobile;
                    this.f_office_addr = parent_det.f_office_addr;
                    this.m_office_addr = parent_det.m_office_addr;
                    this.guardian_occup = parent_det.guardian_occup;
                    this.guardian_desig = parent_det.guardian_desig;
                    this.guardian_phone = parent_det.guardian_phone;
                    this.g_office_addr = parent_det.g_office_addr;
                    this.guardian_mobile = parent_det.guardian_mobile;
                    this.annual_income = parent_det.annual_income;
                    this.father_email = parent_det.father_email;
                    this.mother_email = parent_det.mother_email;
                    this.guardian_email = parent_det.guardian_email;
                    this.father_address = parent_det.father_address;
                    this.mother_address = parent_det.mother_address;
                    this.guardian_address = parent_det.guardian_address;
                    this.belongs_bpl = parent_det.belongs_bpl;
                },

                getMethod: function() {
                    if(this.admForm.active_tab >= 2)
                    return 'patch';
                    else
                    return 'post';
                },

                getUrl: function() {
                    if(this.admForm.active_tab >= 2)
                    return 'parent-adm-details/'+this.form_id;
                    else
                    return 'parent-adm-details';
                },

                getStudentDetails: function() {
                    var self = this;
                    if(self.admForm.lastyr_rollno.trim().length == 0 || (self.admForm.adm_entry && self.admForm.adm_entry.dhe_form_no.trim().length > 0)) {
                        return;
                    }
                    self.$http['get']('admforms/'+ self.admForm.lastyr_rollno + '/studentinfo')
                    .then(function (response) {
                        var student = response.data.data;
                        if(response.data.success == true){
                            self.setDataForForm(student);
                        }else{
                        alert("Not a valid Roll no.");
                        self.lastyr_rollno = '';
                        }
                    })
                    .catch(function(){
                    });
                },
            }
        });

        Vue.component('parent-detail', parentDetail)
    </script>
@endpush