@extends('app')
@section('toolbar')
  @include('toolbars._examinations_toolbar')
@stop

@section('content')
<div id='datesheet' v-cloak>
<div class="box">
        <div class="box-header with-border">
            Filter
        </div>
        <div class="box-body">
            {!! Form::open(['method' => 'GET',  'class' => 'form-horizontal']) !!}
            <div class="form-group">
                {!! Form::label('course_id','Class',['class' => 'col-sm-1 control-label']) !!}
                <div class="col-sm-4">
                    {!! Form::select('course_id',getCourses(),null,['class' => 'form-control','v-model'=>'course_id',':disabled'=>'showRoll']) !!}
                </div>

                <div class="col-sm-3">
                    {!! Form::submit('Show',['class' => 'btn btn-primary','@click.prevent'=>'getData()','v-if'=>"!showRoll"]) !!}
                    {!! Form::submit('RESET',['class' => 'btn btn-primary mr','@click.prevent'=>'resetData()','v-if'=>'showRoll']) !!}
                </div>
            </div>

            <div class="form-group col-sm-12">
               
                
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="box">
        <div class="box-header with-border">
                Add /update University Roll No
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="date-sheet" class="table table-bordered" width="100%">
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('script')
  <script>
    var datesheet = new Vue({
        el:"#datesheet",
            data:{
                course_id:'',
                table : null,
                tData:[],
                errors: {},
                createUrl:'uni-rollno',
                pupin_no:'',
                showRoll:false,
                status:''

            },
            ready:function(){
                var self = this;
                self.setDatatable();
                // self.reloadTable();
                
            },
           
            methods: {
                resetData:function(){
                    var self = this;
                    self.course_id ='';
                    self.tData = [];
                    self.reloadTable();
                    self.showRoll = false;
                },
                updateDetail: function(id,field_name,value){
                    var self = this;
                    var data = {
                        'field_name' : field_name,
                        'id' : id,
                        'value' : value,
                    }
                    axios.post(self.createUrl,data)
                    .then(function(response){
                        
                    })
                    .catch(function(){});
                },
                getData: function() {
                    var self = this;
                    axios.get(MCM.base_url +'/'+ self.createUrl,
                    {
                        params: {
                            course_id: self.course_id,
                        }
                    })
                    .then(function (response)
                    {
                        if(response.data.success) {
                            console.log('sdfsdf');
                            self.tData = response.data.data;
                            self.status = response.data.status;
                            self.reloadTable();
                            if(self.tData.length > 0){
                                self.showRoll = true;
                            }
                            else{
                                self.showRoll = false;
                            }
                        }
                    })
                    .catch(function (error)
                    {
                        console.log(error);
                        self.errors = error.response.data.errors;
                    });
                },


                reloadTable: function() {
                    var self = this;
                    self.table.clear();
                    if(this.status == 'GRAD') {
                        console.log(self.table);
                        self.table.column(5).visible(false);
                    }
                    else{
                        self.table.column(5).visible(true);
                    }
                    self.table.rows.add(self.tData).draw();
                },
                
                setDatatable: function(){
                    self = this;
                    var target = 0;
                   
                    
                    this.table = $('#date-sheet').DataTable({
                //      "searchDelay": 1000,
                        dom: 'Bfrtip',
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
                                header: true,
                                footer: true,
                                extend: 'pdfHtml5',
                                download: 'open',
                                orientation: 'landscape',
                                pageSize: 'LEGAL',
                                exportOptions: { orthogonal: 'export' }
                                // title: function () {
                                //       var title = '';
                                //         title += "Stock Register Report    ";
                                //         title += self.msg
                                //       return title;
                                // },
                            }
                        ],
                        "processing": true,
                        "scrollCollapse": true,
                //      "serverSide": true,
                        "ordering": true,
                        data: [],
                        columnDefs: [
                        { title: 'S.No.', targets: target++, data: 'id',
                        "render": function( data, type, row, meta) {
                            return meta.row + 1;
                        }},
                        
                        { title: 'College Roll', targets: target++, data: 'roll_no',
                        },
                        { title: 'Student Name', targets: target++, data: 'name',
                        },
                        { title: 'Father Name', targets: target++, data: 'father_name' },
                        
                        { title: 'Pu Roll no', targets: target++,data: 'pu_regno',
                            "render":function(data, type, row, meta){
                                var str = '';
                                str += '<input data-field-name="pu_regno" type="text" data-item-action="Edit Detail" data-stu-id="'+row.id+'" class="form-control edit-detail" value="'+data+'">';
                                return str;
                            //    return '<input type="text" name="pu_regno" value='+row.pu_regno+'  class="form-control">';

                            }
                        },

                        {title: 'Pu Roll no 2', targets: target++,data: 'pu_regno2',
                            "render":function(data, type, row, meta){
                                var str = '';
                                str += '<input data-field-name="pu_regno2" type="text" data-item-action="Edit Detail" data-stu-id="'+row.id+'" class="form-control edit-detail" value="'+data+'">';
                                return str;
                            //    return '<input type="text" name="pu_regno" value='+row.pu_regno+'  class="form-control">';

                            }
                        },
                        { title: 'Pupin No', targets: target++,data: 'pupin_no',
                            "render":function(data, type, row, meta){
                                var str = '';
                                str += '<input data-field-name="pupin_no" type="text" data-item-action="Edit Detail" data-stu-id="'+row.id+'" class="form-control edit-detail" value="'+data+'">';
                                return str;
                                // return '<input type="text" name="pupin_no" value='+row.pupin_no+'  class="form-control">';
                            }
                        },
                        { targets: '_all', visible: true },
                        
                        ],
                        "drawCallback": function( settings ) {
                            $('.edit-detail').change(function(e) {
                                self.updateDetail(e.target.dataset.stuId, e.target.dataset.fieldName, e.target.value );
                            });
                            // console.log(settings.aoData);
                        }
                //      "deferRender": true,
                        // "sScrollX": true,
                    });
                   
                    
                },
            
            }
    });
  </script>
@stop
