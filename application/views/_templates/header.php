<!-- header-start -->
<header>
    <div class="header-area ">
        <div id="sticky-header" class="main-header-area">
            <div class="container-fluid">
                <div class="header_bottom_border">
                    <div class="row align-items-center">
                        <div class="col-xl-2 col-lg-2">
                            <div class="logo">
                                <a href="<?= HOST_NAME ?>">
                                    <img src="<?= IMG_PATH ?>logo.png" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="main-menu  d-none d-lg-block">
                                <nav>
                                    <ul id="navigation">
                                        <li><a class="active" href="#home-section">Home</a></li>
                                        <li><a href="#memorials_area">Memorials</a></li>
                                        <li><a href="<?= HOST_NAME ?>index/create_memorial">Create Memorial</a></li>
                                        <li><a href="<?= HOST_NAME ?>index/about">About</a></li>
                                        <li><a href="<?= HOST_NAME ?>index/contact">Contact</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 d-none d-lg-block">
                            <div class="social_wrap d-flex align-items-center justify-content-end">
                                <?php if (\Framework\lib\Session::Exists('loggedin')) : ?>
                                <div class="main-menu">
                                    <ul>
                                        <li id="loggedin-menu" class="dropdown">
                                            <a href="" class="dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false"><?= \Framework\lib\Session::Get('loggedin')->firstName ?> </a>
                                            <ul class="dropdown-menu submenu" aria-labelledby="dropdownMenuButton">
                                                <li class="dropdown-item"><a href="<?= HOST_NAME ?>user/memorials">My Memorials</a></li>
                                                <li class="dropdown-item"><a href="<?= HOST_NAME ?>user/visits">Visited Memorials</a></li>
                                                <li class="dropdown-item"><a href="<?= HOST_NAME ?>user/signout" onclick="return signOut();">Sign Out</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                                <?php else : ?>
                                    <div class="number">
                                        <a href="<?= HOST_NAME ?>login" class="genric-btn danger radius">Login</a>
                                    </div>
                                <?php endif; ?>

                                <div class="social_links d-none d-xl-block">
                                    <ul>
                                        <li><a href="https://www.facebook.com/coronatribute"> <i class="fa fa-facebook"></i> </a></li>
                                        <li><a href="#"> <i class="fa fa-twitter"></i> </a></li>
                                        <li><a href="#"> <i class="fa fa-google-plus"></i> </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="seach_icon">
                            <a data-toggle="modal" data-target="#exampleModalCenter" href="#">
                                <i class="fa fa-search"></i>
                            </a>
                        </div>
                        <div class="col-12">
                            <div class="mobile_menu d-block d-lg-none"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
<!-- header-end -->
<?php if ($this->controller == 'index' && $this->action == 'default') : ?>
<style>
    /*header {position: relative !important;}*/
    /*#sticky-header {position: fixed;width: 100%;top: 0;left: 0;right: 0;z-index: 990;padding: 10px 10px;*/
    /*    box-shadow: 0px 3px 16px 0px rgba(0, 0, 0, 0.1);background: rgba(255, 255, 255, 0.96); transform: none}*/

    header {position: absolute; width: 100%;z-index: 99}
    .header-area .main-header-area {background: rgba(255, 255, 255, 0.2)}
    .header-area .main-header-area .main-menu ul li a {color: #FFF}
    .header-area .main-header-area.sticky .main-menu ul li a {color: #040E27}
</style>
<script>
    $(window).on('scroll', function () {
        var scroll = $(window).scrollTop();
        if (scroll < 300) {
            $('.logo > a').html("<img src='<?= IMG_PATH ?>footer-logo.png'>")
        } else {
            $('.logo > a').html("<img src='<?= IMG_PATH ?>logo.png'>")
        }
    });
</script>
<?php endif; ?>

<main class="main-content">