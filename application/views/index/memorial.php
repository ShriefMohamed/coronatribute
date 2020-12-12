<?php use Framework\lib\Session;

if (isset($memorial) && $memorial !== false) : ?>
 <div class="container">
    <?php if (isset($photos) && $photos !== false) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="memorial-slider">
                <div class="owl-carousel memorial-slider-active">
                    <?php foreach ($photos as $photo) : ?>
                    <div class="single_slider">
                        <img src="<?= MEMORIAL_PHOTOS_PATH . $memorial->id . DS . $photo->name ?>" alt="<?= $photo->name ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-12">
            <div class="align-items-center memorial-slider-text">
                <div class="text-center">
                    <h3><?= $memorial->firstName.' '.$memorial->lastName ?></h3>
                    <h4 class="text-muted"><?php echo (isset($birth_passing_date) && $birth_passing_date) ? $birth_passing_date : '' ?></h4>
                </div>
            </div>
        </div>
    </div>

     <div class="row">
         <div class="col-md-12">
             <nav class="page-navs">
                 <div class="nav-scroller">
                     <div class="nav nav-center nav-tabs">
                         <a class="active nav-link" href="#memorial-about" data-toggle="tab">About</a>
                         <a class="nav-link" href="#memorial-biography" data-toggle="tab">Biography</a>
                         <a class="nav-link" href="#memorial-gallery" data-toggle="tab">Gallery <span class="badge"><?php echo isset($photos) && $photos != false ? count($photos) : '';  ?></span></a>
                         <a class="nav-link" href="#memorial-tributes" data-toggle="tab">Tributes <span class="badge"><?php echo isset($tributes) && $tributes != false ? count($tributes) : '';  ?></span></a>
                     </div>
                 </div>
             </nav>

             <div class="page-inner">
                 <div class="row">
                     <div class="col-md-12" id="errors-div" style="margin-top: 2rem;"></div>
                     <div class="col-md-9">
                         <div class="tab-content tab-tabs mt-4 mb-5">
                             <div class="tab-pane active" id="memorial-about">
                                 <?php if (Session::Exists('loggedin') && $memorial->createdBy == Session::Get('loggedin')->id) : ?>
                                     <div style="padding-bottom: 25px;">
                                         <a class="add-item position-absolute edit-memorial-about" style="right: 25px" href="#"><i class="fa fa-edit"></i> Edit</a>
                                         <a class="add-item position-absolute delete-memorial" style="right: 0;transform: translateX(-145%);" href="#" data-toggle="modal" data-target="#auth-modal"><i class="fa fa-trash"></i> Delete</a>
                                     </div>
                                 <?php endif; ?>

                                 <blockquote class="text-center mb-3">
                                     <div class="epithet">
                                         <i class="fa fa-quote-left"></i>
                                         <span><?= $memorial->epithet ?></span>
                                         <i class="fa fa-quote-right"></i>
                                     </div>
                                 </blockquote>
                                 <div class="mb-5">
                                     <ul class="unordered-list">
                                         <?php if (isset($age) && $age !== false) : ?>
                                         <li><?= $age ?> years old.</li>
                                         <?php endif; ?>

                                         <?php if (isset($memorial->birthDate)) : ?>
                                         <li>Born on <?= date('F d, Y', strtotime($memorial->birthDate)) ?>
                                         <?php echo $memorial->birthState && $memorial->birthCountry ? 'in '.$memorial->birthState.', '.$memorial->birthCountry : '' ?>.</li>
                                         <?php endif; ?>

                                         <?php if (isset($memorial->passingDate)) : ?>
                                             <li>Passed away on <?= date('F d, Y', strtotime($memorial->passingDate)) ?>
                                                 <?php echo $memorial->passingState && $memorial->passingCountry ? 'in '.$memorial->passingState.', '.$memorial->passingCountry : '' ?>.</li>
                                         <?php endif; ?>
                                     </ul>
                                 </div>
                                 <div class="">
                                     <?php $gender0 = ''; $gender1 = ''; ?>
                                     <?php if (isset($memorial->gender) && $memorial->gender) : ?>
                                         <?php $gender0 = $memorial->gender == 'female' ? 'her' : 'him' ?>
                                         <?php $gender1 = $memorial->gender == 'female' ? 'her' : 'his' ?>
                                     <?php else : ?>
                                         <?php $gender0 = 'him' ?>
                                         <?php $gender1 = 'his' ?>
                                     <?php endif; ?>

                                     <p>This memorial was created in the honor of COVID-19 pandemic victim
                                         <strong><?= $memorial->firstName.' '.$memorial->lastName ?></strong>, to remember <?= $gender0 ?> forever and share <?= $gender1 ?> story,
                                         because, like all of the pandemic's victims, They're not just numbers nor statistics, each one has a story.</p>
                                 </div>
                             </div>

                             <div class="tab-pane" id="memorial-biography">
                                 <a class="mb-3 add-item smoothscroll-link" href="#biography-form"><i class="fa fa-edit"></i> Add a Story</a>

                                 <div id="memorial-biography-area">
                                     <?php if (isset($memorial_stories) && $memorial_stories) : ?>
                                         <?php foreach ($memorial_stories as $memorial_story) : ?>
                                             <article class="blog_item mb-3" id="memorial-biography-item-<?= $memorial_story->id ?>">
                                                 <div class="blog_details">
                                                     <div class="memorial-biography-content">
                                                         <?= html_entity_decode($memorial_story->story) ?>
                                                     </div>
                                                     <ul class="blog-info-link">
                                                         <?php if (Session::Exists('loggedin')) : ?>
                                                             <?php if (Session::Get('loggedin')->id == $memorial_story->createdBy) : ?>
                                                             <li><a href="#" class="edit-item" data-item-id="<?= $memorial_story->id ?>"><i class="fa fa-edit"></i> Edit</a></li>
                                                             <li><a href="#" class="delete-item" data-item-type="biography" data-item-id="<?= $memorial_story->id ?>"><i class="fa fa-trash"></i> Delete</a></li>
                                                             <?php elseif (Session::Get('loggedin')->id == $memorial->createdBy) : ?>
                                                             <li><a href="#" class="delete-item" data-item-type="biography" data-item-id="<?= $memorial_story->id ?>"><i class="fa fa-trash"></i> Delete</a></li>
                                                             <?php endif; ?>
                                                         <?php endif; ?>
                                                         <li class="pull-right-btn"><a class="" href="#"><i class="fa fa-share"></i> Share <i class="fa fa-caret-down"></i></a></li>
                                                     </ul>
                                                 </div>
                                             </article>
                                         <?php endforeach; ?>
                                     <?php endif; ?>
                                 </div>

                                 <?php if (Session::Exists('loggedin')) : ?>
                                     <article class="blog_item mb-3">
                                         <div class="blog_details">
                                             <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add a life story chapter</span>
                                             <form method="post" id="biography-form">
                                                 <textarea class="summernote" name="biography"></textarea>
                                                 <title>By <?= \Framework\lib\Session::Get('loggedin')->firstName ?></title>

                                                 <div class="blog-info-link mt-2">
                                                     <input class="genric-btn info radius" type="submit" value="Save">
                                                 </div>
                                             </form>
                                         </div>
                                     </article>
                                 <?php else : ?>
                                     <article class="blog_item mb-3">
                                         <div class="blog_details" id="biography-form">
                                             <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add a life story chapter</span>
                                             <p>Please login to add your stories with <strong><?= $memorial->firstName ?></strong></p>
                                         </div>
                                     </article>
                                 <?php endif; ?>
                             </div>

                             <div class="tab-pane " id="memorial-gallery">
                                 <a class="mb-3 add-item smoothscroll-link" href="#gallery_form"><i class="fa fa-edit"></i> Add a Photo</a>

                                 <!-- Root element of PhotoSwipe. Must have class pswp. -->
                                 <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

                                     <!-- Background of PhotoSwipe.
                                          It's a separate element as animating opacity is faster than rgba(). -->
                                     <div class="pswp__bg"></div>

                                     <!-- Slides wrapper with overflow:hidden. -->
                                     <div class="pswp__scroll-wrap">

                                         <!-- Container that holds slides.
                                             PhotoSwipe keeps only 3 of them in the DOM to save memory.
                                             Don't modify these 3 pswp__item elements, data is added later on. -->
                                         <div class="pswp__container">
                                             <div class="pswp__item"></div>
                                             <div class="pswp__item"></div>
                                             <div class="pswp__item"></div>
                                         </div>

                                         <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
                                         <div class="pswp__ui pswp__ui--hidden">

                                             <div class="pswp__top-bar">

                                                 <!--  Controls are self-explanatory. Order can be changed. -->

                                                 <div class="pswp__counter"></div>

                                                 <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

                                                 <button class="pswp__button pswp__button--share" title="Share"></button>

                                                 <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

                                                 <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

                                                 <!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
                                                 <!-- element will get class pswp__preloader--active when preloader is running -->
                                                 <div class="pswp__preloader">
                                                     <div class="pswp__preloader__icn">
                                                         <div class="pswp__preloader__cut">
                                                             <div class="pswp__preloader__donut"></div>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div>

                                             <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                                                 <div class="pswp__share-tooltip"></div>
                                             </div>

                                             <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
                                             </button>

                                             <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
                                             </button>

                                             <div class="pswp__caption">
                                                 <div class="pswp__caption__center"></div>
                                             </div>

                                         </div>

                                     </div>

                                 </div>

                                 <?php if (isset($photos) && $photos !== false) : ?>
                                 <div class="memorials_gallery mb-4">
                                     <div class="row memorials_gallery-row">
                                         <?php foreach ($photos as $photo) : ?>
                                         <figure class="col-md-4" id="memorial-gallery-item-<?= $photo->id ?>">
                                             <div class="single_memorial">
                                                <div class="top-actions-wrapper">
                                                    <div class="actions">
                                                        <?php if (Session::Exists('loggedin')) : ?>
                                                            <?php if (Session::Get('loggedin')->id == $memorial->createdBy) : ?>
                                                                <a href="#" onclick="event.stopPropagation();" title="Delete" class="delete-item" data-item-type="gallery" data-item-id="<?= $photo->id ?>"><i class="fa fa-trash-o"></i></a>
                                                                <a href="#" onclick="event.stopPropagation();" title="Feature photo on homepage" class="feature-photo" data-item-id="<?= $photo->id ?>" data-featured="<?= $photo->feature ?>"><i class="fa fa-star<?php echo $photo->feature !== '1' ? '-o' : '' ?>"></i></a>
                                                            <?php elseif (Session::Get('loggedin')->id == $photo->createdBy) : ?>
                                                                <a href="#" onclick="event.stopPropagation();" title="Delete" class="delete-item" data-item-type="gallery" data-item-id="<?= $photo->id ?>"><i class="fa fa-trash-o"></i></a>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>

                                                <a class="thumb" href="<?= MEMORIAL_PHOTOS_PATH . $memorial->id . DS . $photo->name ?>" itemprop="contentUrl" data-size="600x400">
                                                    <img itemprop="thumbnail" src="<?= MEMORIAL_PHOTOS_PATH . $memorial->id . DS . $photo->name ?>" alt="<?= $photo->name ?>">
                                                </a>
                                                <div class="content">
                                                    <p class="d-flex" itemprop="caption description">By <a href="#">  <?= $photo->firstName.' '.$photo->lastName ?></a> </p>
                                                </div>
                                             </div>
                                         </figure>
                                         <?php endforeach; ?>
                                     </div>
                                 </div>
                                 <?php endif; ?>

                                 <?php if (Session::Exists('loggedin')) : ?>
                                     <article class="blog_item mb-3">
                                         <div class="blog_details">
                                             <main>
                                                 <section id="gallery_form">
                                                     <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add Photos of <?= $memorial->firstName ?></span>

                                                     <div class="file-loading">
    <!--                                                     <form action="" class=" dz-clickable mb-2" id="gallery_form" method="post" enctype="multipart/form-data">-->
                                                            <!-- <div class="dz-message">Drop files here or click to upload.</div>-->
    <!--                                                         <input id="" name="photos[]" type="file" class="file" multiple data-show-caption="true" data-msg-placeholder="Select {files} for upload..." data-browse-on-zone-click="true" accept="image/*">-->
    <!--                                                     </form>-->

                                                         <input id="gallery-form-input" name="photos[]" type="file" accept="image/*" data-msg-placeholder="Select {files} for upload..." data-browse-on-zone-click="true" multiple>
                                                     </div>
                                                     <label><?php echo Session::Exists('loggedin') ? 'By: '. Session::Get('loggedin')->firstName : ''; ?></label>
                                                 </section>
                                             </main>
                                         </div>
                                     </article>
                                 <?php else : ?>
                                     <article class="blog_item mb-3">
                                         <div class="blog_details" id="gallery_form">
                                             <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add Photos of <?= $memorial->firstName ?></span>
                                             <p>Please login to add photos</p>
                                         </div>
                                     </article>
                                 <?php endif; ?>
                             </div>

                             <div class="tab-pane " id="memorial-tributes">
                                 <a class="mb-3 add-item smoothscroll-link" href="#tribute-form"><i class="fa fa-edit"></i> Add a Tribute</a>

                                 <div id="memorial-tributes-area">
                                     <?php if (isset($tributes) && $tributes) : ?>
                                         <?php foreach ($tributes as $tribute) : ?>
                                             <article class="blog_item mb-3" id="memorial-tribute-item-<?= $tribute->id ?>">
                                                 <div class="blog_details">
                                                     <p><?= $tribute->tribute ?></p>
                                                     <ul class="blog-info-link">
                                                         <li><a href="#"><i class="fa fa-user"></i> <?= $tribute->firstName.' '.$tribute->lastName ?></a></li>
                                                         <li><a href="#"><i class="fa fa-clock-o"></i> <?= date('F d, Y', strtotime($tribute->created)) ?> </a></li>

                                                         <li class="pull-right-btn"><a class="" href="#"><i class="fa fa-share"></i> Share <i class="fa fa-caret-down"></i></a></li>
                                                         <?php if (Session::Exists('loggedin')) : ?>
                                                             <?php if (Session::Get('loggedin')->id == $tribute->createdBy || Session::Get('loggedin')->id == $memorial->createdBy) : ?>
                                                             <li class="pull-right-btn"><a href="#" class="delete-item" data-item-type="tribute" data-item-id="<?= $tribute->id ?>"><i class="fa fa-trash"></i> Delete</a></li>
                                                             <?php endif; ?>
                                                         <?php endif; ?>
                                                     </ul>
                                                 </div>
                                             </article>
                                         <?php endforeach; ?>
                                     <?php endif; ?>
                                 </div>

                                 <?php if (Session::Exists('loggedin')) : ?>
                                 <article class="blog_item mb-3">
                                     <div class="blog_details">
                                         <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add a Tribute</span>
                                         <form method="post" id="tribute-form">
                                             <div class="form-group">
                                                 <textarea class="single-textarea tribute-textarea" name="tribute" placeholder="Your tribute"></textarea>
                                             </div>
                                             <title>By <?= Session::Get('loggedin')->firstName ?></title>

                                             <div class="blog-info-link mt-2">
                                                 <input class="genric-btn info radius" type="submit" value="Save">
                                             </div>
                                         </form>
                                     </div>
                                 </article>
                                 <?php else : ?>
                                     <article class="blog_item mb-3">
                                         <div class="blog_details" id="tribute-form">
                                             <span class="add-item-title mb-3"><i class="fa fa-edit"></i> Add a Tribute</span>
                                             <p>Please login to add a tribute</p>
                                         </div>
                                     </article>
                                 <?php endif; ?>
                             </div>
                         </div>
                         <div class="separator"></div>
                     </div>
                     <div class="col-md-3 pt-4">
                         <div class="right-block text-center">
                             <div class="fb-share-button" data-href="<?= HOST_NAME.'index/memorial/'.$memorial->webAddress ?>" data-layout="button" data-size="large">
                                 <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(HOST_NAME.'index/memorial/'.$memorial->webAddress) ?>&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
                             </div>
                         </div>
                         <div class="right-block">
                             <p>This memorial was created & managed by <?= $memorial->firstName.'\'s '.$memorial->relationship ?>: <a href="#"><?= $memorial->author_firstName.' '.$memorial->author_lastName ?></a></p>
                         </div>
                         <div class="right-block">
                             <div class="counter text-center">
                                 <span><?= $memorial->views ?> Views</span>
                             </div>
                         </div>

                     </div>
                 </div>

                 <?php if (Session::Exists('loggedin')) : ?>
                 <div class="modal fade" id="edit-biography-modal" tabindex="-1" role="dialog" aria-hidden="true">
                     <!-- .modal-dialog -->
                     <div class="modal-dialog modal-dialog-overflow mt-5" role="document" style="max-width: 70%">
                         <!-- .modal-content -->
                         <div class="modal-content">
                             <!-- .modal-header -->
                             <div class="modal-header modal-primary">
                                 <h6 class="modal-title"> Update Biography </h6>
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-weight:500">×</button>
                             </div>
                             <!-- /.modal-header -->
                             <form method="post" id="edit-biography-form">
                                 <!-- .modal-body -->
                                 <div class="modal-body">
                                     <article class="blog_item mb-3">
                                         <div class="" style="margin: 0 15px;">
                                             <span class="add-item-title"><i class="fa fa-edit"></i> Update story chapter</span>

                                             <input type="hidden" name="story-id" value="" id="story-id">
                                             <textarea class="summernote" name="biography"></textarea>
                                             <title>By <?= \Framework\lib\Session::Get('loggedin')->firstName ?></title>
                                         </div>
                                     </article>
                                 </div>
                                 <!-- /.modal-body -->
                                 <!-- .modal-footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="genric-btn dark" data-dismiss="modal">Close</button>
                                     <button type="submit" class="genric-btn info">Save changes</button>
                                 </div>
                                 <!-- /.modal-footer -->
                             </form>
                         </div>
                         <!-- /.modal-content -->
                     </div>
                     <!-- /.modal-dialog -->
                 </div>

                 <?php if ($memorial->createdBy == Session::Get('loggedin')->id) : ?>
                 <div class="modal fade" id="edit-memorial-about-modal" tabindex="-1" role="dialog" aria-hidden="true">
                     <!-- .modal-dialog -->
                     <div class="modal-dialog modal-dialog-overflow mt-5" role="document" style="max-width: 70%">
                         <!-- .modal-content -->
                         <div class="modal-content">
                             <!-- .modal-header -->
                             <div class="modal-header modal-primary">
                                 <h6 class="modal-title"> Update Memorial Details </h6>
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-weight:500">×</button>
                             </div>
                             <!-- /.modal-header -->
                             <form method="post" id="edit-memorial-about-form">
                                 <!-- .modal-body -->
                                 <div class="modal-body custom-memorial-form">
                                     <div class="col-md-12 mb-4">
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label for="firstName">First Name</label>
                                                     <input type="text" id="firstName" name="firstName" class="form-control" value="<?= $memorial->firstName ?>">
                                                 </div>
                                             </div>

                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label for="lastName">Last Name</label>
                                                     <input type="text" id="lastName" name="lastName" class="form-control" value="<?= $memorial->lastName ?>">
                                                 </div>
                                             </div>

                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <label for="nickname">Nickname</label>
                                                     <input type="text" id="nickname" name="nickname" class="form-control" value="<?= $memorial->nickName ?>">
                                                 </div>
                                             </div>
                                         </div>
                                    </div>

                                     <div class="col-md-12 mb-5">
                                         <div class="row">
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <select id="relationship" name="relationship" class="form-control form-select">
                                                         <option selected disabled>Please Select Relationship*</option>
                                                         <option value="Aunt">Aunt</option>
                                                         <option value="Boyfriend">Boyfriend</option>
                                                         <option value="Brother">Brother</option>
                                                         <option value="Colleague">Colleague</option>
                                                         <option value="Cousin">Cousin</option>
                                                         <option value="Daughter">Daughter</option>
                                                         <option value="Father">Father</option>
                                                         <option value="Friend">Friend</option>
                                                         <option value="Girlfriend">Girlfriend</option>
                                                         <option value="Granddaughter">Granddaughter</option>
                                                         <option value="Grandfather">Grandfather</option>
                                                         <option value="Grandmother">Grandmother</option>
                                                         <option value="Grandson">Grandson</option>
                                                         <option value="Husband">Husband</option>
                                                         <option value="Mother">Mother</option>
                                                         <option value="Nephew">Nephew</option>
                                                         <option value="Niece">Niece</option>
                                                         <option value="Sister">Sister</option>
                                                         <option value="Son">Son</option>
                                                         <option value="Step Family">Step Family</option>
                                                         <option value="Uncle">Uncle</option>
                                                         <option value="Wife">Wife</option>
                                                         <option value="Other">Other</option>
                                                         <option value="No relationship">No relationship</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <input type="text" class="form-control hidden" id="relationship-other" name="relationship-other">
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-md-12 mb-4">
                                         <h6>Birth Details: </h6>
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <input type="text" name="birthdate" id="birthdate" class="form-control" autocomplete="off">
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <select class="form-control form-select" id="birth-country" name="birth-country" style="margin-top: -2px;">
                                                         <option selected disabled>Please Select Country</option>
                                                         <option value="Afganistan">Afghanistan</option>
                                                         <option value="Albania">Albania</option>
                                                         <option value="Algeria">Algeria</option>
                                                         <option value="American Samoa">American Samoa</option>
                                                         <option value="Andorra">Andorra</option>
                                                         <option value="Angola">Angola</option>
                                                         <option value="Anguilla">Anguilla</option>
                                                         <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                         <option value="Argentina">Argentina</option>
                                                         <option value="Armenia">Armenia</option>
                                                         <option value="Aruba">Aruba</option>
                                                         <option value="Australia">Australia</option>
                                                         <option value="Austria">Austria</option>
                                                         <option value="Azerbaijan">Azerbaijan</option>
                                                         <option value="Bahamas">Bahamas</option>
                                                         <option value="Bahrain">Bahrain</option>
                                                         <option value="Bangladesh">Bangladesh</option>
                                                         <option value="Barbados">Barbados</option>
                                                         <option value="Belarus">Belarus</option>
                                                         <option value="Belgium">Belgium</option>
                                                         <option value="Belize">Belize</option>
                                                         <option value="Benin">Benin</option>
                                                         <option value="Bermuda">Bermuda</option>
                                                         <option value="Bhutan">Bhutan</option>
                                                         <option value="Bolivia">Bolivia</option>
                                                         <option value="Bonaire">Bonaire</option>
                                                         <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                         <option value="Botswana">Botswana</option>
                                                         <option value="Brazil">Brazil</option>
                                                         <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                         <option value="Brunei">Brunei</option>
                                                         <option value="Bulgaria">Bulgaria</option>
                                                         <option value="Burkina Faso">Burkina Faso</option>
                                                         <option value="Burundi">Burundi</option>
                                                         <option value="Cambodia">Cambodia</option>
                                                         <option value="Cameroon">Cameroon</option>
                                                         <option value="Canada">Canada</option>
                                                         <option value="Canary Islands">Canary Islands</option>
                                                         <option value="Cape Verde">Cape Verde</option>
                                                         <option value="Cayman Islands">Cayman Islands</option>
                                                         <option value="Central African Republic">Central African Republic</option>
                                                         <option value="Chad">Chad</option>
                                                         <option value="Channel Islands">Channel Islands</option>
                                                         <option value="Chile">Chile</option>
                                                         <option value="China">China</option>
                                                         <option value="Christmas Island">Christmas Island</option>
                                                         <option value="Cocos Island">Cocos Island</option>
                                                         <option value="Colombia">Colombia</option>
                                                         <option value="Comoros">Comoros</option>
                                                         <option value="Congo">Congo</option>
                                                         <option value="Cook Islands">Cook Islands</option>
                                                         <option value="Costa Rica">Costa Rica</option>
                                                         <option value="Cote DIvoire">Cote DIvoire</option>
                                                         <option value="Croatia">Croatia</option>
                                                         <option value="Cuba">Cuba</option>
                                                         <option value="Curaco">Curacao</option>
                                                         <option value="Cyprus">Cyprus</option>
                                                         <option value="Czech Republic">Czech Republic</option>
                                                         <option value="Denmark">Denmark</option>
                                                         <option value="Djibouti">Djibouti</option>
                                                         <option value="Dominica">Dominica</option>
                                                         <option value="Dominican Republic">Dominican Republic</option>
                                                         <option value="East Timor">East Timor</option>
                                                         <option value="Ecuador">Ecuador</option>
                                                         <option value="Egypt">Egypt</option>
                                                         <option value="El Salvador">El Salvador</option>
                                                         <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                         <option value="Eritrea">Eritrea</option>
                                                         <option value="Estonia">Estonia</option>
                                                         <option value="Ethiopia">Ethiopia</option>
                                                         <option value="Falkland Islands">Falkland Islands</option>
                                                         <option value="Faroe Islands">Faroe Islands</option>
                                                         <option value="Fiji">Fiji</option>
                                                         <option value="Finland">Finland</option>
                                                         <option value="France">France</option>
                                                         <option value="French Guiana">French Guiana</option>
                                                         <option value="French Polynesia">French Polynesia</option>
                                                         <option value="French Southern Ter">French Southern Ter</option>
                                                         <option value="Gabon">Gabon</option>
                                                         <option value="Gambia">Gambia</option>
                                                         <option value="Georgia">Georgia</option>
                                                         <option value="Germany">Germany</option>
                                                         <option value="Ghana">Ghana</option>
                                                         <option value="Gibraltar">Gibraltar</option>
                                                         <option value="Great Britain">Great Britain</option>
                                                         <option value="Greece">Greece</option>
                                                         <option value="Greenland">Greenland</option>
                                                         <option value="Grenada">Grenada</option>
                                                         <option value="Guadeloupe">Guadeloupe</option>
                                                         <option value="Guam">Guam</option>
                                                         <option value="Guatemala">Guatemala</option>
                                                         <option value="Guinea">Guinea</option>
                                                         <option value="Guyana">Guyana</option>
                                                         <option value="Haiti">Haiti</option>
                                                         <option value="Hawaii">Hawaii</option>
                                                         <option value="Honduras">Honduras</option>
                                                         <option value="Hong Kong">Hong Kong</option>
                                                         <option value="Hungary">Hungary</option>
                                                         <option value="Iceland">Iceland</option>
                                                         <option value="Indonesia">Indonesia</option>
                                                         <option value="India">India</option>
                                                         <option value="Iran">Iran</option>
                                                         <option value="Iraq">Iraq</option>
                                                         <option value="Ireland">Ireland</option>
                                                         <option value="Isle of Man">Isle of Man</option>
                                                         <option value="Israel">Israel</option>
                                                         <option value="Italy">Italy</option>
                                                         <option value="Jamaica">Jamaica</option>
                                                         <option value="Japan">Japan</option>
                                                         <option value="Jordan">Jordan</option>
                                                         <option value="Kazakhstan">Kazakhstan</option>
                                                         <option value="Kenya">Kenya</option>
                                                         <option value="Kiribati">Kiribati</option>
                                                         <option value="Korea North">Korea North</option>
                                                         <option value="Korea Sout">Korea South</option>
                                                         <option value="Kuwait">Kuwait</option>
                                                         <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                         <option value="Laos">Laos</option>
                                                         <option value="Latvia">Latvia</option>
                                                         <option value="Lebanon">Lebanon</option>
                                                         <option value="Lesotho">Lesotho</option>
                                                         <option value="Liberia">Liberia</option>
                                                         <option value="Libya">Libya</option>
                                                         <option value="Liechtenstein">Liechtenstein</option>
                                                         <option value="Lithuania">Lithuania</option>
                                                         <option value="Luxembourg">Luxembourg</option>
                                                         <option value="Macau">Macau</option>
                                                         <option value="Macedonia">Macedonia</option>
                                                         <option value="Madagascar">Madagascar</option>
                                                         <option value="Malaysia">Malaysia</option>
                                                         <option value="Malawi">Malawi</option>
                                                         <option value="Maldives">Maldives</option>
                                                         <option value="Mali">Mali</option>
                                                         <option value="Malta">Malta</option>
                                                         <option value="Marshall Islands">Marshall Islands</option>
                                                         <option value="Martinique">Martinique</option>
                                                         <option value="Mauritania">Mauritania</option>
                                                         <option value="Mauritius">Mauritius</option>
                                                         <option value="Mayotte">Mayotte</option>
                                                         <option value="Mexico">Mexico</option>
                                                         <option value="Midway Islands">Midway Islands</option>
                                                         <option value="Moldova">Moldova</option>
                                                         <option value="Monaco">Monaco</option>
                                                         <option value="Mongolia">Mongolia</option>
                                                         <option value="Montserrat">Montserrat</option>
                                                         <option value="Morocco">Morocco</option>
                                                         <option value="Mozambique">Mozambique</option>
                                                         <option value="Myanmar">Myanmar</option>
                                                         <option value="Nambia">Nambia</option>
                                                         <option value="Nauru">Nauru</option>
                                                         <option value="Nepal">Nepal</option>
                                                         <option value="Netherland Antilles">Netherland Antilles</option>
                                                         <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                         <option value="Nevis">Nevis</option>
                                                         <option value="New Caledonia">New Caledonia</option>
                                                         <option value="New Zealand">New Zealand</option>
                                                         <option value="Nicaragua">Nicaragua</option>
                                                         <option value="Niger">Niger</option>
                                                         <option value="Nigeria">Nigeria</option>
                                                         <option value="Niue">Niue</option>
                                                         <option value="Norfolk Island">Norfolk Island</option>
                                                         <option value="Norway">Norway</option>
                                                         <option value="Oman">Oman</option>
                                                         <option value="Pakistan">Pakistan</option>
                                                         <option value="Palau Island">Palau Island</option>
                                                         <option value="Palestine">Palestine</option>
                                                         <option value="Panama">Panama</option>
                                                         <option value="Papua New Guinea">Papua New Guinea</option>
                                                         <option value="Paraguay">Paraguay</option>
                                                         <option value="Peru">Peru</option>
                                                         <option value="Phillipines">Philippines</option>
                                                         <option value="Pitcairn Island">Pitcairn Island</option>
                                                         <option value="Poland">Poland</option>
                                                         <option value="Portugal">Portugal</option>
                                                         <option value="Puerto Rico">Puerto Rico</option>
                                                         <option value="Qatar">Qatar</option>
                                                         <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                         <option value="Republic of Serbia">Republic of Serbia</option>
                                                         <option value="Reunion">Reunion</option>
                                                         <option value="Romania">Romania</option>
                                                         <option value="Russia">Russia</option>
                                                         <option value="Rwanda">Rwanda</option>
                                                         <option value="St Barthelemy">St Barthelemy</option>
                                                         <option value="St Eustatius">St Eustatius</option>
                                                         <option value="St Helena">St Helena</option>
                                                         <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                         <option value="St Lucia">St Lucia</option>
                                                         <option value="St Maarten">St Maarten</option>
                                                         <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                         <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                         <option value="Saipan">Saipan</option>
                                                         <option value="Samoa">Samoa</option>
                                                         <option value="Samoa American">Samoa American</option>
                                                         <option value="San Marino">San Marino</option>
                                                         <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                         <option value="Saudi Arabia">Saudi Arabia</option>
                                                         <option value="Senegal">Senegal</option>
                                                         <option value="Seychelles">Seychelles</option>
                                                         <option value="Sierra Leone">Sierra Leone</option>
                                                         <option value="Singapore">Singapore</option>
                                                         <option value="Slovakia">Slovakia</option>
                                                         <option value="Slovenia">Slovenia</option>
                                                         <option value="Solomon Islands">Solomon Islands</option>
                                                         <option value="Somalia">Somalia</option>
                                                         <option value="South Africa">South Africa</option>
                                                         <option value="Spain">Spain</option>
                                                         <option value="Sri Lanka">Sri Lanka</option>
                                                         <option value="Sudan">Sudan</option>
                                                         <option value="Suriname">Suriname</option>
                                                         <option value="Swaziland">Swaziland</option>
                                                         <option value="Sweden">Sweden</option>
                                                         <option value="Switzerland">Switzerland</option>
                                                         <option value="Syria">Syria</option>
                                                         <option value="Tahiti">Tahiti</option>
                                                         <option value="Taiwan">Taiwan</option>
                                                         <option value="Tajikistan">Tajikistan</option>
                                                         <option value="Tanzania">Tanzania</option>
                                                         <option value="Thailand">Thailand</option>
                                                         <option value="Togo">Togo</option>
                                                         <option value="Tokelau">Tokelau</option>
                                                         <option value="Tonga">Tonga</option>
                                                         <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                         <option value="Tunisia">Tunisia</option>
                                                         <option value="Turkey">Turkey</option>
                                                         <option value="Turkmenistan">Turkmenistan</option>
                                                         <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                         <option value="Tuvalu">Tuvalu</option>
                                                         <option value="Uganda">Uganda</option>
                                                         <option value="United Kingdom">United Kingdom</option>
                                                         <option value="Ukraine">Ukraine</option>
                                                         <option value="United Arab Erimates">United Arab Emirates</option>
                                                         <option value="United States of America">United States of America</option>
                                                         <option value="Uraguay">Uruguay</option>
                                                         <option value="Uzbekistan">Uzbekistan</option>
                                                         <option value="Vanuatu">Vanuatu</option>
                                                         <option value="Vatican City State">Vatican City State</option>
                                                         <option value="Venezuela">Venezuela</option>
                                                         <option value="Vietnam">Vietnam</option>
                                                         <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                         <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                         <option value="Wake Island">Wake Island</option>
                                                         <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                         <option value="Yemen">Yemen</option>
                                                         <option value="Zaire">Zaire</option>
                                                         <option value="Zambia">Zambia</option>
                                                         <option value="Zimbabwe">Zimbabwe</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <input type="text" name="birth-state" class="form-control" <?php echo $memorial->birthState ? 'value="'.$memorial->birthState.'"' : 'placeholder="State/City/Area"' ?>>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>

                                     <div class="col-md-12 mb-5">
                                         <h6>Passing Details: </h6>
                                         <div class="row">
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <input type="text" name="passing-date" id="passing-date" class="form-control" autocomplete="off">
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <select class="form-control form-select" id="passing-country" name="passing-country" style="margin-top: -2px;">
                                                         <option selected disabled>Please Select Country</option>
                                                         <option value="Afganistan">Afghanistan</option>
                                                         <option value="Albania">Albania</option>
                                                         <option value="Algeria">Algeria</option>
                                                         <option value="American Samoa">American Samoa</option>
                                                         <option value="Andorra">Andorra</option>
                                                         <option value="Angola">Angola</option>
                                                         <option value="Anguilla">Anguilla</option>
                                                         <option value="Antigua & Barbuda">Antigua & Barbuda</option>
                                                         <option value="Argentina">Argentina</option>
                                                         <option value="Armenia">Armenia</option>
                                                         <option value="Aruba">Aruba</option>
                                                         <option value="Australia">Australia</option>
                                                         <option value="Austria">Austria</option>
                                                         <option value="Azerbaijan">Azerbaijan</option>
                                                         <option value="Bahamas">Bahamas</option>
                                                         <option value="Bahrain">Bahrain</option>
                                                         <option value="Bangladesh">Bangladesh</option>
                                                         <option value="Barbados">Barbados</option>
                                                         <option value="Belarus">Belarus</option>
                                                         <option value="Belgium">Belgium</option>
                                                         <option value="Belize">Belize</option>
                                                         <option value="Benin">Benin</option>
                                                         <option value="Bermuda">Bermuda</option>
                                                         <option value="Bhutan">Bhutan</option>
                                                         <option value="Bolivia">Bolivia</option>
                                                         <option value="Bonaire">Bonaire</option>
                                                         <option value="Bosnia & Herzegovina">Bosnia & Herzegovina</option>
                                                         <option value="Botswana">Botswana</option>
                                                         <option value="Brazil">Brazil</option>
                                                         <option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
                                                         <option value="Brunei">Brunei</option>
                                                         <option value="Bulgaria">Bulgaria</option>
                                                         <option value="Burkina Faso">Burkina Faso</option>
                                                         <option value="Burundi">Burundi</option>
                                                         <option value="Cambodia">Cambodia</option>
                                                         <option value="Cameroon">Cameroon</option>
                                                         <option value="Canada">Canada</option>
                                                         <option value="Canary Islands">Canary Islands</option>
                                                         <option value="Cape Verde">Cape Verde</option>
                                                         <option value="Cayman Islands">Cayman Islands</option>
                                                         <option value="Central African Republic">Central African Republic</option>
                                                         <option value="Chad">Chad</option>
                                                         <option value="Channel Islands">Channel Islands</option>
                                                         <option value="Chile">Chile</option>
                                                         <option value="China">China</option>
                                                         <option value="Christmas Island">Christmas Island</option>
                                                         <option value="Cocos Island">Cocos Island</option>
                                                         <option value="Colombia">Colombia</option>
                                                         <option value="Comoros">Comoros</option>
                                                         <option value="Congo">Congo</option>
                                                         <option value="Cook Islands">Cook Islands</option>
                                                         <option value="Costa Rica">Costa Rica</option>
                                                         <option value="Cote DIvoire">Cote DIvoire</option>
                                                         <option value="Croatia">Croatia</option>
                                                         <option value="Cuba">Cuba</option>
                                                         <option value="Curaco">Curacao</option>
                                                         <option value="Cyprus">Cyprus</option>
                                                         <option value="Czech Republic">Czech Republic</option>
                                                         <option value="Denmark">Denmark</option>
                                                         <option value="Djibouti">Djibouti</option>
                                                         <option value="Dominica">Dominica</option>
                                                         <option value="Dominican Republic">Dominican Republic</option>
                                                         <option value="East Timor">East Timor</option>
                                                         <option value="Ecuador">Ecuador</option>
                                                         <option value="Egypt">Egypt</option>
                                                         <option value="El Salvador">El Salvador</option>
                                                         <option value="Equatorial Guinea">Equatorial Guinea</option>
                                                         <option value="Eritrea">Eritrea</option>
                                                         <option value="Estonia">Estonia</option>
                                                         <option value="Ethiopia">Ethiopia</option>
                                                         <option value="Falkland Islands">Falkland Islands</option>
                                                         <option value="Faroe Islands">Faroe Islands</option>
                                                         <option value="Fiji">Fiji</option>
                                                         <option value="Finland">Finland</option>
                                                         <option value="France">France</option>
                                                         <option value="French Guiana">French Guiana</option>
                                                         <option value="French Polynesia">French Polynesia</option>
                                                         <option value="French Southern Ter">French Southern Ter</option>
                                                         <option value="Gabon">Gabon</option>
                                                         <option value="Gambia">Gambia</option>
                                                         <option value="Georgia">Georgia</option>
                                                         <option value="Germany">Germany</option>
                                                         <option value="Ghana">Ghana</option>
                                                         <option value="Gibraltar">Gibraltar</option>
                                                         <option value="Great Britain">Great Britain</option>
                                                         <option value="Greece">Greece</option>
                                                         <option value="Greenland">Greenland</option>
                                                         <option value="Grenada">Grenada</option>
                                                         <option value="Guadeloupe">Guadeloupe</option>
                                                         <option value="Guam">Guam</option>
                                                         <option value="Guatemala">Guatemala</option>
                                                         <option value="Guinea">Guinea</option>
                                                         <option value="Guyana">Guyana</option>
                                                         <option value="Haiti">Haiti</option>
                                                         <option value="Hawaii">Hawaii</option>
                                                         <option value="Honduras">Honduras</option>
                                                         <option value="Hong Kong">Hong Kong</option>
                                                         <option value="Hungary">Hungary</option>
                                                         <option value="Iceland">Iceland</option>
                                                         <option value="Indonesia">Indonesia</option>
                                                         <option value="India">India</option>
                                                         <option value="Iran">Iran</option>
                                                         <option value="Iraq">Iraq</option>
                                                         <option value="Ireland">Ireland</option>
                                                         <option value="Isle of Man">Isle of Man</option>
                                                         <option value="Israel">Israel</option>
                                                         <option value="Italy">Italy</option>
                                                         <option value="Jamaica">Jamaica</option>
                                                         <option value="Japan">Japan</option>
                                                         <option value="Jordan">Jordan</option>
                                                         <option value="Kazakhstan">Kazakhstan</option>
                                                         <option value="Kenya">Kenya</option>
                                                         <option value="Kiribati">Kiribati</option>
                                                         <option value="Korea North">Korea North</option>
                                                         <option value="Korea Sout">Korea South</option>
                                                         <option value="Kuwait">Kuwait</option>
                                                         <option value="Kyrgyzstan">Kyrgyzstan</option>
                                                         <option value="Laos">Laos</option>
                                                         <option value="Latvia">Latvia</option>
                                                         <option value="Lebanon">Lebanon</option>
                                                         <option value="Lesotho">Lesotho</option>
                                                         <option value="Liberia">Liberia</option>
                                                         <option value="Libya">Libya</option>
                                                         <option value="Liechtenstein">Liechtenstein</option>
                                                         <option value="Lithuania">Lithuania</option>
                                                         <option value="Luxembourg">Luxembourg</option>
                                                         <option value="Macau">Macau</option>
                                                         <option value="Macedonia">Macedonia</option>
                                                         <option value="Madagascar">Madagascar</option>
                                                         <option value="Malaysia">Malaysia</option>
                                                         <option value="Malawi">Malawi</option>
                                                         <option value="Maldives">Maldives</option>
                                                         <option value="Mali">Mali</option>
                                                         <option value="Malta">Malta</option>
                                                         <option value="Marshall Islands">Marshall Islands</option>
                                                         <option value="Martinique">Martinique</option>
                                                         <option value="Mauritania">Mauritania</option>
                                                         <option value="Mauritius">Mauritius</option>
                                                         <option value="Mayotte">Mayotte</option>
                                                         <option value="Mexico">Mexico</option>
                                                         <option value="Midway Islands">Midway Islands</option>
                                                         <option value="Moldova">Moldova</option>
                                                         <option value="Monaco">Monaco</option>
                                                         <option value="Mongolia">Mongolia</option>
                                                         <option value="Montserrat">Montserrat</option>
                                                         <option value="Morocco">Morocco</option>
                                                         <option value="Mozambique">Mozambique</option>
                                                         <option value="Myanmar">Myanmar</option>
                                                         <option value="Nambia">Nambia</option>
                                                         <option value="Nauru">Nauru</option>
                                                         <option value="Nepal">Nepal</option>
                                                         <option value="Netherland Antilles">Netherland Antilles</option>
                                                         <option value="Netherlands">Netherlands (Holland, Europe)</option>
                                                         <option value="Nevis">Nevis</option>
                                                         <option value="New Caledonia">New Caledonia</option>
                                                         <option value="New Zealand">New Zealand</option>
                                                         <option value="Nicaragua">Nicaragua</option>
                                                         <option value="Niger">Niger</option>
                                                         <option value="Nigeria">Nigeria</option>
                                                         <option value="Niue">Niue</option>
                                                         <option value="Norfolk Island">Norfolk Island</option>
                                                         <option value="Norway">Norway</option>
                                                         <option value="Oman">Oman</option>
                                                         <option value="Pakistan">Pakistan</option>
                                                         <option value="Palau Island">Palau Island</option>
                                                         <option value="Palestine">Palestine</option>
                                                         <option value="Panama">Panama</option>
                                                         <option value="Papua New Guinea">Papua New Guinea</option>
                                                         <option value="Paraguay">Paraguay</option>
                                                         <option value="Peru">Peru</option>
                                                         <option value="Phillipines">Philippines</option>
                                                         <option value="Pitcairn Island">Pitcairn Island</option>
                                                         <option value="Poland">Poland</option>
                                                         <option value="Portugal">Portugal</option>
                                                         <option value="Puerto Rico">Puerto Rico</option>
                                                         <option value="Qatar">Qatar</option>
                                                         <option value="Republic of Montenegro">Republic of Montenegro</option>
                                                         <option value="Republic of Serbia">Republic of Serbia</option>
                                                         <option value="Reunion">Reunion</option>
                                                         <option value="Romania">Romania</option>
                                                         <option value="Russia">Russia</option>
                                                         <option value="Rwanda">Rwanda</option>
                                                         <option value="St Barthelemy">St Barthelemy</option>
                                                         <option value="St Eustatius">St Eustatius</option>
                                                         <option value="St Helena">St Helena</option>
                                                         <option value="St Kitts-Nevis">St Kitts-Nevis</option>
                                                         <option value="St Lucia">St Lucia</option>
                                                         <option value="St Maarten">St Maarten</option>
                                                         <option value="St Pierre & Miquelon">St Pierre & Miquelon</option>
                                                         <option value="St Vincent & Grenadines">St Vincent & Grenadines</option>
                                                         <option value="Saipan">Saipan</option>
                                                         <option value="Samoa">Samoa</option>
                                                         <option value="Samoa American">Samoa American</option>
                                                         <option value="San Marino">San Marino</option>
                                                         <option value="Sao Tome & Principe">Sao Tome & Principe</option>
                                                         <option value="Saudi Arabia">Saudi Arabia</option>
                                                         <option value="Senegal">Senegal</option>
                                                         <option value="Seychelles">Seychelles</option>
                                                         <option value="Sierra Leone">Sierra Leone</option>
                                                         <option value="Singapore">Singapore</option>
                                                         <option value="Slovakia">Slovakia</option>
                                                         <option value="Slovenia">Slovenia</option>
                                                         <option value="Solomon Islands">Solomon Islands</option>
                                                         <option value="Somalia">Somalia</option>
                                                         <option value="South Africa">South Africa</option>
                                                         <option value="Spain">Spain</option>
                                                         <option value="Sri Lanka">Sri Lanka</option>
                                                         <option value="Sudan">Sudan</option>
                                                         <option value="Suriname">Suriname</option>
                                                         <option value="Swaziland">Swaziland</option>
                                                         <option value="Sweden">Sweden</option>
                                                         <option value="Switzerland">Switzerland</option>
                                                         <option value="Syria">Syria</option>
                                                         <option value="Tahiti">Tahiti</option>
                                                         <option value="Taiwan">Taiwan</option>
                                                         <option value="Tajikistan">Tajikistan</option>
                                                         <option value="Tanzania">Tanzania</option>
                                                         <option value="Thailand">Thailand</option>
                                                         <option value="Togo">Togo</option>
                                                         <option value="Tokelau">Tokelau</option>
                                                         <option value="Tonga">Tonga</option>
                                                         <option value="Trinidad & Tobago">Trinidad & Tobago</option>
                                                         <option value="Tunisia">Tunisia</option>
                                                         <option value="Turkey">Turkey</option>
                                                         <option value="Turkmenistan">Turkmenistan</option>
                                                         <option value="Turks & Caicos Is">Turks & Caicos Is</option>
                                                         <option value="Tuvalu">Tuvalu</option>
                                                         <option value="Uganda">Uganda</option>
                                                         <option value="United Kingdom">United Kingdom</option>
                                                         <option value="Ukraine">Ukraine</option>
                                                         <option value="United Arab Erimates">United Arab Emirates</option>
                                                         <option value="United States of America">United States of America</option>
                                                         <option value="Uraguay">Uruguay</option>
                                                         <option value="Uzbekistan">Uzbekistan</option>
                                                         <option value="Vanuatu">Vanuatu</option>
                                                         <option value="Vatican City State">Vatican City State</option>
                                                         <option value="Venezuela">Venezuela</option>
                                                         <option value="Vietnam">Vietnam</option>
                                                         <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
                                                         <option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
                                                         <option value="Wake Island">Wake Island</option>
                                                         <option value="Wallis & Futana Is">Wallis & Futana Is</option>
                                                         <option value="Yemen">Yemen</option>
                                                         <option value="Zaire">Zaire</option>
                                                         <option value="Zambia">Zambia</option>
                                                         <option value="Zimbabwe">Zimbabwe</option>
                                                     </select>
                                                 </div>
                                             </div>
                                             <div class="col-md-4">
                                                 <div class="form-group">
                                                     <input type="text" name="passing-state" class="form-control" <?php echo $memorial->passingState ? 'value="'.$memorial->passingState.'"' : 'placeholder="State/City/Area"' ?>>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- /.modal-body -->
                                 <!-- .modal-footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="genric-btn dark" data-dismiss="modal">Close</button>
                                     <button type="submit" class="genric-btn info">Save changes</button>
                                 </div>
                                 <!-- /.modal-footer -->
                             </form>
                         </div>
                         <!-- /.modal-content -->
                     </div>
                     <!-- /.modal-dialog -->
                 </div>


                 <div class="modal fade" id="auth-modal" tabindex="-1" role="dialog" aria-hidden="true">
                     <!-- .modal-dialog -->
                     <div class="modal-dialog modal-dialog-overflow mt-5" role="document" style="max-width: 35%">
                         <!-- .modal-content -->
                         <div class="modal-content">
                             <!-- .modal-header -->
                             <div class="modal-header modal-primary">
                                 <h6 class="modal-title"> Confirm your identity </h6>
                                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="font-weight:500">×</button>
                             </div>
                             <!-- /.modal-header -->
                             <form method="post" id="auth-form">
                                 <!-- .modal-body -->
                                 <div class="modal-body">
                                     <div class="col-md-12">
                                         <h6>Please confirm your email address to delete this memorial.</h6>

                                         <div class="form-group mt-4">
                                             <label>Email</label>
                                             <input type="email" class="form-control" name="email" required>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- /.modal-body -->
                                 <!-- .modal-footer -->
                                 <div class="modal-footer">
                                     <button type="button" class="genric-btn dark" data-dismiss="modal">Close</button>
                                     <button type="submit" class="genric-btn info">Confirm</button>
                                 </div>
                                 <!-- /.modal-footer -->
                             </form>
                         </div>
                         <!-- /.modal-content -->
                     </div>
                     <!-- /.modal-dialog -->
                 </div>
                 <?php endif; ?>

                 <?php endif; ?>
             </div>
         </div>
     </div>
