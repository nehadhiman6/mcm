	@extends('app')
	@section('toolbar')
	@include('toolbars._placement_toolbar')
	@stop
	@section('content')

	<div id="attachment">
		{!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
		<div class="box-header with-border">
		<h3 class=box-title>DOCUMENT</h3>
		</div>
		<div class="box-body">
			<table class="document table table-bordered" >
				<tr>
					<th>Select File</th>
					<th>Upload</th>
					<th>Upload Progress</th>
					<th></th>
					<th>Preview</th>
					<th>Action</th>
				</tr>
				<tr :files="files" :attach-url="attachUrl" :attach_file="attach_file" :upload-show ="uploadShow" :attachment="attachment" :id="id" :thum_url="thum_url" is="fileUpload"></tr>
			</table>
		</div>
		<div class="box-footer">
		{!! Form::close() !!}
		</div>
		{{ getVueData() }}
		<template id="file-template">
		<tr>
			<td class="choose-file">
				<input class="form-control" type="file" name="file" 
						@change="upload($event)" 
						data-url="@{{ attachUrl+'/'+ id }}" 
				>
				<span id="help-block" class="help-block" v-html="errors['file'][0]"></span>
			</td>
			<td>
				<button class="btn btn-warning" @click.prevent='saveAttchment'>
					<i class="fa fa-fw fa-check-circle" style="color:green;" v-if="success"></i>
					<i class="fa fa-fw fa-times-circle-o"  style="color:orangered;" v-if="failed"></i>
					<span>Upload</span>
				</button>
			</td>
			<td class="tdprogress">
				<div class="progress">
					<div class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="@{{ uploadPer }}" aria-valuemin="0" aria-valuemax="100" :style="{ width: uploadPer + '%' }">@{{ uploadPer }}%</div>
				</div>
			</td>
			<td>
				<a class="btn btn-default" @click.prevent="showImage"
					v-if="available()" class="btn btn-default">
					<span>View</span>
				</a>
			</td>
			<td >
				<a class="btn btn-default" @click.prevent="showImage()" style="width:70px" v-if='uploadShow == true'>
					<span v-if="attach_file.file_ext == 'pdf'">
						<img src="{{ url('img/pdf.png')}}" width="70px;" />
					</span>
					<span v-else>
						<img :src="url" width="70px">
					</span>
				</a>
			</td>
		</td>
			<td>
			<button type="reset" class="btn btn-warning" @click='cancel'>
				<i class="glyphicon glyphicon-ban-circle"></i>
				<span>Cancel upload</span>
			</button>
			</td>
			<td>
				<ul class="alert alert-error alert-dismissible" role="alert">
					<li class=" text-danger" v-for='error in errors'>@{{ error }} <li>
				</ul>
			</td>
		</tr>
		</template>
	</div>
	@stop
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
				id: {{ $id or 0 }},
				base_url: "{{ url('/')}}",
				attachment: {!! json_encode($placement) !!},
				attachUrl: "{{  url('placement-attachment') }}",
				thum_url:"{{  url('upload-thumbnail') }}",
				files: [],
				response: {},
				success: false,
				fails: false,
				msg: '',
				errors: {},
				uploadShow:false,
				attach_file:'',
			},
			created: function () {
				this.getUploads();
			},
			methods: {
				getUploads: function() {
					var self = this;
					if(self.attachment.resources) {
						self.files = self.attachment.resources;
						self.attach_file = self.attachment.resources.attachment;
						self.uploadShow = true;
					}
				},
				hasError: function() {
					if(this.errors && _.keys(this.errors).length > 0)
						return true;
					else
						return false;
				},
	
			},
			components: {
				fileUpload: {
					template: '#file-template',
					props: ['optName', 'optLabel', 'showLabel', 'files', 'attachUrl', 'id','msg','thum_url','uploadShow','attach_file'],
					data: function () {
						return {
							uploadPer: 0,
							jqXHR: {},
							fileUpload: {},
							success: false,
							failed: false,
							errors: {},
							url: '',
							urlUpdated: false,
							attach_id:'0',
							base_url: "{{ url('/')}}",
							attach_file:'',
						};
					},
					created: function() {
						// console.log(this.optName);
					},
					methods: {
						upload: function (e) {
								this.errors = {};
								this.successAttach = false;
								this.failsAttach = false;
								var ele = e.target;
								this.filesList = $(ele).prop('files');
								this.uploadPer = 0;
								var self = this;
								if(! _.isEmpty(this.fileUpload)) {
									console.log('i am here');
									console.log($(ele).fileupload());
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
											self.successAttach = true;
											self.failsAttach = false;
											var file = JSON.parse(data.jqXHR.responseText);
											console.log(file);
											if(file){
												self.attach_id = file.resource.id;
											}
										},
										fail: function (e, data) {
											self.successAttach = false;
											self.failsAttach = true;
											var err = JSON.parse(data.jqXHR.responseText);
											if(err){
												self.errors = err;
													
											}
																																		
											self.uploadPer = 0;
											$('#'+self.optName).html('');

										},
										always: function(e, data) {

										}
									});
								}
								var jqXHR = $(ele).fileupload('send', {files: this.filesList, type: 'POST'});	
						},
						cancel: function () {
							var self =this;
							self.jqXHR = {};
							self.uploadPer = 0;
							self.attach_id = 0;
						},
						available: function() {
							var found = false;
							self = this;
							$(this.files).filter(function(i,n) {
								found = true;
								self.url = self.thum_url+'/'+self.id;
							});
							return found;
						},

						saveAttchment: function() {
							var self = this;
							data = {
								id: this.id,
								attachment_id: this.attach_id,
							};
							self.$http.post("{{ url('placement-resource-attachment') }}", data)
								.then(function(response) {
									if(response.data.success) {
										self.uploadShow = false;
										if(response.data.success){
											self.errors = {};
											$.blockUI({'message':'<h4>Successfully updated</h4>'});
											setTimeout(function() {
												$.unblockUI();
												var resource = response.data.resources;
												self.attach_file = response.data.attachment.attachment;
												self.url = self.thum_url+'/'+ resource.resourceable_id;
												self.uploadShow = true;
											},300);
											
										}
									}
								},  function (response) {
								this.fails = true;
								this.saving = false;
								if(response.status == 422) {
									$('body').scrollTop(0);
									self.errors = (typeof response.data) == "string" ? JSON.parse(response.data) : response.data;
									
								}              
							});
						},
						// showImage: function() {
						//   self = this;
						//   if(this.url) {
						//     $.fancybox.open({
						//       src  : self.url,
						//       type : 'iframe',
						//       opts : {
						//         beforeLoad: function() {
						//         //   if(self.urlUpdated) {
						//             $($('.fancybox-iframe')[0]).attr('src', $($('.fancybox-iframe')[0]).attr('src')+'?time='+new Date().getTime());
						//             // self.urlUpdated = false;
						//         //   }
						//         },
						//         iframe: {
						//           css: {
						//             width: '70% !important'
						//           }
						//         }
						//       }
						//     });
						//   }
							
						// }
						showImage: function() {
							self = this;
							if(self.url) {
								window.open(self.base_url+'/show-thumbnail/'+self.id,'_blank');
							}
						},
						hasError: function() {
							if(this.errors && _.keys(this.errors).length > 0)
								return true;
							else
								return false;
						},
						
					}
				}
			}
		});
	</script>
	@endpush
	