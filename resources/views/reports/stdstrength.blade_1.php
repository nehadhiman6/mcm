@extends('app')
@section('content')
<div class="box box-default box-solid" id='app'>
  <div class="box-header with-border">
    Filter
    <div class="box-tools pull-right">
      <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
        <i class="fa fa-minus"></i></button>
    </div>
  </div>
  <div class="box-body">
    {!! Form::open(['method' => 'GET',  'action' => ['Reports\StdReportController@stdStrength'], 'class' => 'form-horizontal']) !!}
    <div class="form-group">
      {!! Form::label('upto_date','Date',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::text('upto_date',null,['class' => 'form-control app-datepicker']) !!}
      </div>
      {!! Form::label('fund_type','Fund',['class' => 'col-sm-1 control-label']) !!}
      <div class="col-sm-2">
        {!! Form::select('fund_type',['College'=>'College','Hostel'=>'Hostel'],null,['class' => 'form-control']) !!}
      </div>
      {!! Form::submit('SHOW',['class' => 'btn btn-primary']) !!}
      {!! Form::close() !!}
    </div>
  </div>
</div>
<div class="panel panel-default">
  <div class="panel-heading">
    Student Strength
  </div>
  <div class="panel-body">
    <table class='table table-bordered' id="example1">
      <thead>
        <tr>
          <th>Course</th>
          <th>Category</th>
          <th>Res. Cat.</th>
          <th>Date</th>
          <th>Girls</th>
          <th>Boys</th>
          <th>Total</th>
        </tr>
      </thead>
      <?php $gt = 0; ?>
      <?php $bt = 0; ?>
      <?php $cn = '' ?>
      <tbody>
        @foreach($students as $value)
          @if($cn != $value->course_name)
            @if($gt+$bt > 0 && $cn != '')
            <tr>
              <td>{{ $cn }}</td>
              <th>Total:</th>
              <th>{{ $gt }}</th>
              <th>{{ $bt }}</th>
              <th>{{ $gt+$bt }}</th>
            </tr>
            <?php $gt = 0; $bt = 0; ?>
            @endif
            <?php $cn = $value->course_name; ?>
          @endif
           <tr>
            <td>{{ $value->course_name }}</td>
            <td></td>
            <td>{{ $value->girls }}</td>
            <td>{{ $value->boys }}</td>
            <td>{{ $value->girls+$value->boys }}</td>
          </tr>
          <?php $gt += intval($value->girls); ?>
          <?php $bt += intval($value->boys); ?>
        @endforeach
        @if($gt+$bt > 0 && $cn != '')
        <tr>
          <td>{{ $cn }}</td>
          <th>Total:</th>
          <th>{{ $gt }}</th>
          <th>{{ $bt }}</th>
          <th>{{ $gt+$bt }}</th>
        </tr>
        <?php $gt = 0; $bt = 0; ?>
        @endif
      </tbody>
      <tfoot>
        <tr>
          <th></th>
          <th>Total Strength:</th>
          <th>{{ $totals['girls'] }}</th>
          <th>{{ $totals['boys'] }}</th>
          <th>{{ $totals['total'] }}</th>
        </tr>
      </tfoot>
    </table>
  </div>
</div>
@stop
@section('script')
<script>
  $(document).ready(function () {
    
    $('#example1').DataTable({
      "dom": 'Bfrtip',
      "paging": true,
      "lengthChange": false,
      "searching": true,
      "ordering": false,
      "info": true,
      "autoWidth": false,
      lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 rows', '25 rows', '50 rows', 'Show all' ]
      ],
      buttons: [
         'pageLength',
          {
            extend: 'excelHtml5',
            exportOptions: { orthogonal: 'export' }
          },
          {
            extend: 'pdfHtml5',
            exportOptions: { orthogonal: 'export' }
          },
          'print'
      ],
//        "processing": true,
      "scrollCollapse": true,
      "rowsGroup": [ 0]
    });
});
</script>
@stop