</div>

<link href="https://fonts.googleapis.com/css2?family=Courgette&display=swap" rel="stylesheet">
<link href="<?= VENDOR_PATH ?>summernote/summernote.min.css" rel="stylesheet">
<script src="<?= VENDOR_PATH ?>summernote/summernote.min.js"></script>

<link rel="stylesheet" href="<?= CSS_PATH ?>gijgo.css">
<script src="<?= JS_PATH ?>gijgo.min.js"></script>

<link href="<?= VENDOR_PATH ?>bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet">
<script src="<?= VENDOR_PATH ?>bootstrap-fileinput/js/fileinput.min.js"></script>
<script src="<?= VENDOR_PATH ?>bootstrap-fileinput/themes/fa/theme.min.js"></script>

<link href="<?= VENDOR_PATH ?>photoswipe/dist/photoswipe.css" rel="stylesheet">
<link href="<?= VENDOR_PATH ?>photoswipe/dist/default-skin/default-skin.css" rel="stylesheet">
<script src="<?= VENDOR_PATH ?>photoswipe/dist/photoswipe.min.js"></script>
<script src="<?= VENDOR_PATH ?>photoswipe/dist/photoswipe-ui-default.min.js"></script>

<script>
    var initPhotoSwipeFromDOM = function(gallerySelector) {

        // parse slide data (url, title, size ...) from DOM elements
        // (children of gallerySelector)
        var parseThumbnailElements = function(el) {
            var thumbElements = el.childNodes,
                numNodes = thumbElements.length,
                items = [],
                figureEl,
                linkEl,
                size,
                item;

            for(var i = 0; i < numNodes; i++) {

                figureEl = thumbElements[i]; // <figure> element

                // include only element nodes
                if(figureEl.nodeType !== 1) {
                    continue;
                }

                linkEl = figureEl.children[0].children[1]; // <a> element

                size = linkEl.getAttribute('data-size').split('x');

                // create slide object
                item = {
                    src: linkEl.getAttribute('href'),
                    w: parseInt(size[0], 10),
                    h: parseInt(size[1], 10)
                };



                if(figureEl.children.length > 1) {
                    // <figcaption> content
                    item.title = figureEl.children[1].innerHTML;
                }

                if(linkEl.children.length > 0) {
                    // <img> thumbnail element, retrieving thumbnail url
                    item.msrc = linkEl.children[0].getAttribute('src');
                }

                item.el = figureEl; // save link to element for getThumbBoundsFn
                items.push(item);
            }

            return items;
        };

        // find nearest parent element
        var closest = function closest(el, fn) {
            return el && ( fn(el) ? el : closest(el.parentNode, fn) );
        };

        // triggers when user clicks on thumbnail
        var onThumbnailsClick = function(e) {
            e = e || window.event;
            e.preventDefault ? e.preventDefault() : e.returnValue = false;

            var eTarget = e.target || e.srcElement;

            // find root element of slide
            var clickedListItem = closest(eTarget, function(el) {
                return (el.tagName && el.tagName.toUpperCase() === 'FIGURE');
            });

            if(!clickedListItem) {
                return;
            }

            // find index of clicked item by looping through all child nodes
            // alternatively, you may define index via data- attribute
            var clickedGallery = clickedListItem.parentNode,
                childNodes = clickedListItem.parentNode.childNodes,
                numChildNodes = childNodes.length,
                nodeIndex = 0,
                index;

            for (var i = 0; i < numChildNodes; i++) {
                if(childNodes[i].nodeType !== 1) {
                    continue;
                }

                if(childNodes[i] === clickedListItem) {
                    index = nodeIndex;
                    break;
                }
                nodeIndex++;
            }



            if(index >= 0) {
                // open PhotoSwipe if valid index found
                openPhotoSwipe( index, clickedGallery );
            }
            return false;
        };

        // parse picture index and gallery index from URL (#&pid=1&gid=2)
        var photoswipeParseHash = function() {
            var hash = window.location.hash.substring(1),
                params = {};

            if(hash.length < 5) {
                return params;
            }

            var vars = hash.split('&');
            for (var i = 0; i < vars.length; i++) {
                if(!vars[i]) {
                    continue;
                }
                var pair = vars[i].split('=');
                if(pair.length < 2) {
                    continue;
                }
                params[pair[0]] = pair[1];
            }

            if(params.gid) {
                params.gid = parseInt(params.gid, 10);
            }

            return params;
        };

        var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
            var pswpElement = document.querySelectorAll('.pswp')[0],
                gallery,
                options,
                items;

            items = parseThumbnailElements(galleryElement);

            // define options (if needed)
            options = {

                // define gallery index (for URL)
                galleryUID: galleryElement.getAttribute('data-pswp-uid'),

                getThumbBoundsFn: function(index) {
                    // See Options -> getThumbBoundsFn section of documentation for more info
                    var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
                        pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
                        rect = thumbnail.getBoundingClientRect();

                    return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
                }

            };

            // PhotoSwipe opened from URL
            if(fromURL) {
                if(options.galleryPIDs) {
                    // parse real index when custom PIDs are used
                    // http://photoswipe.com/documentation/faq.html#custom-pid-in-url
                    for(var j = 0; j < items.length; j++) {
                        if(items[j].pid == index) {
                            options.index = j;
                            break;
                        }
                    }
                } else {
                    // in URL indexes start from 1
                    options.index = parseInt(index, 10) - 1;
                }
            } else {
                options.index = parseInt(index, 10);
            }

            // exit if index not found
            if( isNaN(options.index) ) {
                return;
            }

            if(disableAnimation) {
                options.showAnimationDuration = 0;
            }

            // Pass data to PhotoSwipe and initialize it
            gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
            gallery.init();
        };

        // loop through all gallery elements and bind events
        var galleryElements = document.querySelectorAll( gallerySelector );

        for(var i = 0, l = galleryElements.length; i < l; i++) {
            galleryElements[i].setAttribute('data-pswp-uid', i+1);
            galleryElements[i].onclick = onThumbnailsClick;
        }

        // Parse URL and open gallery if it contains #&pid=3&gid=1
        var hashData = photoswipeParseHash();
        if(hashData.pid && hashData.gid) {
            openPhotoSwipe( hashData.pid ,  galleryElements[ hashData.gid - 1 ], true, true );
        }
    };
    initPhotoSwipeFromDOM('.memorials_gallery-row');

    $(document).ready(function () {
        $('.summernote').summernote({height: 200});

        // store the currently selected tab in the hash value
        $(document).on('shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
            history.pushState({}, '', '#'+ $(e.target).attr("href").substr(1));
        });
        // on load of the page: switch to the currently selected tab
        var hash = window.location.hash;
        $('.nav-tabs a[href="' + hash + '"]').tab('show');

        var file = $('#gallery-form-input');
        file.fileinput({
            theme: 'fa',
            allowedFileExtensions: ['jpg', 'png', 'gif'],
            uploadUrl: '<?= HOST_NAME ?>ajax/memorial_photos_add/<?= $memorial->id ?>',
            overwriteInitial: true,
            uploadAsync: false
        });

        <?php if (Session::Exists('loggedin')) : ?>
        // insert
        $('#biography-form').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            ShowLoader();

            $.ajax({
                url: '<?= HOST_NAME ?>ajax/memorial_biography_add/<?= $memorial->id ?>',
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function (data) {
                if (data.status == 1 && data.id !== "0") {
                    var bio = '<article class="blog_item mb-3" id="memorial-biography-item-'+data.id+'">\n' +
                        ' <div class="blog_details">\n' +
                        '     <p>'+data.story+'</p>\n' +
                        '     <ul class="blog-info-link">\n' +
                        '         <li class="pull-right-btn"><a class="" href="#"><i class="fa fa-share"></i> Share <i class="fa fa-caret-down"></i></a></li>\n' +
                        '     </ul>\n' +
                        ' </div>\n' +
                        '</article>';
                    $('#memorial-biography-area').prepend(bio);
                    $('.summernote').summernote('code', '');
                    scrollTo('#memorial-biography-item-'+data.id);
                } else {
                    displayError(data.msg);
                }
            }).fail(function (msg) {
                displayError(msg.responseText);
            }).always(function () {
                $(".loader").fadeOut("slow");
                $("#overlayer").fadeOut("slow");
            });
        });
        $('#tribute-form').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            ShowLoader();

            $.ajax({
                url: '<?= HOST_NAME ?>ajax/memorial_tribute_add/<?= $memorial->id ?>',
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function (data) {
                if (data.status == 1 && data.id !== "0") {
                    var tribute = '<article class="blog_item mb-3" id="memorial-tribute-item-'+data.id+'">\n' +
                        '     <div class="blog_details">\n' +
                        '         <p>'+data.tribute+'</p>\n' +
                        '         <ul class="blog-info-link">\n' +
                        '             <li><a href="#"><i class="fa fa-user"></i> '+"<?= Session::Get('loggedin')->firstName.' '.Session::Get('loggedin')->lastName ?>"+'</a></li>\n' +
                        '             <li><a href="#"><i class="fa fa-clock-o"></i> Just now </a></li>\n' +
                        '             <li class="pull-right-btn"><a class="" href="#"><i class="fa fa-share"></i> Share <i class="fa fa-caret-down"></i></a></li>\n' +
                        '         </ul>\n' +
                        '     </div>\n' +
                        ' </article>\n';
                    $('#memorial-tributes-area').prepend(tribute);
                    $('.tribute-textarea').val('');
                    scrollTo('#memorial-tribute-item-'+data.id);
                } else {
                    displayError(data.msg);
                }
            }).fail(function (msg) {
                displayError(msg.responseText);
            }).always(function () {
                $(".loader").fadeOut("slow");
                $("#overlayer").fadeOut("slow");
            });
        });

        // delete
        $('.delete-item').on('click', function (e) {
            e.preventDefault();

            var id = $(this).data("item-id"),
                type = $(this).data("item-type");

            if (id && type) {
                ShowLoader();

                $.ajax({
                    url: '<?= HOST_NAME ?>ajax/memorial_item_delete/'+type+'/<?= $memorial->id ?>/'+id,
                    type: "POST",
                    dataType: "json"
                }).done(function (data) {
                    if (data === 1) {
                        $('#memorial-'+type+'-item-'+id).remove();
                    } else {
                        displayError(data);
                    }
                }).fail(function (msg) {
                    displayError(msg.responseText);
                }).always(function () {
                    $(".loader").fadeOut("slow");
                    $("#overlayer").fadeOut("slow");
                });
            }
        });


        // edit
        $(document).on('click', '.edit-memorial-about', function (e) {
            e.preventDefault();
            // update "edit about" modal
            if ("<?= $memorial->birthCountry ?>") {
                $('#birth-country option[value="<?= $memorial->birthCountry ?>"]').attr('selected', true);
            }
            if ("<?= $memorial->passingCountry ?>") {
                $('#passing-country option[value="<?= $memorial->passingCountry ?>"]').attr('selected', true);
            }
            $('#relationship option[value="<?= $memorial->relationship ?>"]').attr('selected', true);
            if ("<?= $memorial->relationship ?>" == "Other") {
                $('#relationship-other').removeClass('hidden');
                $('#relationship-other').val("<?= $memorial->relationship_other ?>");
            }
            var $birthDate = $('#birthdate').datepicker({
                iconsLibrary: 'fontawesome',
                icons: {
                    rightIcon: '<span class="fa fa-caret-down"></span>'
                }
            });
            var $passingDate = $('#passing-date').datepicker({
                iconsLibrary: 'fontawesome',
                icons: {
                    rightIcon: '<span class="fa fa-caret-down"></span>'
                }
            });
            if ("<?= $memorial->birthDate ?>") {
                $birthDate.value("<?= date('m-d-Y', strtotime($memorial->birthDate)) ?>");
            }
            if ("<?= $memorial->passingDate ?>") {
                $passingDate.value("<?= date('m-d-Y', strtotime($memorial->passingDate)) ?>");
            }

            $('#edit-memorial-about-modal').modal();
        });
        $(document).on('submit', '#edit-memorial-about-form', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            ShowLoader();

            $.ajax({
                url: '<?= HOST_NAME ?>ajax/memorial_about_edit/<?= $memorial->id ?>',
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function (data) {
                if (data.status === 1) {
                    window.location.reload();
                } else {
                    displayError(data.msg);
                }
            }).fail(function (msg) {
                displayError(msg.responseText);
            }).always(function () {
                $(".loader").fadeOut("slow");
                $("#overlayer").fadeOut("slow");
            });
        });
        $(document).on('click', '.edit-item', function (e) {
            e.preventDefault();

            var id = $(this).data("item-id"),
                content = $('#memorial-biography-item-'+id+' .memorial-biography-content').html();

            $('#edit-biography-modal #edit-biography-form .note-editable').html(content);
            $('#edit-biography-modal #edit-biography-form #story-id').val(id);
            $('#edit-biography-modal').modal();
        });
        $(document).on('submit', '#edit-biography-form', function (e) {
            e.preventDefault();

            $('#edit-biography-modal').modal('hide');
            ShowLoader();

            var formData = $(this).serialize();
            $.ajax({
                url: '<?= HOST_NAME ?>ajax/memorial_biography_edit',
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function (data) {
                if (data.status == 1 && data.story) {
                    $('#memorial-biography-item-'+data.id+' .memorial-biography-content').html(data.story);
                    $('.summernote').summernote('code', '');
                    $('#edit-biography-modal #edit-biography-form #story-id').val('');
                    scrollTo('#memorial-biography-item-'+data.id);
                } else {
                    displayError(data.msg);
                }
            }).fail(function (msg) {
                displayError(msg.responseText);
            }).always(function () {
                $(".loader").fadeOut("slow");
                $("#overlayer").fadeOut("slow");
            });
        });

        $('.feature-photo').on('click', function (e) {
            e.preventDefault();

            var id = $(this).data("item-id"),
                clicked = $(this).parent().find('.feature-photo i').first(),
                featured = clicked.parent().attr('data-featured');

            if (id) {
                ShowLoader();

                $.ajax({
                    url: '<?= HOST_NAME ?>ajax/memorial_photo_feature/'+id+'/'+featured,
                    type: "POST",
                    dataType: "json"
                }).done(function (data) {
                    if (data === 1) {
                        if (featured == '1') {
                            clicked.parent().attr('data-featured', '2');
                            clicked.addClass('fa-star-o').removeClass('fa-star');
                        } else {
                            clicked.parent().attr('data-featured', '1');
                            clicked.addClass('fa-star').removeClass('fa-star-o');
                        }
                    } else {
                        displayError(data);
                    }
                }).fail(function (msg) {
                    displayError(msg.responseText);
                }).always(function () {
                    $(".loader").fadeOut("slow");
                    $("#overlayer").fadeOut("slow");
                });
            }

        });


        $('#auth-form').on('submit', function (e) {
            e.preventDefault();

            var formData = $(this).serialize();
            $('#auth-modal').modal('hide');
            ShowLoader();

            $.ajax({
                url: '<?= HOST_NAME ?>ajax/memorial_auth/<?= $memorial->id ?>',
                type: "POST",
                dataType: "json",
                data: formData
            }).done(function (data) {
                if (data.msg) {
                    displayError(data.msg);
                }
                if (data.status == 1) {
                    setTimeout(function () {
                        window.open("<?= HOST_NAME ?>", '_self');
                    }, 3000);
                }
            }).fail(function (msg) {
                displayError(msg.responseText);
            }).always(function () {
                $(".loader").fadeOut("slow");
                $("#overlayer").fadeOut("slow");
            });
        });
        <?php endif; ?>


        $.ajax({
            url: '<?= HOST_NAME ?>ajax/memorial_visit/<?= $memorial->id ?>',
            type: "POST",
            dataType: "json"
        });
    });
</script>

<style>
    .container {margin-top: 20px;}
    .owl-stage-outer > .owl-stage {margin:0 auto;}
    .modal-title {padding: 0 1rem}
    .separator:after {background: #d0d0d0; margin-top: 2rem; right: 0}
    .col-md-4:focus {outline: 0 !important;}
    .custom-memorial-form .form-control:active, .custom-memorial-form .form-control:focus {border-color: #A0A0A0;}
    .modal .note-editor {margin-top: 1rem}
</style>
<?php endif; ?>