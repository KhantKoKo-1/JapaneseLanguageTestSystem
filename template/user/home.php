<?php 
$title = "Home";
require_once("../../layout/user/header.php");
require_once("../../layout/user/nav.php");
require_once("../../config/level_db.php");
require_once("../../config/question_db.php");

$levels = get_all_levels($mysqli);
$questions = get_all_questions($mysqli);
$allow_level_ids = [];

while ($question = $questions->fetch_assoc()) {
    $valid_level_id = $question['level_id'];
    if (!in_array($valid_level_id, $allow_level_ids)) {
        $allow_level_ids[] = $valid_level_id;
    }
}

?>
<!-- Carousel Start -->
<div class="header-carousel owl-carousel">
    <div class="header-carousel-item">
        <img src="<?php echo $base_url?>assets/user/images/Japanese2.png" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">
                    Japanese Language Test System
                </h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Preparation</h1>
                <p class="mb-5 fs-5 animated slideInDown">Preparation for the JLPT involves studying Japanese
                    vocabulary, grammar, kanji characters, and practicing listening comprehension. Many resources,
                    including textbooks, practice tests, and online courses, are available to help candidates prepare
                    effectively.
                </p>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5"
                    href=<?php echo $user_base_url. "home.php#questions" ?>>Try Sample Questions</a>
            </div>
        </div>
    </div>
    <div class="header-carousel-item">
        <img src="<?php echo $base_url?>/assets/user/images/Japanese1.png" class="img-fluid w-100" alt="Image">
        <div class="carousel-caption">
            <div class="carousel-caption-content p-3">
                <h5 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 3px;">
                    Japanese Language Test System
                </h5>
                <h1 class="display-1 text-capitalize text-white mb-4">Importance</h1>
                <p class="mb-5 fs-5">Achieving a high score on the JLPT can open doors to education, employment, and
                    further opportunities in Japan and internationally. Many educational institutions, employers, and
                    immigration authorities recognize and accept JLPT scores as proof of Japanese language proficiency.
                </p>
                <a class="btn btn-primary rounded-pill text-white py-3 px-5"
                    href="<?php $user_base_url ."home.php"?>">Try Sample Questions</a>
            </div>
        </div>
    </div>
</div>
<!-- Carousel End -->
</div>
<!-- Services Start -->
<div class="container-fluid service py-5" id="questions">
    <div class="container py-5">
        <div class="section-title mb-5 wow fadeInUp" data-wow-delay="0.2s">
            <div class="sub-style">
                <h4 class="sub-title px-3 mb-0">Let Try Some Questions</h4>
            </div>
            <h1 class="display-3 mb-4">JLPT sample questions</h1>
            <p class="mb-0">Sample questions show the form of test items on the JLPT. Sample questions are organized by
                level, from N1 to N5. One sample question is offered for each test item type. There may be differences
                from questions in the actual test booklet.</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php while ($level = $levels->fetch_assoc()) {
                $level_id   = $level['level_id'];
                $level_name = $level['level_name'];
                if (in_array($level_id, $allow_level_ids)) {
            ?>
            <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                <a href="<?php echo $user_base_url . "type.php?level_id=" .$level['level_id'] ?>"
                    class="service-item rounded">
                    <div class="service-img rounded-top">
                        <img src="<?php echo $base_url?>/assets/user/images/Japanese1.png"
                            class="img-fluid rounded-top w-100" alt="src">
                    </div>
                    <div class="service-content rounded-bottom bg-light p-4">
                        <div class="service-content-inner">
                            <h5 class="mb-4"><?php echo $level_name?></h5>
                            <p class="mb-4"></p>
                        </div>
                    </div>
                </a>
            </div>
            <?php } } ?>
        </div>
    </div>
</div>
<!-- Services End -->

<?php 
            require_once("../../layout/user/footer.php");

            ?>

</body>

</html>