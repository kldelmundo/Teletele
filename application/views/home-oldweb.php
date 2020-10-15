	<style>
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; }


	</style>

	<style>
		/* {box-sizing:border-box}*/

		.mySlides {display:none}

		/* Slideshow container */
		.slideshow-container {
		  max-width: 1000px;
		  position: relative;
		  margin: auto;
		}

		/* Caption text */
		.text {
		  color: #f2f2f2;
		  font-size: 15px;
		  padding: 8px 12px;
		  position: absolute;
		  bottom: 8px;
		  width: 100%;
		  text-align: center;
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







<div id="body-left">

		<div id="left-content">

			<span class="tag-title">WELCOME TO OUR SITE!</span>
			<br>

			<div >
					<center>
						<!--<img src="<?=IMAGE_PATH?>welcome.png" />-->
						<div class="slideshow-container" style="max-width:1000px;min-width:250px;position:relative;margin:auto;">
										
											    <!--<div class="numbertext">1 / 7</div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/YEM-cut.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/YEM-cut.jpg" style="width:100%"></a>
												    <div class="text"></div>
											  	</div>-->

											  	<?$today = date("Y-m-d");?>
													<?$ded_line = "2020-01-10";?>
											  	<?if($today <= $ded_line):?>
											  	
												<div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/orig/1.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/Scheduled/1.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

									  			<div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/1-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/1-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/2-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/2-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Gridpoint.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/Gridpoint.JPG" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/4-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>


												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/3.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/3.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/4.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/All_Home.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/All_Home.JPG" style="width:100%"></a>
												    <div class="text"></div>



												 <?else:?>




													<div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/1-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/1-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/2-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/2-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Gridpoint.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/Gridpoint.JPG" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/4-20181012.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4-20181012.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>


												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/3.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/3.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												    <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/Originals/4.jpg" target="_blank"><img src="<?=IMAGE_PATH?>ads/4.jpg" style="width:100%"></a>
												    <div class="text"></div>
												  </div>

												  <div class="mySlides fade">
												     <div class="numbertext"></div>
												    <a href="http://www.telescoop.com.ph/assets/images/ads/All_Home.JPG" target="_blank"><img src="<?=IMAGE_PATH?>ads/All_Home.JPG" style="width:100%"></a>
												    <div class="text"></div>


											  	
											</div>

										<?endif;?>


										<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
			  							<a class="next" onclick="plusSlides(1)">&#10095;</a>
									</div>
										<br>

										<div style="text-align:center">
										   
										    <?if($today != $ded_line):?>
												  	
												<span class="dot" onclick="currentSlide(1)"></span>
											    <span class="dot" onclick="currentSlide(2)"></span>
											    <span class="dot" onclick="currentSlide(3)"></span>
											    <span class="dot" onclick="currentSlide(4)"></span>
											    <span class="dot" onclick="currentSlide(5)"></span>
											    <span class="dot" onclick="currentSlide(6)"></span>
											    <span class="dot" onclick="currentSlide(7)"></span>
													<span class="dot" onclick="currentSlide(8)"></span>

											<?else:?>

												<span class="dot" onclick="currentSlide(1)"></span>
											    <span class="dot" onclick="currentSlide(2)"></span>
											    <span class="dot" onclick="currentSlide(3)"></span>
											    <span class="dot" onclick="currentSlide(4)"></span>
											    <span class="dot" onclick="currentSlide(5)"></span>
											    <span class="dot" onclick="currentSlide(6)"></span>
											    <span class="dot" onclick="currentSlide(7)"></span>

										  	<?endif;?>
										    <!--<span class="dot" onclick="currentSlide(7)"></span>-->

										    <!--<span class="dot" onclick="currentSlide(6)"></span>-->
										</div>

												<br>
						<!--img style="width:600px" src="<?=FILES_PATH?>Teles_Comics.jpg" /-->
						<!--img style="width:600px" src="<?=FILES_PATH?>ituro2013c.jpg" /-->


					</center>

				</div>


		</div>
</div>
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

<!--<script>
  $( function() {
    $( "#dialog-message" ).dialog({
    	width: 1080, height: 720,
      modal: true,
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
        }
      }
    });
  } );
</script>

<style>
     blink, .blink {
        animation: blinker 2s linear infinite;
    }

   @keyframes blinker {
        50% { opacity: 0; }
   }
</style>

  <div id="dialog-message" title="TELESCOOP Shell Gas Card">

  <p>

     <center><img src="<?=IMAGE_PATH?>ads/free.gif " style="width:20%"></center><center><a href="http://www.telescoop.com.ph/assets/images/ads/Shell_ads.jpg" target="_blank"><blink><img src="<?=IMAGE_PATH?>ads/Shell_ads.jpg" style="width:50%"></blink></a></center><center><img src="<?=IMAGE_PATH?>ads/toolkit.gif" style="width:20%"></center>

  </p>
</div>-->
