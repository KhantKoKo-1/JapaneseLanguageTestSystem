<?php 
$title = "type";
require_once("../../layout/user/header.php");
require_once("../../layout/user/nav.php");
require_once("../../config/type_db.php");
require_once("../../config/level_db.php");
require_once("../../config/question_db.php");

$types   = get_all_types($mysqli);
$level_id = '';

if (isset($_GET['level_id'])) {
    $level_id = $_GET['level_id'];
    $level = get_level_by_id($mysqli, $level_id);
    if ($level == NULL) {
        $url =  $base_url . "template/error_pages/404.php";
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '">';
        exit();
    }
}

$questions = get_valid_type_id_by_level_id($mysqli, $level_id);
$allow_type_ids = [];

while ($question = $questions->fetch_assoc()) {
    $valid_type_id = $question['type_id'];
    if (!in_array($valid_type_id, $allow_type_ids)) {
        $allow_type_ids[] = $valid_type_id;
    }
}

?>
<div class="container mt-5" style="margin-top:100%">
    </br>
    </br>
    </br>
    </br>
    <div class="container-fluid appointment py-5">
        <div class="container py-5">
            <div class="card border border-dark" style="width: 100%;">
                <div class="card-body">
                    <div class="row g-5 align-items-center">

                        <div class="col-lg-3 wow fadeInLeft" data-wow-delay="0.2s">
                            <img src="<?php echo $base_url?>/assets/user/images/teacher2.jpg"
                                class="img-fluid rounded-top w-100" alt="src">
                        </div>
                        <div class="col-lg-9 wow fadeInRight" data-wow-delay="0.4s">
                            <?php while ($type = $types->fetch_assoc()) {
                            $type_id   = $type['type_id'];
                            $type_name = $type['type_name'];
                            if (in_array($type_id, $allow_type_ids)) {
                            ?>
                            <a href="<?php echo $user_base_url ."questions.php?level_id=" .$level_id ."&type_id=" . $type_id?>"
                                class="mb-2">
                                <button type="button" class="btn btn-primary btn-lg mb-2"
                                    style="width: 100%;"><?php echo $type_name ?></button>
                            </a>
                            <?php } } ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
</div>

</br>
<?php 
require_once("../../layout/user/footer.php");

?>
</body>

</html>