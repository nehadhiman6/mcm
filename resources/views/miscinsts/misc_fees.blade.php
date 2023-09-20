<template id="misc-subhead-template">
  <tr>
    <td>
      <select class="form-control" id="subhead_id" v-model="sh.subhead_id" @change="addRow">
        <option value="0">Select SubHead</option>
        <option v-for='s in subheads' :value='s.id'>
          @{{ s.name }}
        </option>
      </select>
    </td>
    <td>@{{ subhead ? subhead.feehead.name : '' }}</td>
    <td>@{{ subhead ? subhead.feehead.fund.name : '' }}</td>
    <td v-bind:class="">
      <input class="form-control" type="text" number v-model="sh.amount" @change="updateBalance" />
    </td>
    <td v-bind:class="">
      <input class="form-control" type="text" number v-model="sh.amt_rec" @change="updateBalance"  />
    </td>
    <td>@{{ sh.balance }}</td>
  </tr>
</template>
@push('vue-components')
<script>
  var MyComponent1 = Vue.extend({
    template: '#misc-subhead-template',
    props: ['sh', 'subheads', 'misc_fees', 'counter','formdata',  'index', 'errors'],
    data: function() {
      return {
        dirty: false,
        success: false,
        fails: false,
        msg: '',
      }
    },
    events: {
      'data-dirty': function(state) {
        this.dirty = state;
      }
    },
    computed: {
      subhead: function() {
        var sh = _.findWhere(this.subheads,{'id': this.sh.subhead_id});
        return sh ? sh : "" ;
      }
    },
    methods: {
      addRow: function(e) {
        if(this.subhead) {
          this.sh.feehead_id = this.subhead.feehead.id;
          if(this.sh.no == this.counter && this.sh.subhead_id > 0) {
            try {
              this.counter++;
              var sh = new getBlankRow();
              sh.no = this.counter;
              this.misc_fees.splice(this.misc_fees.length + 1, 0, sh);
            } catch (e) {
              console.log(e);
            }
          }
        }
      },

      updateBalance: function() {
        this.sh.balance = this.toNumber(this.sh.amount)-this.toNumber(this.sh.amt_rec);
      },

      toNumber: function(val) {
        val = parseFloat(val);
        return (isNaN(val) ? 0 : val);
      }
    }
  });
  Vue.component('subhead', MyComponent1)
</script>
@endpush