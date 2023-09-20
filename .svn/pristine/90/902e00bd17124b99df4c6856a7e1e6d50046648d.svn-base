@extends('app')
@section('toolbar')
@include('toolbars._users_toolbar')
@stop
@section('content')
<div id="app" v-cloak>
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>{{ $group->group_name }} Permissions</strong>
    </div>
    {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
    <div class="panel-body">
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>SNo.</th>
            <th>Permission</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in grp_permissions">
            <td>@{{ $index + 1 }}</td>
            <td>@{{ permission.label }}</td>
            <td>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="permission_id[]" value="@{{ permission.id }}" number v-model="remove_ids"/>
                </label>
              </div>
            </td>
            </div>
          </tr>
        </tbody>
      </table>
      <input class="btn btn-primary" :disabled="remove_ids.length == 0" @click.prevent="removePermissions" type="submit" value="REMOVE">

    </div>
    {!! Form::close() !!}
  </div>
  <div class="box box-info">
    <div class="box-header with-border">
      <h3 class="box-title">Add Permissions to {{ $group->group_name }}</h3>
    </div>
    <div class="box-body">
      {!! Form::open(['url' => '', 'class' => 'form-horizontal']) !!}
      <table id="example1" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>SNo.</th>
            <th>Permission</th>
            <th>Add</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="permission in permissions">
            <td>@{{ $index + 1 }}</td>
            <td>@{{ permission.label }}</td>
            <td>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="permission_id[]" value="@{{ permission.id }}" number v-model="add_ids"/>
                </label>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="box-footer">
      <input class="btn btn-primary" :disabled="add_ids.length == 0" @click.prevent="addPermissions" type="submit" value="ADD">
      {!! Form::close() !!}
    </div>
    @if (config('college.app_location') == 'local')
    {{ getVueData() }}
    @endif
  </div>
</div>
@stop

@section('script')
<script>
  var vm = new Vue({
      el: '#app',
      data: {
        remove_ids: [],
        add_ids: [],
        permissions: {!! $permissions->toJson() !!},
        grp_permissions: {!! $grp_permissions->toJson() !!},
      },
      methods:{
        addPermissions: function() {
          this.$http.post("{{ url('groups/' . $group->id . '/addpermissions') }}", { add_ids: this.add_ids })
            .then(function (response) {
              this.permissions = response.data.permissions;
              this.grp_permissions = response.data.grp_permissions;
              this.add_ids = [];
            }, function (response) {
              this.errors = response.data;
              console.log(response.data);              
            });
          console.log('save');
        },
        removePermissions: function() {
          this.$http.post("{{ url('groups/' . $group->id . '/rmvpermissions') }}", { remove_ids: this.remove_ids })
            .then(function (response) {
              this.permissions = response.data.permissions;
              this.grp_permissions = response.data.grp_permissions;
              this.remove_ids = [];
            }, function (response) {
              self = this;
              this.errors = response.data;
              console.log(response.data);              
            });
          console.log('Removed');
        },
      }
  });
</script>
@stop
