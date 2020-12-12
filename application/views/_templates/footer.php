<a id="scrollUp"></a>

</main>

<footer class="footer">
    <div class="footer_top">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="footer_widget">
                        <div class="footer_logo">
                            <a href="#home-section">
                                <img src="<?= IMG_PATH ?>footer-logo.png" alt="">
                            </a>
                        </div>
                        <div class="socail_links">
                            <ul>
                                <li><a href="https://www.facebook.com/coronatribute"><i class="ti-facebook"></i></a></li>
                                <li><a href="#"><i class="ti-twitter-alt"></i></a></li>
                                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-2"></div>
                <div class="col-md-2">
                    <div class="footer_widget">
                        <ul class="links">
                            <li><a href="<?= HOST_NAME ?>index/privacy">Privacy Policy</a></li>
                            <li><a href="<?= HOST_NAME ?>index/terms">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="footer_widget">
                        <ul class="links">
                            <li><a href="<?= HOST_NAME ?>index/about">About us</a></li>
                            <li><a href="<?= HOST_NAME ?>index/contact"> Contact us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy-right_text">
        <div class="container">
            <div class="footer_border"></div>
            <div class="row">
                <div class="col-xl-12">
                    <p class="copy_right text-center">
                        Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>


<!-- Search Modal -->
<div class="modal fade custom_search_pop" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form method="post" action="<?= HOST_NAME ?>index/search">
                <div class="serch_form">
                    <input type="text" name="search" placeholder="Search">
                    <button type="submit">search</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Errors Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <!-- .modal-dialog -->
    <div class="modal-dialog modal-dialog-overflow" role="document">
        <!-- .modal-content -->
        <div class="modal-content">
            <!-- .modal-header -->
            <div class="modal-header">
                <h6 class="modal-title"> <span class="fa fa-remove"></span> <strong>Oh snap!</strong> </h6>
            </div>
            <!-- /.modal-header -->
            <!-- .modal-body -->
            <div class="modal-body px-0">
                <div class="col-md-12">
                    <div class="alert alert-danger errorModalMessage"></div>
                </div>
            </div>
            <!-- /.modal-body -->
            <!-- .modal-footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
            </div>
            <!-- /.modal-footer -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- JS here -->
<script src="<?= VENDOR_PATH ?>modernizr-3.5.0.min.js"></script>
<script src="<?= JS_PATH ?>popper.min.js"></script>
<script src="<?= JS_PATH ?>bootstrap.min.js"></script>
<script src="<?= JS_PATH ?>owl.carousel.min.js"></script>
<script src="<?= JS_PATH ?>jquery.easing.1.3.js"></script>
<script src="<?= JS_PATH ?>wow.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>

<script src="<?= JS_PATH ?>isotope.pkgd.min.js"></script>
<script src="<?= JS_PATH ?>imagesloaded.pkgd.min.js"></script>
<script src="<?= JS_PATH ?>scrollIt.js"></script>
<script src="<?= JS_PATH ?>jquery.scrollUp.min.js"></script>
<script src="<?= JS_PATH ?>jquery.slicknav.min.js"></script>
<script src="<?= JS_PATH ?>plugins.js"></script>
<script src="<?= JS_PATH ?>slick.min.js"></script>
<script src="<?= JS_PATH ?>aos.js"></script>

<script src="<?= JS_PATH ?>main.js"></script>

<?php if ($this->action == 'notfound') : ?>
<script>$("#sticky-header").addClass("sticky");</script>
<?php endif; ?>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-163136904-1"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-163136904-1');
</script>

</body>

</html>