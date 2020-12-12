<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= $this->title ?></title>
    <meta name="description" content="To give those who have lost someone for Coronavirus the opportunity to preserve their loved one's memory and tell stories by creating a free online memorial.">

    <meta name="google-signin-client_id" content="<?= GOOGLE_CLIENT_ID ?>">

    <!-- <link rel="manifest" href="site.webmanifest"> -->
    <link rel="shortcut icon" type="image/x-icon" href="<?= IMG_PATH ?>favicon.png">

    <!-- Twitter Graph -->
    <meta name="twitter:card" content="summary" />

    <!-- Facebook Graph -->
    <meta property="og:url"         content="<?= rtrim(HOST_NAME, '/') . CURRENT_URI ?>" />
    <meta property="og:type"        content="website" />
    <meta property="og:title"       content="<?= $this->title ?>" />
    <?php if ($this->og) : ?>
    <meta property="og:description" content="<?= $this->og['description'] ?>" />
    <meta property="og:image"       content="<?= $this->og['image'] ?>" />
    <?php endif; ?>
    <meta property="fb:app_id"      content="<?= FACEBOOK_APP_ID ?>" />


    <!-- CSS here -->
    <link rel="stylesheet" href="<?= CSS_PATH ?>bootstrap.min.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>owl.carousel.min.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>font-awesome.min.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>themify-icons.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>flaticon.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>animate.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>slick.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>slicknav.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>aos.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>jquery-ui.css">

    <link rel="stylesheet" href="<?= CSS_PATH ?>style.css">
    <link rel="stylesheet" href="<?= CSS_PATH ?>custom.css">


    <script src="<?= VENDOR_PATH ?>jquery-3.3.1.min.js"></script>

    <?php if ($this->controller !== 'login') : ?>
    <script async src="https://platform-api.sharethis.com/js/sharethis.js#property=5e9d4645208e6c0019b74e82&product=sticky-share-buttons"></script>
    <?php endif; ?>

    <script src="https://apis.google.com/js/platform.js?onload=onLoad" async defer></script>

    <!-- Facebook Pixel Code -->
    <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '242465573752646');
    fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=242465573752646&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel Code -->
</head>

<body>
    <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
    <![endif]-->

    <script>
        var auth2;
        function onLoad() {
            gapi.load('auth2', function() {
                auth2 = gapi.auth2.init();

                auth2.then(function() {
                    <?php if (!\Framework\lib\Session::Exists('loggedin')) : ?>
                    if (auth2.isSignedIn.get()) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', '<?= HOST_NAME ?>login/google_refresh_login');
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onload = function() {
                            console.log(xhr.responseText);
                            if (xhr.responseText !== '1') {
                                signOut();
                            }
                        };
                        xhr.send();
                    }
                    <?php endif; ?>
                });
            });
        }
        function signOut() {
            // var auth2 = gapi.auth2.getAuthInstance();
            auth2.signOut().then(function () {
                console.log('User signed out.');
            });
        }
    </script>


    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script>
        window.fbAsyncInit = function() {
            FB.init({
                xfbml            : true,
                version          : 'v6.0'
            });
        };

        (function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>

    <!-- Your customer chat code -->
    <div class="fb-customerchat" page_id="108676100820927"></div>


    <div id="overlayer"></div>
    <div class="loader">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
