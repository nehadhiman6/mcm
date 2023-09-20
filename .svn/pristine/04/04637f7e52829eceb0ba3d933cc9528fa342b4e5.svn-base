<template id="adm-attachment-template">
    <div>
    <fieldset>
        <legend><strong>Attachments</strong></legend>
                {!! Form::model($adm_form, ['method' => 'PATCH', 'action' => ['AttachmentController@store',$adm_form->id,], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
                <div class="box-header with-border">
                    <h3 class=box-title><strong>DOCUMENTS TO BE UPLOADED</strong> (Whichever applicable)</h3>
                </div>

                <div class="box-body">
                    <p style="margin-left:20px;"><strong>Uploaded documents should be scanned from the original ones.</strong></p>
                        <ul>                            
                            <li><b>Mandatory documents</b></li>
                            <li>- Student photograph, Student signature,  Parent/Guardian Signature, 10th DMC, 12th DMC </li>
                            <li></li>
                            <li>In addition to the above, the following listed documents must also be uploaded: </li>
                            <li>- Character Certificate (For first year students only)</li>
                            <li>- Affidavit justifying Gap year (For Gap-year students only)</li>
                            <li>- Scanned Copy of Passport (For Foreign Students only)</li>
                            <li><b>- DMC of all lower/preceding semester examinations</b></li>
                            <li><b>- Category Certificate (if any)</b></li>

                        </ul>
                    <table class="document">
                    <!-- Picture size should fall between 10 KB to {{ config('college.max_photo_upload_size') }} KB. The dimensions of the photograph should be 3.5 * 4.5 cms (width*height) and scan the photograph on 200 dpi. Photograph should not be taken by mobile phone camera. -->
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="photograph" opt-label="Student Photograph" :show-label='false' msg="Size : Not more then 50 KB, Dimension : 3.5 * 4.5 cms , Scanned on 200 dpi. Photograph taken with mobile phone camera is not acceptable."></tr>
                        <!-- Dimensions 6x3 cms (width*height) on a plain white sheet. Keep the size of the image between 10 KB to {{ config('college.max_sign_upload_size') }} KB and scan the signature on 200 dpi. Signature should be done with thick point Black/Blue pen only. Signatures having only Initials or done in CAPITAL letters are not acceptable. -->
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="signature" opt-label="Student Signature" :show-label="false" msg="Size : Not more then 20 KB, Dimension : 6 * 3 cms , Scanned on 200 dpi. Use thick point Black/Blue pen only. Signatures having only Initials or done in CAPITAL letters are not acceptable."></tr>
                        <!-- Dimensions 6x3 cms (width*height) on a plain white sheet. Keep the size of the image between 10 KB to {{ config('college.max_sign_upload_size') }} KB and scan the signature on 200 dpi. Signature should be done with thick point Black/Blue pen only. Signatures having only Initials or done in CAPITAL letters are not acceptable. -->
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="parent_signature" opt-label=" Parent/Guardian Signature" :show-label="false" msg="Size : Not more then 20 KB , Dimension : 6 * 3 cms , Scanned on 200 dpi. Use thick point Black/Blue pen only. Signatures having only Initials or done in CAPITAL letters are not acceptable."></tr>
                        {{-- <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="antireg" opt-label="Anti-Ragging Reference" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr> --}}
                        {{-- <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="covid" opt-label="Covid 19 Vaccinated/not-vaccinated" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr> --}}
                        <!-- File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi. File should not be password protected. -->
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="dob_certificate" opt-label="Matric/Secondary Certificate for Date Of Birth" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="char_certificate" opt-label="Character Certificate from the Institution last attended" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr> 
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="migrate_certificate" opt-label="Migration Certificate" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="gap_certificate" opt-label="Affidavit Justifying Gap Year, if applicable" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="uid" opt-label="Aadhar Card or Passport (for foreign students)" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="bpl_certificate" opt-label="Affidavit Justifying BPL Category, if applicable" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        {{-- <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="hostel_certificate" opt-label="Hostel Medical Certificate" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr> --}}
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="nss" opt-label="NSS Certificate" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="ncc" opt-label="NCC Certificate" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="yf" opt-label="Youth Fest" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="reserve_cats" opt-label="Reserve Categories (If multiple make one pdf file.)" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="other_certificate" opt-label="Any other relevant document" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr><td colspan="7" class="mark_sheet">Upload Mark Sheets of all lower Examinations</td></tr>
                        <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="cgpa" opt-label="CGPA Conversion Factor Sheet" :show-label="false" msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                        <tr v-for="(index, exam) in exams" :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" :opt-name="index" opt-label="Detailed Mark Sheet of" :show-label='true' msg="Size : Not more than 300KB, Resolution : 200 dpi - 300 dpi. File should not be password protected."></tr>
                    </table>
                </div>

                <div class="box-footer">
                    {!! Form::close() !!}
                </div>

                {{ getVueData() }} 
                {{-- <input v-on:click="rediretPreviousTab" class="btn btn-primary"  type="button" value="Previous" > --}}
                <a class="btn btn-primary"   href="{{url('/new-adm-form') .'/'. $adm_form->id }}">Preview</a>
                <a class="btn btn-primary"   href="{{url('/final-submissions')}}">Final-Submission</a>
    </fieldset>
     
</div>
</template>

<template id="file-template">
    <tr>
        <td>
            {{-- <span id="@{{ optName }}">  <i :src="url+'?'+new Date().getTime()" width="100" height="120" v-if="url && (optName == 'photograph' || optName == 'signature')"></span> --}}
            <span id="help-block-@{{ optName }}" class="help-block">@{{ errors[optName][0] }}</span>
           
        </td>

        <td>
            <label for="@{{ optName }}" class="control-label">@{{ optLabel }} @{{ showLabel ? optName : '' }}</label><br>
            <span id="type-msg" v-if="optName == 'photograph' || optName == 'signature' || optName == 'parent_signature'">(.jpg , .jpeg , .bmp , .png) <br><span style="color:black">@{{ msg }}</span></span>
            <span id="type-msg" v-else="optName == 'photograph' || optName == 'signature' || optName == 'parent_signature'">(.pdf)<br><span style="color:black">@{{ msg }}</span></span>
        </td>

        <td class="choose-file">
    
        <input class="form-control" type="file" name="@{{ optName }}" 
            @change="upload($event)" 
            data-url="@{{ attachUrl+'/'+optName+'/'+adm_id  }}" 
        >
        </td>

        <td>
            <i class="fa fa-fw fa-check-circle" style="color:green;" v-if="success"></i>
            <i class="fa fa-fw fa-times-circle-o"  style="color:orangered;" v-if="failed"></i>
        </td>

        <td class="tdprogress">
            <div class="progress">
                <div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="@{{ uploadPer }}" aria-valuemin="0" aria-valuemax="100" :style="{ width: uploadPer + '%' }">@{{ uploadPer }}%</div>
            </div>
        </td>

        <td>
            <a class="btn btn-default" @click.prevent="showImage" v-if="available(optName)" class="btn btn-default">
                <span v-if="optName == 'photograph' || optName == 'signature' || optName == 'parent_signature'">
                    <img :src="url" width="70px">
                </span>
                <span v-else>
                    <img src="{{ url('img/pdf.png')}}" width="70px;" />
                </span>
            </a>
        </td>

        <td>
            <button type="reset" class="btn btn-warning" @click='cancel'>
                <i class="glyphicon glyphicon-ban-circle"></i>
                <span>Cancel upload</span>
            </button>
        </td>

    </tr>
</template> 
  
@push('vue-components')
    <script>
      var attchmentComponent = Vue.extend({
            template: '#adm-attachment-template',

            data:function() {
                return {
                    adm_id: {{ (isset($adm_form) && $adm_form->exists) ? $adm_form->id : 0 }},
                    attachUrl: "{{ isset($guard) && $guard == 'web' ? url('attachment') : url('stdattachment') }}",
                    files: [],
                    exams: {!! getAcademicExam(true) !!},
                    response: {},
                    success: false,
                    fails: false,
                    msg: '',
                    errors: {},
                }
            },

            created: function () {
                this.getUploads();
                delete this.exams[''];
            },

            methods: {
                rediretPreviousTab: function(){
                    $('a[href="#declaration"]').click();
                },

                getUploads: function() {
                    if(this.adm_id > 0) {
                        this.$http.get(this.attachUrl + '/'+this.adm_id)
                        .then(function (response) {
                        this.files = response.data;
                        //              console.log(response.data);
                        }, function (response) {
                        //              console.log(response.data);
                        });
                    }
                },
            },

            components: {
                'fileUpload': {
                    template: '#file-template',
                    props: ['optName', 'optLabel', 'showLabel', 'files', 'attachUrl', 'adm_id','msg'],
                    data: function () {
                        return {
                            uploadPer: 0,
                            jqXHR: {},
                            fileUpload: {},
                            success: false,
                            failed: false,
                            errors: {},
                            url: '',
                            baseUrl: "{{ (isset($guard) && $guard == 'students') ? url('/') . '/stdattachment/' : url('/') . '/attachment/' }}",
                            urlUpdated: false,
                            filesList: null
                        };
                    },
                    created: function() {
                    // console.log(this.optName);
                    },
                    methods: {
                        upload: function (e) {
                            this.errors = {};
                            this.success = false;
                            this.failed = false;
                            var ele = e.target;
                            this.filesList = $(ele).prop('files');
                            this.uploadPer = 0;
                            var self = this;
                            
                            if(this.filesList && this.filesList[0] && (this.filesList[0].size / 1024) > 300) {
                                this.errors[this.optName] = ["File size is greater than maximum allowed filesize!"];
                                return;
                            }

                            var loadingImage = loadImage(
                                ele.files[0],
                                function (img) {

                                    try {
                                        $('#'+self.optName).empty();
                                        $('#'+self.optName).append($(img));
                                    } catch (error) {
                                        console.log(error);
                                    }
                                },
                                { maxWidth: 250 }
                            );
                            if (!loadingImage) {
                                // Alternative code ...
                            }
                            if(! _.isEmpty(this.fileUpload)) {
                                $(ele).fileupload('destroy');
                                this.fileUpload = {};
                            }
                            
                            if(_.isEmpty(this.fileUpload)) {
                                self = this;
                                this.fileUpload = $(ele).fileupload({
                                    progress: function (e, data) {
                                        self.uploadPer = parseInt(data.loaded / data.total * 100, 10);
                                    },
                                    done: function (e, data) {
                                        self.success = true;
                                        self.failed = false;

                                        if(data.result.files) {
                                            self.url = data.result.files.url;
                                            self.urlUpdated = true;
                                        }
                                    },
                                    fail: function (e, data) {
                                        self.success = false;
                                        self.failed = true;
                                        
                                        self.errors = JSON.parse(data.jqXHR.responseText);
                                        self.uploadPer = 0;
                                        $('#'+self.optName).html('');

                                    },
                                    always: function(e, data) {

                                    }
                                });
                            }
                            this.jqXHR = $(ele).fileupload('send', {files: this.filesList, type: 'POST'});
                        },

                        cancel: function () {
                            if (!_.isEmpty(this.jqXHR)) {
                                this.jqXHR.abort();
                                this.jqXHR = {};
                            }
                        },

                        available: function(name) {
                            var found = false;
                            self = this;
                            $(this.files).filter(function(i,n) {
                                if(n.file_type == self.optName) {
                                    found = true;
                                    self.url = self.baseUrl+self.adm_id+'/'+self.optName;
                                }
                            });
                            return found;
                        },

                        showImage: function() {
                            self = this;
                            if(self.url) {
                                    if(self.optName == 'photograph' || self.optName == 'signature' || self.optName == 'parent_signature'){
                                    $.fancybox.open({
                                        src  : self.url,
                                        type : 'iframe',
                                        opts : {
                                            beforeLoad: function() {
                                                if(self.urlUpdated) {
                                                    $($('.fancybox-iframe')[0]).attr('src', $($('.fancybox-iframe')[0]).attr('src')+'?time='+new Date().getTime());
                                                    self.urlUpdated = false;
                                                }
                                            },
                                            iframe: {
                                                css: {
                                                    width: '70% !important'
                                                }
                                            }
                                        }
                                    });
                                }else{
                                    window.open(self.url,'_blank');
                                }
                            }
                        }
                    }
                },
            },
            
        });
    Vue.component('adm-attachment', attchmentComponent);
  </script>
@endpush
  