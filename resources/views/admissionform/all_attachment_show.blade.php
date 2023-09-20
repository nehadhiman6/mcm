@extends('app')
@section('content')
<div id="attachment">
    <div class='panel panel-default' id='app'>
        <div class='panel-heading'>
          <strong>Adsmission Attachments     </strong>
          <strong>    (@{{student.id}} ,@{{student.name}} , @{{student.course.course_name}} )</strong>
        </div>
      </div>
    <div class="info-slideshow-container">

        <span v-for="(index, attach) in student.attachments">
            <div class="info_mySlides info-fadeslide">
                <div class="text">@{{attach.file_type}}</div>
                <span v-if="attach.file_ext == 'pdf'">
                    <embed :src="attachUrl+'/'+adm_id+'/'+attach.file_type"  width="100%" height="1200px"/>
                </span>
                <span v-else>
                    <center>
                    <img :src="attachUrl+'/'+adm_id+'/'+attach.file_type"  class="img-fluid" alt="Responsive image">
                    </center>
                </span>

                    {{-- <img :src="attachUrl+'/'+adm_id+'/'+attach.file_type" style="width:100%"> --}}
                
            </div>
        </span>
        <!-- Next and previous buttons -->
        <a class="info-prev your-element" @click.prevent="plusSlides(-1)" v-show="disabled">&#10094;</a>
        <a class="info-next your-element" @click.prevent="plusSlides(1)">&#10095;</a>
    </div>
    
    
</div>

@stop

@section('script')
<script>
    
   vm1 = new Vue({
        el: '#attachment',
        data: {
          adm_id: {{ (isset($student) && $student->exists) ? $student->id : 0 }},
          student: {!! json_encode($student) !!},
          attachUrl: "{{ isset($guard) && $guard == 'web' ? url('attachment') : url('stdattachment') }}",
          files: [],
          exams: {!! getAcademicExam(true) !!},
          response: {},
          success: false,
          fails: false,
          msg: '',
          errors: {},
          slideIndex:'1',
          disabled:false
        },
        created:function (){
            var self = this;
            $("body").keydown('your-element',function(e){
                if(e.keyCode == 37){
                  if(self.disabled == true){
                      self.plusSlides(-1);
                  }
                }
                else if(e.keyCode == 39){
                    self.plusSlides(1);
                }
            })
        },
        ready: function () {
            var self =this;
            this.showSlides(this.slideIndex);
            
            
        },
        methods: {
            plusSlides:function(n) {
                this.disabled = true;
                this.showSlides(this.slideIndex += n);
            },

            // currentSlide:function(n) {
            //     this.showSlides(this.slideIndex = n);
            // },

            showSlides:function(n) {
                let i;
                let slides = document.getElementsByClassName("info_mySlides");
                // let dots = document.getElementsByClassName("dot");
                if (n > slides.length) {
                    this.slideIndex = 1
                }    
                if (n < 1) 
                {
                    this.slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";  
                }
                // for (i = 0; i < dots.length; i++) {
                //     dots[i].className = dots[i].className.replace(" active", "");
                // }
                slides[this.slideIndex-1].style.display = "block";  
                // dots[this.slideIndex-1].className += " active";
            }

        },
         
          
    });
</script>
@stop

<style>

/* Slideshow container */
.info-slideshow-container {
  max-width: 1000px;
  position: relative;
  margin: auto;
}

/* Hide the images by default */
.info_mySlides {
  display: none;
}

/* Next & previous buttons */
.info-prev, .info-next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  margin-top: -22px;
  padding: 16px;
  color: white;
  font-weight: bold;
  font-size: 18px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
}

/* Position the "next button" to the right */
.info-next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.info-prev:hover, .info-next:hover {
  background-color: rgba(0,0,0,0.8);
}




.info-active{
  background-color: #717171;
}

/* Fading animation */
.info-fadeslide {
  animation-name: fade;
  animation-duration: 1.5s;
}
/
</style>
