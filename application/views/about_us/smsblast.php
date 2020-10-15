<!-- MADE TO COMPENSATE THE PROFILE FOR BLISS PROJECT -->
<script src="https://code.jquery.com/jquery-1.5.js"></script>
<script>
      function countChar(val) {
        var len = val.value.length;
        if (len >= 160) {
          val.value = val.value.substring(0, 160);
        } else {
          $('#charNum').text(160 - len);
        }
      };
</script>
<body>

<div id="body">
	<div class="bodygradient">
		<div class="bodyminimum">

			<div style="height: 50px; position: relative; width: 100%; top:40px; font-family: Akrobat; font-size: 18px; color:white; text-align: center; padding: 5px;">
			<h1>  </h1>
			</div>

			<div id="notify" style="margin: 50px 250px; background-color: white; padding: 40px 50px; font-size: 18px; text-align: left;">
        <form name="smsblast" method="post" action="<?=site_url('about_us/send_smsblaster')?>" accept-charset="utf-8" autocomplete="off">
          <table>
            <center>
            <tr>
                <td><textarea name="txt_message" onkeyup="countChar(this)" id="txt_message" rows="6" cols="40" style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 200px; width:320px"> </textarea></td>
            </tr>
            <tr><td><h1 id="charNum"></h1></td></tr>
            <tr>

              	<!-- <td><input type="submit" id="loginhover" name="sms_send" value="  Send  " disabled /></td> -->
            </tr>
            </center>
          </table>

        </form>
			</div>
		</div>
	</div>
</div>
</body>
