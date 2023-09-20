<div id="locations" class="box box-info">
  <div class="box-header with-border">
    <h3 class="box-title">New Location</h3>
  </div>
  <div class="box-body">
    {!! Form::open(['url' => 'locations', 'class' => 'form-horizontal']) !!}
    @include('locations._form')

  </div>
  <div class="box-footer">
    {!! Form::submit('ADD',['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
  </div>
</div>

@section('script')
<script>
  const vm = new Vue({
    el: '#locations',
    data : {
      is_store: 'N',
      operated_by: '',
    },
    ready:function(){
            console.log('dfsfa');
            $(function () {
                $('#dt-locations').DataTable({
                  dom: 'Bfrtip',
                        "paging": true,
                        "lengthChange": false,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": false,
                        "scrollX": true,
                        buttons: [
                        'pageLength',
                        ],  
                        
                    });
              });
            // $("#dt-locations").DataTable();
        }
  });
</script>
@endsection