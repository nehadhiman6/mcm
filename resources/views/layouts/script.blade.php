{{-- <script src="{{ asset('js/jquery.min.js') }}"></script> --}}
<script src="{{ asset('plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ asset(mix('js/app.js')) }}"></script>
<script src="{{ asset(mix('js/all.js')) }}"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 3.3.7 -->
{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script> --}}

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
<script src="{{ asset('plugins/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-require/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.html5.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/Buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('plugins/datatables/extensions/RowsGroup/dataTables.rowsGroup.js') }}"></script>
<script src="https://cdn.datatables.net/fixedcolumns/3.3.0/js/dataTables.fixedColumns.min.js"></script>

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
      today:"{{today()}}",
      start_date:"{{startDate()}}"
    }
    // Vue.http.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#csrf-token').getAttribute('content');
    // Vue.http.options.emulateJSON = true;
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


<script>
  var access = false;
    var all_report_links = ['marks-report/student'];
    var name = window.location.pathname.substr(5);
    var link_name = name.replace(/-/g, ' ');
    // link_name = link_name.toUpperCase();
    link_name = capitalize(link_name);
    all_report_links.forEach(function(e){
       if(e == name)
        access = true;
    });
    if(access){
      $(".-primary").prepend('<li class="active"><a href="'+window.location.href+'"><div>'+link_name+'</div></a></li>');
      setTimeout(function(){
        $('.-more .active').hide();
      },200);
    }
    
    function capitalize(s){
      if (typeof s !== 'string') return '';
      return s.charAt(0).toUpperCase() + s.slice(1)
    }
</script>