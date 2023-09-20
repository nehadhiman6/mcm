<script>
var vm = new Vue({
    el: '#app',
    data: {
      subjects: {},
      subject_id: {{ $course->subject_id ?: 0 }},
     // uni_code: '',
    },
    ready: function(){
      this.getSubjectList();
//      $('#subject_id').select2({
//        placeholder: 'Select an option'
//      });
      if(this.subject_id > 0)
        $('#subject_id').val(this.subject_id).trigger('change');
//      $('#subject_id').on('change',function(){
//         vm['subject_id'] = $(this).val();
//      });
    },
    computed: {
      uni_code: function() {
        self = this;
        code = '';
        $(this.subjects).filter(function(i, n) {
          if(n.id == self.subject_id) {
            if(n.uni_code)
            code = n.uni_code;
            return true;
          }
        });
        return code;
      }
    },
    methods: {
      getSubjectList: function() {
        this.$http.get("{{ url('/subjects/list') }}"
        ).then(function (response) {
          this.subjects = $.parseJSON(response.data);
        },function (response) {
          console.log(response.data);
        });
      },
 
    }
  });
  </script>