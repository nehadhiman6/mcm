<template id="feehead-template">
  <tr @click="showSubHeads">
    <th>( <i class="fa" :class="{ 'fa-plus': !open, 'fa-minus': open }"></i> ) @{{ fh }}</th>
    <th>@{{ feeheadAmount }}</th>
    <th>@{{ feeheadReceived }}</th>
    <th>@{{ feeheadConcession }}</th>
    <th>@{{ feeheadBalance }}</th>
  </tr>
  <tr is="subhead" v-for='fees in subheadsList' :fees.sync="fees" :fh="fh" :index="$index">
</template>

<template id="subhead-template">
  <tr>
    <td>@{{ fees.subhead.name }}</td>
    <td>@{{ fees.amount }}</td>
    <td v-bind:class="{ 'has-error': $root.errors['pend_bal.'+fh+'.'+index+'.amt_rec'] }" >
      <input class="form-control" type="text" number v-model="fees.amt_rec" />
    </td>
    <td v-bind:class="{ 'has-error': $root.errors['pend_bal.'+fh+'.'+index+'.concession'] }" >
      <input class="form-control" type="text" number v-model="fees.concession" />
    </td>
    <td v-bind:class="{ 'has-error': errors['fees.fee_amt'] }">
      <p class="form-control-static">@{{ balance }}</p>
    </td>
  </tr>
</template>

@push('vue-components')
<script>
  var MyComponent = Vue.extend({
    template: '#feehead-template',
    props: ['fh', 'pendbal', 'index', 'services', 'fee_rec_id'],
    data: function() {
      return {
        open: false,
        dirty: false,
        success: false,
        fails: false,
        msg: '',
        errors: '',
      }
    },
    computed: {
      subheadsList: function() {
        if (this.open)
          return this.pendbal
        else
          return [];
      },

      feeheadAmount: function() {
        var t = 0;
        _.each(this.pendbal, function(sh, i) {
            t += sh.amount * 1;
        });
        return t;
      },

      feeheadConcession: function() {
        var t = 0;
        _.each(this.pendbal, function(sh, i) {
            t += sh.concession * 1;
        });
        return t;
      },

      feeheadReceivable: function() {
        return this.feeheadAmount - this.feeheadConcession;
      },

      feeheadReceived: function() {
        var t = 0;
        _.each(this.pendbal, function(sh, i) {
            t += sh.amt_rec * 1;
        });
        return t;
      },

      feeheadReceivable: function() {
        return this.feeheadAmount - this.feeheadConcession - this.feeheadReceived;
      },

    },
    methods: {
      chkCharge: function() {
       if(this.fees.charge )
          this.fees.fee_amt = this.fees.amount;
        this.updateBalance();
      },

      updateBalance: function() {
        this.fees.fee_amt = this.toNumber(this.fees.amount)-this.toNumber(this.fees.amy_rec);
      },

      showSubHeads: function() {
        this.open = ! this.open;
      },

      toNumber: function(val) {
        val = parseFloat(val);
        return (isNaN(val) ? 0 : val);
      },
    },

    components: {
      subhead: {
        template: '#subhead-template',
        props: ['fees', 'fh', 'index'],

        computed: {
          chargeable: function() {
            if (this.fees.optional == 'N' || this.fees.charge == 'Y')
              return true;
            return false;
          },

          receivable: function() {
            return this.fees.amount - this.fees.concession
          },

          balance: function() {
            return this.receivable - this.fees.amt_rec;
          }
        },

        methods: {
          updateBalance: function() {
            if(this.receivable >= 0 && this.fees.amt_rec >= 0)
              this.fees.amt_rec =  this.receivable;
          },

          toNumber: function(val) {
            val = parseFloat(val);
            return (isNaN(val) ? 0 : val);
          },
        }
      }
    }
  });
  Vue.component('feehead', MyComponent)
</script>
@endpush