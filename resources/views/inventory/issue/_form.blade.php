<div class="form-group">
  {!! Form::label('issue_dt','Date:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('issue_dt',null,['class' => 'form-control app-datepicker', 'v-model'=>'issue_dt']) !!}
    <span v-if="hasError('issue_dt')" class="text-danger" v-html="errors['issue_dt'][0]"></span>
  </div>
  {!! Form::label('loc_id','Location:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('loc_id',getLocations(),null, ['class' => 'form-control select2','v-model'=>'loc_id']) !!}
    <span v-if="hasError('loc_id')" class="text-danger" v-html="errors['loc_id'][0]"></span>

  </div>
</div>
<div class="form-group">
    {!! Form::label('request_no','Request No:',['class' => 'col-sm-2 control-label required']) !!}
    <div class="col-sm-3">
      {!! Form::text('request_no',null,['class' => 'form-control','v-model'=>'request_no']) !!}
      <span v-if="hasError('request_no')" class="text-danger" v-html="errors['request_no'][0]"></span>
    </div>
  <!-- {!! Form::label('person','Person:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('person',null,['class' => 'form-control','v-model'=>'person']) !!}
    <span v-if="hasError('person')" class="text-danger" v-html="errors['person'][0]"></span>
  </div> -->
  {!! Form::label('type','Staff',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
      <select class="form-control select2staff" type="text" v-model="staff_id" >
        <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
        <option v-for="value in staff" :value="value.id" :key="value.id">@{{ value.name }}  @{{ value.middle_name }}  @{{ value.last_name }}  ( @{{ value.dept.name }} )</option>
      </select>
      <span v-if="hasError('staff_id')" class="text-danger" v-html="errors['staff_id'][0]"></span>
  </div>

</div>
<div class="form-group">
  {!! Form::label('store_id','Store Locations:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
    {!! Form::select('store_id',getStoreLocations(),null, ['class' => 'form-control','v-model' => 'store_id']) !!}
    <span v-if="hasError('store_id')" class="text-danger" v-html="errors['store_id'][0]"></span>
  </div>
  {!! Form::label('remarks','Remarks:',['class' => 'col-sm-2 control-label']) !!}
  <div class="col-sm-3">
      {!! Form::text('remarks',null,['class' => 'form-control','v-model'=>'remarks']) !!}
      <span v-if="hasError('remarks')" class="text-danger" v-html="errors['remarks'][0]"></span>
  </div>
</div>

<table class= "table table-bordered table-hover table-condensed" id="table-bills">
  <thead>
    <tr>
      <th>S.No.</th>
      <th>Item</th>
      <th>Description</th>
      <th>Req For</th>
      <th>Stock Quantity</th>
      <th>Quantity</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
      <tr v-for="(key,row) in issue_det" :key="key">
        <td class="sno"><p class="form-control-static">@{{key+1}}</p></td>
        <td>
            <select class="form-control it_name select2item" :data-key="key" type="text" v-model="row.item_id" >
              <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
              <option v-for="value in items" :value="value.id" :key="value.id">@{{ value.item }}</option>
            </select>
            <span v-if="hasError('issue_det.'+key+'.item_id')" class="help-block" v-html="errors['issue_det.'+key+'.item_id'][0]"></span>
        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.description" />
            <span v-if="hasError('issue_det.'+key+'.description')" class="help-block" v-html="errors['issue_det.'+key+'.description'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.req_for" />
            <span v-if="hasError('issue_det.'+key+'.req_for')" class="help-block" v-html="errors['issue_det.'+key+'.req_for'][0]"></span>

        </td>
        <td>
            <input class="form-control it_name" disabled type="text" v-model="" >
        </td>
        <td>
            <input class="form-control it_name" type="text" v-model="row.req_qty" @blur="addRowItems()"/>
            <span v-if="hasError('issue_det.'+key+'.req_qty')" class="help-block" v-html="errors['issue_det.'+key+'.req_qty'][0]"></span>

        </td>
        <th><button class="btn add_btn btn-sm" @click.prevent="deleteRowItems(key)">X</button>
        </th>
    </tr>
  </tbody>
</table>
{{-- <button class="btn add_btn btn-sm" @click.prevent="addRowItems()">+</button> --}}
<br>
<div class="box-footer">
    <button class="btn btn-primary" v-if="id > 0" @click.prevent="submit()">Update Issue</button>
    <button class="btn btn-primary" v-else  @click.prevent="submit()">Add Issue</>

</div>
