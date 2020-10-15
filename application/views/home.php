<body>

<div id="body">
<center>


        <!--start slideshow css-->

	    <style>
                /* {box-sizing:border-box}*/

                .mySlides {display:none}

                /* Slideshow container */
                .slideshow-container {
                  min-width:100%;
                    padding-top:10px;
                }

                /* Number text (1/3 etc) */
                .numbertext {
                  color: #f2f2f2;
                  font-size: 12px;
                  padding: 8px 12px;
                  position: absolute;
                  top: 0;
                }

                /* The dots/bullets/indicators */
                .dot {
                  cursor:pointer;
                  height: 13px;
                  width: 13px;
                  margin: 0 2px;
                  background-color: #bbb;
                  border-radius: 50%;
                  display: inline-block;
                  transition: background-color 0.6s ease;
                }

                .prev, .next {
                  z-index:0;
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
                }

                .prev{
                     margin-left:-285px;
                }

                /* Position the "next button" to the right */
                .next {
                    margin-right:10px;
                  right: 0;
                  border-radius: 3px 0 0 3px;
                }

                /* On hover, add a black background color with a little bit see-through */
                .prev:hover, .next:hover {
                  background-color: rgba(0,0,0,0.8);
                }

                .active {
                  background-color: #717171;
                }

                /* Fading animation */
                .fade {
                  -webkit-animation-name: fade;
                  -webkit-animation-duration: 1.5s;
                  animation-name: fade;
                  animation-duration: 1.5s;
                }

                @-webkit-keyframes fade {
                  from {opacity: .4}
                  to {opacity: 1}
                }

                @keyframes fade {
                  from {opacity: .4}
                  to {opacity: 1}
                }

                /* On smaller screens, decrease text size */
                @media only screen and (max-width: 300px) {
                  .text {font-size: 11px}
                }
	    </style>

        <!--end slideshow css-->


        <div>
          <center>
          <?$today = date("Y-m-d");?>
          <?if($today <= "2020-03-31"):?>


          <div class="slideshow-container">

							<div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/PROMO_Ads.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/PROMO_Ads.jpg" style="width:60%"></a>
            		<div class="text"></div>
          		</div>


          		<div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/GIFT_CHEQUES_landscape_DEC12.jpg" target="_blank">
                    <img src="<?=IMAGE_PATH?>/bliss/GIFT_CHEQUES_landscape_DEC12.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

          		<div class="mySlides fade">
            		<div class="numbertext"></div>
                    <a href="<?=IMAGE_PATH?>/bliss/ABENSON_ALLHOME_DEC12.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/ABENSON_ALLHOME_DEC12.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

    		      <div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/ONLINE_LOAN_DEC12.jpg" target="_blank">
                    <img src="<?=IMAGE_PATH?>/bliss/ONLINE_LOAN_DEC12.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

          		<div class="mySlides fade">
            		<div class="numbertext"></div>
                    <a href="<?=IMAGE_PATH?>/bliss/SHELL_CARD_DEC12.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/SHELL_CARD_DEC12.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>


          </div>
              <br>

              <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
      		      <span class="dot" onclick="currentSlide(2)"></span>
      		      <span class="dot" onclick="currentSlide(3)"></span>
                <span class="dot" onclick="currentSlide(4)"></span>
      		      <span class="dot" onclick="currentSlide(5)"></span>
      	      </div>
              <div class="clear"></div>


          <?else:?>


          <div class="slideshow-container">


          		<div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/1.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/1.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>


          		<div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/2.jpg" target="_blank">
                    <img src="<?=IMAGE_PATH?>/bliss/2.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

          		<!-- <div class="mySlides fade">
            		<div class="numbertext"></div>
                    <a href="<?=IMAGE_PATH?>/bliss/3.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/3.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>
 -->
    		      <div class="mySlides fade">
            		<div class="numbertext"></div>
            		<a href="<?=IMAGE_PATH?>/bliss/4.jpg" target="_blank">
                    <img src="<?=IMAGE_PATH?>/bliss/4.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

          		<div class="mySlides fade">
            		<div class="numbertext"></div>
                    <a href="<?=IMAGE_PATH?>/bliss/5.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/5.jpg" style="width:100%"></a>
            		<div class="text"></div>
          		</div>

              <!-- <div class="mySlides fade">
                <div class="numbertext"></div>
                    <a href="<?=IMAGE_PATH?>/bliss/6.jpg" target="_blank"><img src="<?=IMAGE_PATH?>/bliss/6.jpg" style="width:100%"></a>
                <div class="text"></div>
              </div> -->


          </div><br>
          <strong><font size="3.5"><a style="color:red" href="<?=FILES_PATH?>pricelist.pdf" target="_blank">(Latest Pricelist)</a></font></strong><br>
              <br>
              <div style="text-align:center">
                <span class="dot" onclick="currentSlide(1)"></span>
      		      <span class="dot" onclick="currentSlide(2)"></span>
      		      <!-- <span class="dot" onclick="currentSlide(3)"></span> -->
                <span class="dot" onclick="currentSlide(4)"></span>
      		      <span class="dot" onclick="currentSlide(5)"></span>
                <!-- <span class="dot" onclick="currentSlide(6)"></span> -->
      	      </div>
              <div class="clear"></div>
            <?endif;?>
        </div>

<!--start of existing scripts for sldieshow-->

<script>


var slideIndex = 1;
showSlides(slideIndex);

setInterval(function(){ autoSlides(); }, 5000);

function autoSlides() {
 var slides = document.getElementsByClassName("mySlides");

 if (slideIndex > slides.length) {slideIndex = 1}
 else {slideIndex++ }
  showSlides(slideIndex);
}

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  //alert(n.' x '.slides.length)
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";


}



</script>

<script>
$(document).ready(

	function()
	{
		$("#about_us_side").click(
		function()
		{
		    if( $(".about_us_side").attr("style") == '' ||
		        $(".about_us_side").attr("style") == 'display: block;'
	          ){
		    	 $(".about_us_side").hide();
		    }
			else{
				$(".about_us_side").attr("style, 'display:inline'");
				$(".about_us_side").show();
			}

    	});

    	$("#membership_side").click(
		function()
		{
		    if( $(".membership_side").attr("style") == '' ||
		        $(".membership_side").attr("style") == 'display: block;'
	          ){
		    	 $(".membership_side").hide();
		    }
			else{
				$(".membership_side").attr("style, 'display:inline'");
				$(".membership_side").show();
			}

    	});

    	$("#services_side").click(
		function()
		{
		    if( $(".services_side").attr("style") == '' ||
		        $(".services_side").attr("style") == 'display: block;'
	          ){
		    	 $(".services_side").hide();
		    }
			else{
				$(".services_side").attr("style, 'display:inline'");
				$(".services_side").show();
			}

    	});
    	/*
    	#DO NOT SHOW REPORTS
    	$("#reports_side").click(
		function()
		{
		    if( $(".reports_side").attr("style") == '' ||
		        $(".reports_side").attr("style") == 'display: block;'
	          ){
		    	 $(".reports_side").hide();
		    }
			else{
				$(".reports_side").attr("style, 'display:inline'");
				$(".reports_side").show();
			}

    	});
	    */
	}



);


</script>


<!--end of existing scripts for sldieshow-->


</body>
