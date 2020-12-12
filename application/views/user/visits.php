<div class="popular_places_area">
    <div class="container">
        <div class="row">
            <?php if (isset($memorials) && $memorials !== false) : ?>
                <?php foreach ($memorials as $memorial) : ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="single_place">
                            <div class="thumb">
                                <?php if ($memorial->photo) : ?>
                                    <img src="<?= MEMORIAL_PHOTOS_PATH . $memorial->id . DS . $memorial->photo ?>" alt="">
                                <?php else : ?>
                                    <img src="<?= IMG_PATH ?>no-image.jpg" alt="">
                                <?php endif; ?>
                            </div>
                            <div class="place_info">
                                <a href="<?= HOST_NAME.'index/memorial/'.$memorial->webAddress ?>"><h3><?= $memorial->firstName.' '.$memorial->lastName ?></h3></a>
                                <?php $birth_year = isset($memorial->birthDate) && $memorial->birthDate ? date('Y', strtotime($memorial->birthDate)) : ''; ?>
                                <?php $passing_year = isset($memorial->passingDate) && $memorial->passingDate ? date('Y', strtotime($memorial->passingDate)) : ''; ?>
                                <?php $birth_passing_date = ($birth_year && $passing_year) ? ' ('.$birth_year.'-'.$passing_year.')' : ''; ?>
                                <p><?= $birth_passing_date ?></p>

                                <div class="rating_days d-flex justify-content-between">
                                    <span class="text-muted">(Visited <?= $memorial->visits ?> Time<?php echo $memorial->visits > 1 ? 's' : ''; ?>)</span>
                                    <div class="days">
                                        <i class="fa fa-clock-o"></i>
                                        <a href="#"><?= date('F d, Y', strtotime($memorial->created)) ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>