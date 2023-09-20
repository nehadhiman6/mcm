<div class="row" id="app">
    <div class="col-md-12">
        <div class="box box-default box-solid 
             @if($errors->count()==0)
             {{-- collapsed-box --}}
             @endif
             ">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="">
                        @if($errors->count()==0)
                        <i class="fa fa-plus"></i>
                        @else
                        <i class="fa fa-minus"></i>
                        @endif
                    </button>
                </div><!-- /.box-tools -->
                <h3 class="box-title">Stock Register Filter</h3>
            </div><!-- /.box-header -->
            {!! Form::open($form_opts) !!}
            <div class="box-body">
                <div class="form-group">
                    {!! Form::label('date_from','From:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                          {!! Form::text('date_from',old('date_from',$dt1),['class' => 'form-control app-datepicker','v-model' => 'date_from']) !!}
                     </div>
                    {!! Form::label('to','To:',['class' => 'col-sm-3 control-label']) !!}
                    <div class="col-sm-2">
                          {!! Form::text('date_to',old('date_to',$dt2),['class' => 'form-control app-datepicker','v-model' => 'date_to']) !!}
                     </div>
                </div>
                <div class="form-group">
                    {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label']) !!}
                     <div class="col-sm-4">
                         {!! Form::select('item_id',getItems(),old('item_id',0), ['class' => 'select2item form-control', "data-allow-clear" => "true"]) !!}
                     </div>
                </div>
                {{-- <div class="form-group">
                    {!! Form::label('result','Radio:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {{ Form::radio('store',null,['v-model' => 'radio'] ) }}
                        {{ Form::radio('location',null,['v-model' => 'radio'] ) }}
                    </div> --}}
                <div class="form-group">
                   {!! Form::label('cat_id','Category:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('cat_id',getItemCategories(),old('cat_id',0), ['class' => 'select2cat form-control', "data-allow-clear" => "true"]) !!}
                    </div>
                    {!! Form::label('sub_cat_id','Sub-Category:',['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-3">
                        {!! Form::select('sub_cat_id',getItemSubCategories(),old('sub_cat_id',0), ['class' => 'select2subcat form-control', "data-allow-clear" => "true"]) !!}
                    </div>
                </div>
                <div class='form-group' >
                    {!! Form::label('radio_button',"Type:",['class' => 'col-sm-2 control-label required']) !!}
                    <div class="col-sm-2">
                        <label class="radio-inline">
                            {!! Form::radio('radio_button', 'Y',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_button_1', '@change' => "update"]) !!}Store
                        </label>
                        <label class="radio-inline">
                            {!! Form::radio('radio_button', 'N',null, ['class' => 'minimal','v-model'=>'radio_button', 'id' => 'radio_button_2', '@change' => "update"]) !!}Location
                        </label>
                    </div>
                    {!! Form::label('store_location_id','Store Location:',['class' => 'col-sm-3 control-label', 'v-if' => ' radio_button == "Y" '] ) !!}
                     <div class="col-sm-3" v-if="radio_button == 'Y'">
                         {!! Form::select('store_location_id',getStoreLocations(),old('store_location_id',0), ['class' => 'form-control','v-model' => 'store_id']) !!}
                     </div>
                    <div v-if="show_loc">
                        {!! Form::label('loc_id','Location:',['class' => 'col-sm-3 control-label','v-if' => ' radio_button == "N" ' ]) !!}
                        <div class="col-sm-3 " v-if="radio_button == 'N'">{{--v-if="radio_button == 'N'"--}}
                            {!! Form::select('loc_id',getLocations(),old('loc_id',0), ['class' => 'form-control selectlac','v-model' => 'loc_id', "data-allow-clear" => "true"]) !!}
                        </div>
                    </div>
                </div>
            </div><!-- /.box-body -->
            <div class="box-footer">
                {!! Form::submit('Apply', ['class' => 'btn btn-primary','name' => 'btn-apply']) !!}
            </div> 
            {!! Form::close() !!}
        </div><!-- /.box -->
    </div><!-- /.col -->
</div>

@section('script')
    <script>
        var vm = new Vue({
            el: '#app',
            data: {
                date_from: '',
                date_to: '',
                radio_button: '',
                select2: null,
                show_loc: true,
                btn_show:false,
                store_id: 0,
                loc_id: 0
            },
            ready: function() {
                // location
                var self = this;
                $('.select2').select2({
                    placeholder: 'Select Location',
                });
                $('.select2').on('change',function(e){
                    console.log('sdsfdgfd');
                    self.loc_id = $(this).val();
                });
            },
            methods: {
                update: function() {
                    var self = this;
                    if(self.radio_button == 'Y') {
                        if(this.select2) {
                            this.select2.select2('destroy');
                        }
                        this.show_loc = false;
                    }

                    if(self.radio_button == 'N') {
                        
                        self.show_loc = true;
                        this.$nextTick(function() {
                            console.log('qwqwwew');
                            this.select2 = $('#loc_id').select2();
                            console.log(this.select2);
                            $('.selectlac').select2({
                                placeholder: 'Select Location',
                            });
                            $('.selectlac').on('change',function(e){
                                self.loc_id = $(this).val();
                            });
                        })
                    }
                }
            }
        });
    </script>
@endsection