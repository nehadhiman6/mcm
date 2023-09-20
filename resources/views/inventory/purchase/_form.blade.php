<div class="form-group">
  {!! Form::label('trans_dt','Date:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('trans_dt',null,['class' => 'form-control app-datepicker', 'v-model'=>'trans_dt']) !!}
    <span v-if="hasError('trans_dt')" class="text-danger" v-html="errors['trans_dt'][0]"></span>
  </div>
</div>
<div class="form-group">
  {!! Form::label('vendor_code','Vendor Code:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('vendor_code',null, ['class' => 'form-control','v-model'=>'vendor_code', '@blur' => "getCodeVendor('vendor_code')"]) !!}
    <span v-if="hasError('vendor_code')" class="text-danger" v-html="errors['vendor_code'][0]"></span>
  </div>
  {!! Form::label('vendor_id','Vendor:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-4">
    {!! Form::select('vendor_id',getVendors(),null, ['class' => 'select2 form-control','v-model'=>'vendor_id', '@change'=>"getCodeVendor('vendor_id')"]) !!}
    <span v-if="hasError('vendor_id')" class="text-danger" v-html="errors['vendor_id'][0]" ></span>
  </div>
</div>
<div class="form-group">
  {!! Form::label('bill_no','Bill No:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('bill_no',null,['class' => 'form-control','v-model'=>'bill_no']) !!}
    <span v-if="hasError('bill_no')" class="text-danger" v-html="errors['bill_no'][0]"></span>

  </div>
  {!! Form::label('bill_dt','Bill Date:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('bill_dt',null,['class' => 'form-control app-datepicker','v-model'=>'bill_dt']) !!}
    <span v-if="hasError('bill_dt')" class="text-danger" v-html="errors['bill_dt'][0]"></span>
  </div>
</div>

<div class="form-group">
  {!! Form::label('store_id','Store Location:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('store_id',getStoreLocations(),null, ['class' => 'form-control','v-model'=>'store_id']) !!}
    <span v-if="hasError('store_id')" class="text-danger" v-html="errors['store_id'][0]"></span>
  </div>
  {!! Form::label('grant','Grant Under:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('grant',getGrants(),null, ['class' => 'form-control','v-model'=>'grant']) !!}
    <span v-if="hasError('grant')" class="text-danger" v-html="errors['grant'][0]"></span>
  </div>
</div>

<table class= "table table-bordered table-hover table-condensed" id="table-bills">
  <thead>
    <tr>
      <th>S.No.</th>
      <th>Code</th>
      <th>Item</th>
      <th>Description</th>
      <th>Quantity</th>
      <th>Rate</th>
      <th>Amount</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr v-for="(key,row) in purchase_det" :key="key">
        <td class="sno"><p class="form-control-static">@{{key+1}}</p></td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.code"  @blur = "getCodeItem('item_code',key)" >
            <span v-if="hasError('purchase_det.'+key+'.code')" class="help-block" v-html="errors['purchase_det.'+key+'.code'][0]"></span>

        </td>
        <td>
            <select class="form-control it_name select2item" :id="key" type="text" v-model="row.item_id" @change = "getCodeItem('item_id',key)">
              <!-- <option v-for="(index,value) in items" :value="index">@{{index.}}</option> -->
              <option v-for="value in items" :value="value.id" :key="value.id">@{{ value.item }}</option>
            </select>
            <span v-if="hasError('purchase_det.'+key+'.item_id')" class="help-block" v-html="errors['purchase_det.'+key+'.item_id'][0]"></span>
        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.item_desc"/>
            <span v-if="hasError('purchase_det.'+key+'.item_desc')" class="help-block" v-html="errors['purchase_det.'+key+'.item_desc'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.qty" @blur="getAmount(key)"/>
            <span v-if="hasError('purchase_det.'+key+'.qty')" class="help-block" v-html="errors['purchase_det.'+key+'.qty'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.rate" @blur="getAmount(key)"/>
            <span v-if="hasError('purchase_det.'+key+'.rate')" class="help-block" v-html="errors['purchase_det.'+key+'.rate'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.amount" disabled/>
            <span v-if="hasError('purchase_det.'+key+'.amount')" class="help-block" v-html="errors['purchase_det.'+key+'.amount'][0]"></span>

        </td>
        <th><button class="btn add_btn btn-sm" @click.prevent="deleteRowItems(key)">X</button>
        </th>
    </tr>
  </tbody>
</table>
{{-- <button class="btn add_btn btn-sm" @click.prevent="addRowItems()">+</button> --}}
{{-- <br> --}}
<div class="form-group col-md-offset-4">
    {!! Form::label('total_amount','Total Amount:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-3">
      {!! Form::text('total_amount',null,['class' => 'form-control','v-model'=>'total_amount', 'disabled']) !!}
      <span v-if="hasError('total_amount')" class="text-danger" v-html="errors['total_amount'][0]" ></span>
    </div>
    </div>
  </div>
<br>
<div class="box-footer">
    <button class="btn btn-primary" v-if="id > 0" @click.prevent="submit()">Update Purchase</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Add Purchase</>

</div>
