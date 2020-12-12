<div class="login-tbl container">
    <div class="log-container" id="login-register-container">
        <div class="row">
            <div class="login col-11 col-md-6">
                <div class="social-media-login">
                    <a class="facebook-login-button" href="<?= HOST_NAME ?>login/facebook">Continue with Facebook</a>
                    <div class="g-signin2" data-longtitle="true" data-theme="dark" data-onsuccess="onSignIn" onclick="clicked = true"></div>
                </div>
                <div class="row ">
                    <div class="col-md-12">
                        <span id="or">OR</span>
                    </div>
                </div>

                <form id="login-form" class="form" method="post">
                    <div class="mb-4">
                        <p>Don't have an account? <a href="#" id="to-register">Create one</a></p>
                    </div>
                    <div class="form-group" style="margin-bottom: 0">
                        <label for="login-username">Username / Email</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="username" type="text">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="input-icon">
                            <i class="fa fa-lock"></i>
                            <input class="form-control form-soft input-sm" type="password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="login-btn" name="login" class="genric-btn danger radius btn-block">Login&nbsp;&nbsp;&nbsp;<i class="fa fa-play"></i></button>
                    </div>
                </form>

                <form id="register-form" class="form hidden" method="post">
                    <div class="mb-4">
                        <p>Already have an account? <a href="#" id="to-login">Sign In</a></p>
                    </div>

                    <div class="form-group" style="margin-bottom: 0">
                        <label for="login-fname">First Name</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="register-firstName" id="login-fname" type="text">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0">
                        <label for="login-lname">Last Name</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="register-lastName" id="login-lname" type="text">
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 0">
                        <label for="login-username">Username</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="register-username" id="login-username" type="text">
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom: 0">
                        <label for="login-email">Email</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="register-email" id="login-email" type="email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Password</label>
                        <div class="input-icon">
                            <i class="fa fa-lock"></i>
                            <input class="form-control form-soft input-sm" type="password" name="register-password">
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" id="login-btn" name="register" class="genric-btn danger radius btn-block">Register&nbsp;&nbsp;&nbsp;<i class="fa fa-play"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-11 col-md-6 login-footer">
                <a href="#" class="btn btn-warning" id="to-forgot" style="float:left;"><i class="fa fa-question"></i>&nbsp;&nbsp;&nbsp;Forgot Password</a>
            </div>
        </div>
    </div>

    <div class="log-container hidden" id="forgot-container">
        <div class="row">
            <div class="login col-11 col-md-6">
                <form id="forgot-form" class="form" method="post">
                    <div class="mb-4">
                        <p>ُEnter your email address and we will send you an email with the instructions to reset your password.</p>
                    </div>
                    <div class="form-group">
                        <label for="forget-email">Email</label>
                        <div class="input-icon">
                            <i class="fa fa-user"></i>
                            <input class="form-control form-soft input-sm" name="forget-email" type="email">
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="submit" id="login-btn" name="forgot" class="btn btn-primary btn-block">SEND RESET EMAIL&nbsp;&nbsp;&nbsp;<i class="fa fa-play"></i></button>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-11 col-md-6 login-footer">
                <a href="#" class="btn btn-warning" id="to-login-register" style="float:left;"><i class="fa fa-question"></i>&nbsp;&nbsp;&nbsp;Return to Login</a>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        background: url("<?= IMG_PATH ?>bg1.jpg") no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
    }
    .footer {display: none; visibility: hidden}

    .g-signin2 {float: right;}
</style>

<script>
    var clicked = false;
    function onSignIn(googleUser) {
        if (clicked) {
            var id_token = googleUser.getAuthResponse().id_token;

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '<?= HOST_NAME ?>login/google_login');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.responseText === '1') {
                    window.open("<?= HOST_NAME ?>", '_self');
                } else {
                    $('.errorModalMessage').html(xhr.responseText);
                    $('#errorModal').modal();
                }
            };
            xhr.send('idtoken=' + id_token);
        }
    }

    $(document).ready(function () {
        <?php if (\Framework\lib\Session::Exists('login-message')) : ?>
        displayError("<?= \Framework\lib\Session::Get('login-message') ?>");
        <?php \Framework\lib\Session::Remove('login-message'); ?>
        <?php endif; ?>
    });
</script>
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '256455915389785',
            cookie     : true,
            xfbml      : true,
            version    : 'v6.0'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

    function checkLoginState() {
        FB.getLoginStatus(function(response) {
            statusChangeCallback(response);
        });
    }
</script>