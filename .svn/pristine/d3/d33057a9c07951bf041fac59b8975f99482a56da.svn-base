<template id="feehead-template">
  <tr>
    <th>@{{ fh }}</th>
    <th>@{{ feeheadAmount }}</th>
    <th>@{{ feeheadReceived }}</th>
    <th>@{{ feeheadBalance }}</th>
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

      feeheadAmount: function() {
        var t = 0;
        _.each(this.pendbal, function(sh, i) {
          // console.log(sh);
            t += sh.amount * 1;
        });
        return t;
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
  });
  Vue.component('feehead', MyComponent)
</script>
@endpush