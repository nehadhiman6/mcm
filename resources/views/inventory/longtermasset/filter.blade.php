<div class="row" id="app">
    <div class="col-md-12">
        <div class="box box-default box-solid">
            <div class="box-header with-border">
                <div class="box-tools pull-right"></div>
                <h3 class="box-title">Long Term Asset</h3>
            </div>
            {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('date_from','From:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_from',null,['class' => 'form-control app-datepicker']) !!}
                    </div>
                    {!! Form::label('to','To:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        {!! Form::text('date_to',null,['class' => 'form-control app-datepicker']) !!}
                    </div>
                </div>
                <div class="form-group">
                    {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('item_id',getitems(),0,['class' => 'form-control']) !!}
                    </div>

                    {!! Form::label('store_location_id','Store:',['class' => 'col-sm-1 control-label required'] ) !!}
                     <div class="col-sm-3">
                         {!! Form::select('store_location_id',getStoreLocations(),old('store_location_id',0), ['class' => 'form-control']) !!}
                     </div>

                    {{-- {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label ']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('loc_id',getLocations(),0,['class' => 'form-control select2']) !!}
                    </div> --}}
                </div>
                <!-- <div class="form-group">
                    {!! Form::label('cat_id','Category:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('cat_id',getItemCategories(),0,['class' => 'form-control']) !!}
                    </div>
                    {!! Form::label('sub_cat_id','Sub-Category:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select('sub_cat_id',getItemSubCategories(),0,['class' => 'form-control']) !!}
                    </div>
                </div> -->
                <!-- <div class='form-group' > -->
                    <!-- {!! Form::label('radio_button',"Type:",['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2" >
                        <label class="radio-inline">
                            {!! Form::radio('radio_button', 'Y',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_btn_1', '@change' => "update"]) !!}Store
                        </label> -->
                        <!-- <label class="radio-inline">
                            {!! Form::radio('radio_button', 'N',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_btn_2', '@change' => "update"]) !!}Location
                        </label> -->
                    <!-- </div> -->
                    
                     <!-- <div v-if="show_loc">
                        {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label', 'v-if' => ' radio_button == "N" ']) !!}
                        <div class="col-sm-3 " >{{--v-if="radio_button == 'N'"--}}
                            {!! Form::select('loc_id',getLocations(),old('loc_id',0), ['class' => 'form-control', 'v-if' => ' radio_button == "N" ']) !!}
                        </div>
                    </div> -->
                <!-- </div> -->
            </div>
            <div class="box-footer">
                {!! Form::submit('Apply', ['class' => 'btn btn-primary','name' => 'btn-apply']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@section('script')
    <script>
        var vm = new Vue({
            el: '#app',
            data: {
              radio_button: '',
              select2: null,
              show_loc: false
            },
            ready: function() {
                // location
                var self = this;
                $('.select2').select2({
                    placeholder: 'Select Location',
                });
                $('.select2').on('change',function(e){
                    self.loc_id = $(this).val();
                });
            },
            methods: {
                update: function() {
                    if(this.radio_button == 'Y') {
                        if(this.select2) {
                            this.select2.select2('destroy');
                        }
                        this.show_loc = false;
                    }

                    if(this.radio_button != 'Y') {
                        this.show_loc = true;
                        this.$nextTick(function() {
                            this.select2 = $('#loc_id').select2();
                        })
                    }
                }
            }
        });
    </script>
@endsection