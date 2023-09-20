<table class= "table table-bordered table-hover table-condensed" id="table-bills">
  <thead>
    <tr>
      <th>S.No.</th>
      <th>Item</th>
      <th>Quantity</th>
      <th>Store Location</th>
    </tr>
  </thead>
  <tbody>
      <tr v-for="(key,row) in opening_det" :key="key">
        <td class="sno"><p class="form-control-static">@{{key+1}}</p></td>
        <td>
            <select class="form-control it_name" :id="key" type="text" v-model="row.item_id" >
              <!-- <option v-for="(key,value) in items" :value="key">@{{value}}</option> -->
              <option v-for="value in items" :value="value.id" :key="value.id">@{{ value.item }}</option>
            </select>
            <span v-if="hasError('opening_det.'+key+'.item_id')" class="help-block" v-html="errors['opening_det.'+key+'.item_id'][0]"></span>
        </td>
        <td>
            <input class="form-control" type="text" v-model="row.r_qty" @blur = "addRowItems()"/>
            <span v-if="hasError('opening_det.'+key+'.r_qty')" class="help-block" v-html="errors['opening_det.'+key+'.r_qty'][0]"></span>
        </td>
        <td>          
            {!! Form::select('row.store_id',getStoreLocations(),null, ['class' => 'form-control','v-model'=>'row.store_id']) !!}
            <span v-if="hasError('opening_det.'+key+'.store_id')" class="help-block" v-html="errors['opening_det.'+key+'.store_id'][0]"></span>
        </td>
        <th><button class="btn add_btn btn-sm" @click.prevent="deleteRowItems(key)">X</button>
        </th>
    </tr>
  </tbody>
</table>

{{-- <div class="form-group">
  {!! Form::label('item_id','Item:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::select('item_id',getItems(),null,['class' => 'form-control']) !!}
  </div>
  {!! Form::label('r_r_qty','Opening Stock:',['class' => 'col-sm-2 control-label required']) !!}
  <div class="col-sm-3">
    {!! Form::text('r_r_qty',null,['class' => 'form-control']) !!}
  </div>
</div> --}}
