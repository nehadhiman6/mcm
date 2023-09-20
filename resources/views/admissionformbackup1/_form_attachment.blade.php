<div id="attachment">
  {!! Form::model($adm_form, ['method' => 'PATCH', 'action' => ['AttachmentController@store',$adm_form->id,], 'class' => 'form-horizontal', 'id' => 'adm-form']) !!}
  <div class="box-header with-border">
    <h3 class=box-title>DOCUMENTS TO BE SUBMITTED</h3>
  </div>
  <div class="box-body">
    <p style="margin-left:20px;"><strong>Attach Self Attested copy Of All Documents:</strong></p>
    <table class="document">
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="photograph" opt-label="Photograph" :show-label='false' msg="Picture size should fall between 10 KB to 50 KB. The dimensions of the photograph should be 3.5 * 4.5 cms (width*height) and scan the photograph on 200 dpi. Photograph should not be taken by mobile phone camera."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="signature" opt-label="Signature" :show-label="false" msg="Dimensions 6x3 cms (width*height) on a plain white sheet. Keep the size of the image between 10 KB to 20 KB and scan the signature on 200 dpi. Signature should be done with thick point Black/Blue pen only. Signatures having only Initials or done in CAPITAL letters are not acceptable."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="dob_certificate" opt-label="Matric/Secondary Certificate for Date Of Birth" :show-label="false" msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi. File should not be password protected."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="char_certificate" opt-label="Character Certificate from the Institution last attended(original)" :show-label="false" msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi. File should not be password protected."></tr> 
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="migrate_certificate" opt-label="Migration Certificate (original)" :show-label="false" msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi. Files should not be password protected."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="gap_certificate" opt-label="Affidavit Justifying gap Year, if applicable" :show-label="false" msg="File Size should not be more than 300KB.  Resolution should be more than 200dpi and less than 300dpi.Files should not be password protected."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="uid" opt-label="Residence Proof/Adhaar Card/Voter Card/Passport etc" :show-label="false" msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi.Files should not be password protected."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="bpl_certificate" opt-label="Affidavit Justifying BPL Category, if applicable" :show-label="false" msg="File Size should not be more than 300KB.  Resolution should be more than 200dpi and less than 300dpi.Files should not be password protected."></tr>
      <tr :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" opt-name="hostel_certificate" opt-label="Hostel Medical Certificate" :show-label="false" msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi.Files should not be password protected."></tr>
      <tr><td colspan="7" class="mark_sheet">Upload Marks Sheet of all lower Examinations</td></tr>
      
      <tr v-for="(index, exam) in exams" :files="files" :attach-url="attachUrl" :adm_id="adm_id" is="fileUpload" :opt-name="index" opt-label="Detailed Marks Sheet Of" :show-label='true' msg="File Size should not be more than 300KB. Resolution should be more than 200dpi and less than 300dpi.  File should not be password protected."></tr>
    </table>
  </div>
  <div class="box-footer">
    {!! Form::close() !!}
  </div>
  {{ getVueData() }}
  <template id="file-template">
    <tr>
      <td>
        <span id="@{{ optName }}">  <i :src="url+'?'+new Date().getTime()" width="100" height="120" v-if="url && (optName == 'photograph' || optName == 'signature')"></span>
        <span id="basic-msg" v-if="errors['char_certificate'] && errors['char_certificate'].length > 0" class="help-block">@{{ errors['char_certificate'][0] }}</span>
        <span id="basic-msg" v-if="errors[optName] && errors[optName].length > 0" class="help-block">@{{ errors[optName][0] }}</span>
      </td>
      <td>
        <label for="@{{ optName }}" class="control-label">@{{ optLabel }} @{{ showLabel ? optName : '' }}</label><br>
        <span id="type-msg" v-if="optName == 'photograph' || optName == 'signature'">(.jpg , .jpeg , .bmp , .png) <br><span style="color:black">@{{ msg }}</span></span>
        <span id="type-msg" v-else="optName == 'photograph' || optName == 'signature'">(.pdf)<br><span style="color:black">@{{ msg }}</span></span>
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
        <a class="btn btn-default" @click.prevent="showImage"
           v-if="available(optName)" class="btn btn-default">
          <span>View</span>
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
</div>

@push('pg_script')
<script>
//  $(function () {
//    $('#fileupload').fileupload({
//      dataType: 'json',
//      type: 'POST',
//      done: function (e, data) {
//        $.each(data.result.files, function (index, file) {
//          $('<p/>').text(file.name).appendTo(document.body);
//        });
//      }
//    });
//  });


    vm1 = new Vue({
        el: '#attachment',
        data: {
          adm_id: {{ (isset($adm_form) && $adm_form->exists) ? $adm_form->id : 0 }},
          attachUrl: "{{ isset($guard) && $guard == 'web' ? url('attachment') : url('stdattachment') }}",
          files: [],
          exams: {!! getAcademicExam(true) !!},
          response: {},
          success: false,
          fails: false,
          msg: '',
          errors: {},
        },
        created: function () {
          this.getUploads();
          delete this.exams[''];
        },
        methods: {
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
          
//          upload: function(e) {
//            var ele = e.target;
//            var filesList = $(ele).prop('files');
//            this.uploadPer = 0;
//            var self = this;
//            $(ele).fileupload({
//              progress: function(e, data) {
//                self.uploadPer = parseInt(data.loaded / data.total * 100, 10);
//              }
//            });
//            this.jqXHR = $(ele).fileupload('send', {files: filesList});
//          },
//          
//          cancel: function() {
//            if(! _.isEmpty(this.jqXHR)) {
//              this.jqXHR.abort();
//              this.jqXHR = {};
//            }
//          }
        },
        components: {
            fileUpload: {
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
                        urlUpdated: false
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
                        var filesList = $(ele).prop('files');
                        this.uploadPer = 0;
                        var self = this;
                        
                        var loadingImage = loadImage(
                          ele.files[0],
                          function (img) {
//                            console.log(img);
//                            console.log($('#'+self.optName));
                            $('#'+self.optName).empty();
                            $('#'+self.optName).append($(img));
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
//                                  console.log(e);
//                                  console.log(data.result);
                                  if(data.result.files) {
                                    self.url = data.result.files.url;
                                    self.urlUpdated = true;
                                  }
                              },
                              fail: function (e, data) {
                                  self.success = false;
                                  self.failed = true;
                                 // self.errors = JSON.parse(data.jqXHR.responseText);
//                                  if(response.status == 422) {
//                                    self.errors = JSON.parse(data.jqXHR.responseText);
//                                  }
                                  self.errors = JSON.parse(data.jqXHR.responseText);
                                  self.uploadPer = 0;
                                  $('#'+self.optName).html('');
//                                  console.log(data.jqXHR.responseText);
                              },
                              always: function(e, data) {
//                                self.errors[self.optName] = data;
//                                console.log(data);

                              }
                          });
                        }   
                        this.jqXHR = $(ele).fileupload('send', {files: filesList, type: 'POST'});
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
                      if(this.url) {
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
                      }
                        
                    }
                }
            }
        }
    });
</script>
@endpush
