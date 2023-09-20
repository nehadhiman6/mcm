

<!-- jQuery 2.2.0 -->
<script src="{{ asset('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>

<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>




<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- DataTables -->
{{-- <script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.html5.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/RowsGroup/dataTables.rowsGroup.js') }}"></script> --}}


 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/sl-1.3.1/datatables.min.js"></script>

{{-- <script type="text/javascript" src="https://cdn.datatables.net/w/bs/dt-1.10.18/fc-3.2.5/fh-3.1.4/kt-2.5.0/r-2.2.2/rg-1.1.0/datatables.min.js"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/knob/jquery.knob.js') }}"></script>
<!-- Select2 -->
<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- Slimscroll -->
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- iCheck 1.0.1 -->
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/app.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="{{ asset('dist/js/pages/dashboard.js') }}"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('dist/js/demo.js') }}"></script>
@if(env('APP_ENV', 'production') == 'local') 
  <script src="{{ asset('plugins/vue/vue.js') }}"></script>
@else
  <script src="{{ asset('plugins/vue/vue.min.js') }}"></script>
@endif
<script src="{{ asset('plugins/vue-resource/vue-resource.min.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/load-image.all.min.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/js/jquery.iframe-transport.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/js/jquery.fileupload.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/js/jquery.fileupload-process.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/js/jquery.fileupload-image.js') }}"></script>
<script src="{{ asset('plugins/jQuery-File-Upload/js/jquery.fileupload-ui.js') }}"></script>
<script src="{{ asset('plugins/fancybox-3.0/dist/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('plugins/block-ui/jquery.blockUI.js') }}"></script>
<script src="{{ asset('plugins/mailgun-validator/mailgun_validator.js') }}"></script>
<script src="https://cdn.jsdelivr.net/underscorejs/1.8.3/underscore-min.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
   window.MCM = {
		base_url: "{{ url('/') }}",
   }
  	Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
	//  $(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
    	Vue.http.interceptors.push(function(request, next) {
        $.blockUI();
        next(function(response) {
          $.unblockUI();
        });
     });
     $('body').on('focus', '.app-datepicker', function () {
          $(this).datepicker({
            format: "dd-mm-yyyy",
            todayBtn: true,
            todayHighlight: true
          });
     });
     $('body').on('focus', '.datepicker', function () {
          $(this).datepicker({
            format: "dd-mm-yyyy",
            todayBtn: true,
            endDate: new Date(),
            todayHighlight: true
          });
     });
    //  $('body').on('focus', '.it_name', function () {
    // $('.it_name').select2({
    //       placeholder: 'Select an option'
    //     });
    // });
 	$(".select2").select2({ width: '100%' });
</script>
<script>
	$("form input:text").on('blur', function (e) {
    if(! $(this).hasClass('no-upper-case')){
      $(this).val(($(this).val()).toUpperCase());
    }
	});
</script>
