<!DOCTYPE html>
<html lang="en">
    <?php
    session_start();
    ob_start();
    include('header.php');
    include('admin/db_connect.php');

	$query = $conn->query("SELECT * FROM system_settings limit 1")->fetch_array();
	foreach ($query as $key => $value) {
		if(!is_numeric($key))
			$_SESSION['setting_'.$key] = $value;
	}
    ob_end_flush();
    ?>

    <style>
	header.masthead {
		background: url(assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
		background-repeat: no-repeat;
		background-size: cover;
		background-position: center; /* Optional: center the image */
		width: 100%;   /* Full width of the screen */
	}
	
	@media screen and (max-width: 768px) {
		header.masthead {
			height: 250px; /* Adjust height for mobile */
		}
	}
    /* Add margin to navbar icons */
    .navbar-nav .nav-link .fa {
        margin-left: 8px;
    }

    /* Highlight Contact Us section */
    footer.bg-light {
        background: linear-gradient(rgba(40,40,60,0.85), rgba(40,40,60,0.85)), url('assets/img/medical-appointment-cover.jpg') center/cover no-repeat;
        color: #fff !important;
        position: relative;
        padding-top: 60px;
        padding-bottom: 60px;
    }
    footer.bg-light h2,
    footer.bg-light .divider,
    footer.bg-light a,
    footer.bg-light .fa {
        color: #fff !important;
    }
    footer.bg-light .divider {
        border-color: #fff;
    }
</style>
    <body id="page-top">
        <!-- Navigation-->
        <div class="toast" id="alert_toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-body text-white">
        </div>
      </div>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
            <div class="container">
              <img src="assets\img\logo.svg" alt="logo ">
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto my-2 my-lg-0">
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=doctors"><i class="fa fa-user-md"></i> Doctors</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=about"><i class="fa fa-info-circle"></i> About</a></li>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=search"><i class="fa fa-search"></i> Search</a></li>
                        <?php if(isset($_SESSION['login_id'])): ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="index.php?page=user_profile"><i class="fa fa-user"></i> <?php echo "Welcome ".$_SESSION['login_name'] ?></a></li>
                      <?php else: ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="javascript:void(0)" id="login_now"><i class="fa fa-sign-in-alt"></i> Login</a></li>
                        <?php endif; ?>
                        <li class="nav-item"><a class="nav-link js-scroll-trigger" href="admin/login.php"><i class="fa fa-user-shield"></i> Admin Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>
       
        <?php 
        $page = isset($_GET['page']) ?$_GET['page'] : "home";
        include $page.'.php';
        ?>
       

<div class="modal fade" id="confirm_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title">Confirmation</h5>
      </div>
      <div class="modal-body">
        <div id="delete_content"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='confirm' onclick="">Continue</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal" role='dialog'>
    <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="uni_modal_right" role='dialog'>
    <div class="modal-dialog modal-full-height  modal-md" role="document">
      <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="fa fa-arrow-righ t"></span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      </div>
    </div>
  </div>
        <footer class="bg-light py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <h2 class="mt-0">Contact us</h2>
                        <hr class="divider my-4" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 ml-auto text-center mb-5 mb-lg-0">
                        <i class="fas fa-phone fa-3x mb-3 text-muted"></i>
                        <div><?php echo $_SESSION['setting_contact'] ?></div>
                    </div>
                    <div class="col-lg-4 mr-auto text-center">
                        <i class="fas fa-envelope fa-3x mb-3 text-muted"></i>
                        <!-- Make sure to change the email address in BOTH the anchor text and the link target below!-->
                        <a class="d-block" href="mailto:<?php echo $_SESSION['setting_email'] ?>"><?php echo $_SESSION['setting_email'] ?></a>
                    </div>
                </div>
            </div>
            <br>
            
        </footer>
        
       <?php include('footer.php') ?>
    </body>

    <?php
    if (isset($conn) && $conn instanceof mysqli) {
        // Try to close only if not already closed
        try {
            @$conn->close();
        } catch (Throwable $e) {
            // Ignore if already closed
        }
    }
    ?>

</html>
