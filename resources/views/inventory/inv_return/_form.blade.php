<div class="form-group">
  {!! Form::label('trans_dt','Date:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-2">
    {!! Form::text('trans_dt',null,['class' => 'form-control app-datepicker', 'v-model'=>'trans_dt']) !!}
    <span v-if="hasError('trans_dt')" class="text-danger" v-html="errors['trans_dt'][0]"></span>
  </div>
</div>
<div class="form-group">
    {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      {!! Form::select('loc_id',getLocations(),null, ['class' => 'form-control select2','v-model'=>'loc_id']) !!}
      <span v-if="hasError('loc_id')" class="text-danger" v-html="errors['loc_id'][0]"></span>
    </div>
    {!! Form::label('remarks','Remarks:',['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-4">
      {!! Form::text('remarks',null,['class' => 'form-control','v-model'=>'remarks']) !!}
      <span v-if="hasError('remarks')" class="text-danger" v-html="errors['remarks'][0]"></span>
  
    </div>
</div>

<div class="form-group">
  {!! Form::label('store_id','Store Location:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('store_id',getStoreLocations(),null, ['class' => 'form-control','v-model' => 'store_id']) !!}
    <span v-if="hasError('store_id')" class="text-danger" v-html="errors['store_id'][0]"></span>
  </div>
  
  {!! Form::label('type','Staff',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
      <select class="form-control select2staff" type="text" v-model="staff_id" >
        <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
        <option v-for="value in staff" :value="value.id" :key="value.id">@{{ value.name }}  @{{ value.middle_name }}  @{{ value.last_name }}  ( @{{ value.dept.name }} )</option>

        <!-- <option v-for="value in staff" :value="value.id" :key="value.id">@{{ value.name }}  @{{ value.middle_name }}  @{{ value.last_name }}</option> -->
      </select>
      <span v-if="hasError('staff_id')" class="text-danger" v-html="errors['staff_id'][0]"></span>
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
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr v-for="(key,row) in ret_det" :key="key">
        <td class="sno"><p class="form-control-static">@{{key+1}}</p></td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.code"  @blur = "getCodeItem('item_code',key)" >
            <span v-if="hasError('ret_det.'+key+'.code')" class="help-block" v-html="errors['ret_det.'+key+'.code'][0]"></span>

        </td>
        <td>
            <select class="form-control it_name select2item" :id="key" type="text" v-model="row.item_id" @change = "getCodeItem('item_id',key)">
              <!-- <option v-for="(index,value) in items" :value="index">@{{value}}</option> -->
              <option v-for="value in items" :value="value.id" :key="value.id">@{{ value.item }}</option>
              
            </select>
            <span v-if="hasError('ret_det.'+key+'.item_id')" class="help-block" v-html="errors['ret_det.'+key+'.item_id'][0]"></span>
        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.item_desc"/>
            <span v-if="hasError('ret_det.'+key+'.item_desc')" class="help-block" v-html="errors['ret_det.'+key+'.item_desc'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.qty" @blur = "addRowItems()"/>
            <span v-if="hasError('ret_det.'+key+'.qty')" class="help-block" v-html="errors['ret_det.'+key+'.qty'][0]"></span>
        </td>
        <th><button class="btn add_btn btn-sm" @click.prevent="deleteRowItems(key)">X</button>
        </th>
    </tr>
  </tbody>
</table>
<br>
<div class="box-footer">
    <button class="btn btn-primary" v-if="id > 0" @click.prevent="submit()">Update Return</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Add Return</>

</div>
