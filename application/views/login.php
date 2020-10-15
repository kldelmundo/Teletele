<body>


<div id="body">

    <script>
    function mouseoverPass(obj) {
      var obj = document.getElementById('myPassword');
      obj.type = "text";
    }
    function mouseoutPass(obj) {
      var obj = document.getElementById('myPassword');
      obj.type = "password";
    }

    </script>
    <center>

    <div class="bodygradient">
    <div class="bodyminimum">


    <div id="login">

        <form name="form1" method="post" action="<?=site_url('account/login')?>" accept-charset="utf-8" autocomplete="off">

        <table class="logincontainer" id="login">

            <tr>
                <td class="Thead" colspan="3">PLEASE LOGIN</td>
            </tr> <input type='hidden' name='redirect_page' value=''/>

            <?if(isset($error)):?>

            <td colspan=2 align="center">
                <x style="color:red "><?=$error?></x>
            </td>

            <?endif;?>

            <tr>
                <td style="color:#7d9a6b; font-size: 15px; font-weight: 650;"> Username </td>
            </tr>

            <tr>
                <td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:320px" name="myusername" type="text" tabindex="1"/></td>
            </tr>

            <tr>
                <td style="color:#7d9a6b; font-size: 15px; font-weight: 650;">Password  </td>
            </tr>

            <tr>
                <td><input style="background-color:#f2d0aa; color:#5a5b5d; background-clip:border-box; padding:auto; height: 25px; width:295px" name="mypassword" id="myPassword" type="password" tabindex="1"/><img src="<?=IMAGE_PATH?>eyecon.png" onmouseover="mouseoverPass();" onmouseout="mouseoutPass();" width="20" draggable="false" /></td>
            </tr>


            <tr>
                <td style="padding: 25px 23px; "><center><input id="loginhover"  type="submit"  name="login" tabindex="3" value="  Login  "/></center></td>
            </tr>

            <tr>
                <td class="info">
                <p style="font-size:14px; color:#5a5b5d; font-style: italic; text-align: center; padding-top: 0; ">Not yet registered? <a href="https://www.telescoop.com.ph/account/request.aspx" id="clickhere"> Click here.</a></p>
                </td>
            </tr>

            <tr>
                <td class="info">
                <p style="font-size:14px; color:#5a5b5d; font-style: italic; text-align: center; padding-top: 0; ">Forgot your password? <a href="https://www.telescoop.com.ph/account/forgot_password.aspx" id="clickhere">Reset it.</a></p>
                </td>
            </tr>

            <tr><td></td></tr>

        </table>
        </form>

    </div>
</div>
</div>
</div>




</body>
