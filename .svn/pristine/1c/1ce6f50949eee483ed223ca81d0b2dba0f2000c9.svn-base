@extends('app')
    @section('toolbar')
        @include('toolbars._students_toolbar')
    @stop
    @section('content')
        <div id='app'>
            <div class="panel panel-default">
                <div class='panel-heading'>
                    <strong>@{{ getTitle() }} </strong>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered" id="example1" width="100%">
                        <tfoot>
                            <th></th>
                            <th>Total:</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    @stop
    @section('script')
        <script>
             $.fn.dataTable.ext.errMode = 'none';

            $('#table').on( 'error.dt', function ( e, settings, techNote, message ) {
                console.log( 'An error has been reported by DataTables: ', message );
            } ) ;
            $(document).on('change', '.category ', function(e) {
                 dashboard.category_name = $('.category option:selected').text();
            });

            var dashboard = new Vue({
                el: '#app',
                data: {
                    tData: [],
                    session: {!! json_encode(get_fy_label()) !!},
                    table: null,
                    url: "{{ url('/') . 'consolidated-students/' }}",
                    students_data: [],
                    categories: {!! json_encode(getCategory('without')) !!},
                    columnDefs: [],
                    foreign_cat_id : {!! json_encode(getForeignCategory()) !!},
                },
                created: function() {
                    this.setColumns();
                    this.setDatatable();
                    this.getData();
                },
                methods: {
                    setDatatable(){
                        var self = this;
                        var target = 1;
                        self.table = $('#example1').DataTable({
                            dom: 'Bfrtip',
                            lengthMenu: [
                                [ 50 ],
                                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
                            ],
                            buttons: [
                                'pageLength',
                                {
                                    extend: 'excelHtml5',
                                    messageTop: self.getTitle(),
                                    exportOptions: { orthogonal: 'export' },
                                    footer: true,
                                    title: '',


                                },
                                {
                                    extend: 'pdfHtml5',
                                    messageTop: self.getTitle(),
                                    title: '',
                                    footer: true,
                                    customize: function(doc) {
                                        doc.styles.title = {
                                            alignment: 'center'
                                        }
                                        doc.styles.tableHeader = {
                                            color: 'black',
                                            alignment: 'centre',
                                        }
                                        
                                        
                                        // doc.styles.tableBodyEven = {
                                        //     background: 'yellow',
                                        //     alignment: 'right'
                                        // }
                                        // doc.styles.tableBodyOdd = {
                                        //     background: 'blue',
                                        //     alignment: 'right'
                                        // }
                                        doc.styles.tableFooter = {
                                            alignment: 'centre'
                                        }
                                        doc.styles['td:nth-child(2)'] = { 
                                            width: '100px',
                                            'max-width': '100px'
                                        }
                                    } ,

                                },
                            ],
                            "processing": true,
                            "scrollCollapse": true,
                            "ordering": true,
                            data: [],
                            columnDefs: self.columnDefs,                                
                            "footerCallback": function ( row, data, start, end, display ) {
                                var api = this.api(), data;
                                var colNumber = [2,3,4,5,6,7,8,9,10,11,12];
                    
                                    var intVal = function (i) {
                                        return typeof i === 'string' ? 
                                            i.replace(/[\$,]/g, '') * 1 :
                                            typeof i === 'number' ?
                                            i : 0;
                                    };

                                    for (i = 0; i < colNumber.length; i++) {
                                        var colNo = colNumber[i];
                                        var total2 = api
                                                .column(colNo,{ page: 'current'})
                                                .data()
                                                .reduce(function (a, b) {
                                                    return intVal(a) + intVal(b);
                                                }, 0);
                                        $(api.column(colNo, { page: 'current'}).footer()).html(total2);
                                    }
                            },
                            "sScrollX": true,

                        });
                        self.table.cells().eq(0).each( function ( index ) {
                            var cell = table.cell( index );
                            var data = cell.data();
                            // ... do something with data(), or cell.node(), etc
                        } );
                    },
                    getTitle(){
                        var self = this;
                        var str = 'Students Category Wise';
                        str += ' for the session ' + this.session;
                        return str;
                    },

                    getData: function() {
                        var self = this;
                        self.$http.get("{{ url('student-category-wise-report') }}")
                        .then(function (response) {
                            var students = response.data.students;
                            self.students_data = students;
                            // self.tData = response.data;
                            var course_id = '';
                            students.forEach(function(e){
                                if(course_id != e.course_id){
                                    var str_count = self.getStreamCount(e.course_id);
                                }
                                var row = {
                                    'id': e.id,
                                    'class': e.course_name,
                                    'course_id': e.cours_id,
                                    'str_class_wise': e.str_class_wise,
                                    'str_stream_wise' : str_count ? str_count : '',
                                };
                                course_id = e.course_id;
                                response.data.category_wise_students.forEach(function(ele) {
                                    if(row['course_id'] == ele.course_id){
                                        if(row[ele.cat_id] = ele.cat_id){
                                            row[ele.cat_id] = ele.cat_count;
                                        }
                                    }
                                });
                                response.data.state_wise_students.forEach(function(ele) {
                                    if(row['course_id'] == ele.course_id){
                                        row[ele.city] = ele.std_count;
                                    }
                                });
                                self.tData.push(row);

                            });
                            // self.tData(function(ele) {
                            //     response.data.category_wise_studentsforEach(function(elem) {
                                    
                            //     });
                            // });
                            self.reloadTable();
                        })
                        .catch(function(error){
                            console.log(error);
                        });
                    },

                    getStateCount(type){

                        return 0;
                    },

                    getStreamCount: function(name)
                    {
                        var count = 0;
                        this.students_data.forEach(function(e){
                            if(e.course_id == name){
                                count = count + e.str_class_wise;
                            }
                        });
                        return count;
                    },
                    
                    reloadTable: function() {
                        this.table.destroy()
                        this.table.clear();
                        this.setDatatable();
                        this.table.rows.add(this.tData).draw();
                    },

                    setColumns: function() {
                        var self = this;
                        var target = 0;
                        var fld_name = '';
                        var fld_name1 = '';
                        var cd = [];
                        cd = [
                            { targets: '_all', visible: true },
                           
                            { title: 'S.No.', targets: target++, data: 'id',
                                        "render": function( data, type, row, meta) {
                                        return meta.row + 1;
                                    }},
                                    { title: 'Class', targets: target++, data: 'class'},
                                    { title: 'Strength Class Wise', targets: target++, data: 'str_class_wise'},
                                    { title: 'Strength Stream Wise', targets: target++, data: 'str_stream_wise' },
                               
                        ];
                        var renderFunction = function( data, type, row, meta) {
                            return data ? data : '';
                        }
                        var i = 0;
                        var t = cd.length-1;
                        var title1 = '';
                        var row = {};
                        $.each(self.categories, function( key, field ) {
                            if(key != self.foreign_cat_id){
                                row = {
                                    data: key, 
                                    mData: key, 
                                    sTitle: field, 
                                    title: field, 
                                    targets: t++, 
                                    "render": renderFunction
                                }
                                cd.push(row);
                            }
                        });
                        
                        cd.push(
                            {data: 'tricity', mData: 'tricity', sTitle: 'Chandigarh/pkl/mohali', title: 'Chandigarh/pkl/mohali', targets: t++, "render": renderFunction },
                            {data: 'other', mData: 'other', sTitle: 'Other States', title: 'Other States', targets: t++, "render": renderFunction },
                            {data: self.foreign_cat_id, mData: self.foreign_cat_id, sTitle: "Foreign", title: "Foreign", targets: t++, "render": renderFunction },
                        );
                        self.columnDefs = cd;
                    },
                }
            });
        </script>
    @stop