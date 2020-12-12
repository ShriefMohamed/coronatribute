<style>
    body {background-color: #000000;}
</style>
<?php if (isset($cases_updates) && $cases_updates !== null && is_array($cases_updates)) : ?>
<div class="cases-counter">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <div class="counter text-center">
                    <h1>Coronavirus Cases:</h1>
                    <span><?= $cases_updates[0] ?></span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="counter text-center text-justify">
                    <h1>Deaths:</h1>
                    <span><?= $cases_updates[1] ?></span>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="counter text-center text-justify">
                    <h1>Recovered:</h1>
                    <span><?= $cases_updates[2] ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="memorials_area" id="memorials_area">
    <div class="container-fluid">
        <section class="row align-items-stretch photos" id="section-photos">
            <div class="col-12">
                <div class="row align-items-stretch">

                    <?php if (isset($memorials) && $memorials !== false) : ?>
                        <?php $delay = 300; ?>
                        <?php foreach ($memorials as $memorial) : ?>

                                <?php $delay = ($delay + 100) == 400 ? 0 : $delay + 100; ?>
                                <div class="col-3 col-md-2 col-lg-2 memorial-item no-padding" data-aos="fade-up" <?php echo $delay !== 0 ? 'data-aos-delay="'.$delay.'"' : '' ?>>
                                    <a href="<?= HOST_NAME.'index/memorial/'.$memorial->webAddress ?>" class="d-block photo-item" data-fancybox="gallery">
                                        <?php if ($memorial->photo) : ?>
                                            <img src="<?= MEMORIAL_PHOTOS_PATH . $memorial->id . DS . $memorial->photo ?>" alt="<?= $memorial->firstName.' '.$memorial->lastName ?>" class="img-fluid">
                                        <?php else : ?>
                                            <img src="<?= IMG_PATH ?>placeholder.jpg" alt="<?= $memorial->firstName.' '.$memorial->lastName ?>" class="img-fluid">
                                        <?php endif; ?>

                                        <div class="content text-center align-items-center">
                                            <p><?= $memorial->firstName.' '.$memorial->lastName ?> </p>

                                            <?php $birth_year = isset($memorial->birthDate) && $memorial->birthDate ? date('Y', strtotime($memorial->birthDate)) : ''; ?>
                                            <?php $passing_year = isset($memorial->passingDate) && $memorial->passingDate ? date('Y', strtotime($memorial->passingDate)) : ''; ?>
                                            <?php $birth_passing_date = ($birth_year && $passing_year) ? ' ('.$birth_year.'-'.$passing_year.')' : ''; ?>
                                            <p><?= $birth_passing_date ?></p>
                                        </div>
                                        <div class="photo-text-more">
                                            <span class="fa fa-eye"></span>
                                        </div>
                                    </a>
                                </div>

                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            </div>
        </section>
    </div>
</div>


<?php if (isset($tributes) && $tributes !== false) : ?>
<div class="testimonial_area">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">
                <h2 class="heading text-uppercase text-white">Latest Tributes</h2>
                <div class="testmonial_active owl-carousel">
                    <?php foreach ($tributes as $tribute) : ?>
                    <div class="single_carousel">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="single_testmonial text-center">
                                    <?php if ($tribute->image) : ?>
                                    <div class="author_thumb">
                                        <img src="<?php echo $tribute->imageType == 1 ? IMG_PATH.'users/'.$tribute->image : $tribute->image ?>" alt="">
                                    </div>
                                    <?php endif; ?>

                                    <p><?= $tribute->tribute ?></p>
                                    <div class="testmonial_author">
                                        <h3>- <?= $tribute->firstName.' '.$tribute->lastName ?></h3>
                                    </div>
                                    <div class="testmonial_webaddress">
                                        <a href="<?= \Framework\lib\Helper::MemorialWebAddress($tribute->webAddress) ?>"><?= $tribute->webAddress . HOST ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
