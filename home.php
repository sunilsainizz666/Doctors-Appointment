<?php 
include 'admin/db_connect.php'; 
?>
<style>
#portfolio .img-fluid{
    width:100%
}
.portfolio-box {
    display: block;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    text-align: center;
    padding: 15px 10px;
    transition: box-shadow 0.2s;
    height: 100%;
}
.portfolio-box:hover {
    box-shadow: 0 4px 16px rgba(0,0,0,0.12);
}
.portfolio-box-caption {
    margin-top: 10px;
}
</style>
        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 py-3 page-title">
                    	<h3 class="text-white">Welcome to <?php echo $_SESSION['setting_name']; ?></h3>
                        <hr class="divider my-4" />
                        <a class="btn btn-primary btn-xl js-scroll-trigger" href="index.php?page=doctors">Find a Doctor</a>

                    </div>
                    
                </div>
            </div>
        </header>
    <div id="portfolio" class="container mt-5">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                    <h2 class="mb-4">Medical Specialties</h2>
                    <hr class="divider">

                    </div>
                </div>
                <div class="row no-gutters justify-content-center">
                    <?php
                    $cats = $conn->query("SELECT * FROM medical_specialty order by id asc");
                    while($row=$cats->fetch_assoc()):
                    ?>
                    <div class="col-lg-2 col-md-4 col-sm-6 mb-4 d-flex align-items-stretch">
                        <a class="portfolio-box w-100" href="index.php?page=doctors&sid=<?php echo $row['id'] ?>">
                            <img class="img-fluid" src="assets/img/<?php echo $row['img_path'] ?>" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-name"><?php echo $row['name'] ?></div>
                                <div class="project-category text-white">Find Doctor</div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                    
                </div>
            </div>
        </div>
    <script>
        
        $('.view_prod').click(function(){
            uni_modal_right('Product','view_prod.php?id='+$(this).attr('data-id'))
        })
    </script>
	
<!-- Doctor List Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h2 class="mb-4">Our Doctors</h2>
            <hr class="divider">
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?php
            // Fetch specialties for badge display
            $special = $conn->query("SELECT * FROM medical_specialty");
            $ms_arr = array();
            while ($row=$special->fetch_assoc()) {
                $ms_arr[$row['id']] = $row['name'];
            }
            $cats = $conn->query("SELECT * FROM doctors_list order by id asc");
            while($row=$cats->fetch_assoc()):
            ?>
            <div class="row align-items-center mb-4">
                <div class="col-md-3">
                    <img src="assets/img/<?php echo $row['img_path'] ?>" alt="" style="max-height: 200px; max-width: 150px;">
                </div>
                <div class="col-md-6">
                    <p>Name: <b><?php echo "Dr. ".$row['name'].', '.$row['name_pref'] ?></b></p>
                    <p><small>Email: <b><?php echo $row['email'] ?></b></small></p>
                    <p><small>Clinic Address: <b><?php echo $row['clinic_address'] ?></b></small></p>
                    <p><small>Contact #: <b><?php echo $row['contact'] ?></b></small></p>
                    <p><b>Specialties:</b></p>
                    <div>
                        <?php if(!empty($row['specialty_ids'])): ?>
                        <?php 
                        foreach(explode(",", str_replace(array("[", "]"),"",$row['specialty_ids'])) as $k => $val): 
                        ?>
                        <span class="badge badge-light" style="padding: 10px"><large><b><?php echo $ms_arr[$val] ?></b></large></span>
                        <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-md-3 text-center align-self-end-sm">
                    <button class="btn-outline-primary btn mb-4 set_appointment" type="button" data-id="<?php echo $row['id'] ?>" data-name="<?php echo "Dr. ".$row['name'].', '.$row['name_pref'] ?>">Set Appointment</button>
                </div>
            </div>
            <hr class="divider" style="max-width: 60vw">
            <?php endwhile; ?>
        </div>
    </div>
</div>
<script>
$('.set_appointment').click(function(){
    if('<?php echo isset($_SESSION['login_id']) ?>' == 1)
        uni_modal("Set Appointment with "+$(this).attr('data-name'),"set_appointment.php?id="+$(this).attr('data-id'),'mid-large')
    else{
        uni_modal("Login First","login.php")
    }
});
</script>
