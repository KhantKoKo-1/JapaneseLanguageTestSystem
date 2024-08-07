<!-- Footer Start -->
<div class="container-fluid footer py-5 wow fadeIn" id="footer" data-wow-delay="0.2s">
    <div class="container py-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h5 class="text-white mb-4"><i class="fa fa-star-o me-3"></i>Japanese Language Test System</h5>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus dolorem impedit eos autem
                        dolores laudantium quia, qui similique
                    </p>
                    <div class="d-flex align-items-center">
                        <i class="fa fa-share fa-2x text-white me-2"></i>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                class="fa fa-facebook-f"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                class="fa fa-twitter"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                class="fa fa-instagram"></i></a>
                        <a class="btn-square btn btn-primary text-white rounded-circle mx-1" href=""><i
                                class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h5 class="mb-4 text-white">Quick Links</h5>
                    <a href="<?php $user_base_url ."home.php"?>"><i class="fa fa-angle-right me-2"></i> Home</a>
                    <a href="<?php echo $user_base_url. "home.php#questions" ?>"><i class="fa fa-angle-right me-2"></i> Questions</a>
                    <!-- <a href=""><i class="fas fa-angle-right me-2"></i> Contact Us</a> -->
                    <a href=""><i class="fa fa-angle-right me-2"></i> Privacy Policy</a>
                    <a href=""><i class="fa fa-angle-right me-2"></i> Terms & Conditions</a>
                </div>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="footer-item d-flex flex-column">
                    <h5 class="mb-4 text-white">Contact Info</h5>
                    <a href=""><i class="fa fa-map-marker me-2"></i> 123 Street, New York, USA</a>
                    <a href=""><i class="fa fa-envelope me-2"></i> info@example.com</a>
                    <a href=""><i class="fa fa-envelope me-2"></i> info@example.com</a>
                    <a href=""><i class="fa fa-phone me-2"></i> +012 345 67890</a>
                    <a href="" class="mb-3"><i class="fa fa-print me-2"></i> +012 345 67890</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->

<!-- Copyright Start -->
<div class="container-fluid copyright py-4">
    <div class="container">
        <div class="row g-4 align-items-center">
            <div class="col-md-6 text-center text-md-start mb-md-0">
                <span class="text-white"><a href="#"><i class="fa fa-copyright text-light me-2"></i>Japanese Language Test System</a>,
                    All right reserved.</span>
            </div>
            <div class="col-md-6 text-center text-md-end text-white">
                <!--/*** This template is free as long as you keep the below author’s credit link/attribution link/backlink. ***/-->
                <!--/*** If you'd like to use the template without the below author’s credit link/attribution link/backlink, ***/-->
                <!--/*** you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". ***/-->
                Designed By <a class="border-bottom" href="#">YMK</a> Distributed By <a
                    class="border-bottom" href="#">YMK</a>
            </div>
        </div>
    </div>
</div>
<!-- Copyright End -->

<!-- Back to Top -->
<a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>


<!-- JavaScript Libraries -->
<script src="<?php echo $base_url;?>assets/common/js/jquery/jquery-3.7.1.js"></script>
<script src="<?php echo $base_url?>/assets/user/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base_url?>/assets/user/js/wow/wow.min.js"></script>
<script src="<?php echo $base_url?>/assets/user/js/easing/easing.min.js"></script>
<script src="<?php echo $base_url?>/assets/user/js/waypoints/waypoints.min.js"></script>
<script src="<?php echo $base_url?>/assets/user/js/owlcarousel/owl.carousel.min.js"></script>
<script src="<?php echo $base_url;?>assets/common/js/sweetalert/sweetalert2.all.min.js"></script>


<!-- Template Javascript -->
<script src="<?php echo $base_url?>/assets/user/js/main.js"></script>

<script>
    let base_url = "<?php echo $base_url; ?>";
   $("#logout").click(function(){
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, Logout!"
        }).then((result) => {
        if (result.isConfirmed) {
            location.href = base_url + "require/logout.php?type=user";
        }
        });
    });
</script>