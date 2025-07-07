<?php include 'admin/db_connect.php'; 

	$special = $conn->query("SELECT * FROM medical_specialty");
	$ms_arr = array();
	while ($row=$special->fetch_assoc()) {
		$ms_arr[$row['id']] = $row['name'];
	}


?>
        <header class="masthead" style="background: linear-gradient(rgba(34,34,34,0.7), rgba(34,34,34,0.7)), url('assets/img/medical-appointment-cover.jpg') center/cover no-repeat; min-height: 300px;">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                        <h3 class="text-white display-4 font-weight-bold" style="text-shadow: 2px 2px 8px #000;">Doctor's</h3>
                        <hr class="divider my-4" style="border-top: 2px solid #fff; width: 80px; margin: 0 auto;" />
                    </div>
                </div>
            </div>
        </header>
    <section class="page-section" id="doctors" >
        <div class="container">
            <!-- Doctor Search Bar -->
            <div class="row mb-4">
                <div class="col-md-8 mx-auto">
                    <div class="input-group">
                        <input type="text" id="doctor-search" class="form-control" placeholder="Search doctor by name...">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="doctor-search-btn" type="button"><i class="fa fa-search"></i> Search</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow-lg border-0 mb-5">
                <div class="card-body bg-light">
                    <div class="col-lg-12">
                        <?php if(isset($_GET['sid']) && $_GET['sid'] > 0): ?>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <?php
                                $s = $conn->query("SELECT * from medical_specialty where id = ".$_GET['sid'])->fetch_array()['name'];
                                ?>
                                <h2 class="mb-3"><b>Doctor/s who are entitled as <span class="text-primary"><?php echo $s ?></span></b></h2>
                            </div>
                        </div>
                        <hr class="divider">
                        <?php endif; ?>
                <?php 
                $where = "";
                if(isset($_GET['sid']) && $_GET['sid'] > 0)
                $where = " where  (REPLACE(REPLACE(REPLACE(specialty_ids,',','\",\"'),'[','[\"'),']','\"]')) LIKE '%\"".$_GET['sid']."\"%' ";
                $cats = $conn->query("SELECT * FROM doctors_list ".$where." order by id asc");
                if($cats->num_rows == 0): ?>
                    <div class="alert alert-warning text-center">No doctors found for this specialty.</div>
                <?php endif; ?>
                <div class="row" id="doctor-list">
                <?php while($row=$cats->fetch_assoc()): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card doctor-card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="text-center mb-3">
                                <img src="assets/img/<?php echo $row['img_path'] ?>" alt="Doctor Image" class="doctor-img rounded-circle border border-primary mb-2">
                            </div>
                            <h5 class="card-title text-center font-weight-bold mb-1">Dr. <?php echo $row['name'].', '.$row['name_pref'] ?></h5>
                            <p class="text-center text-muted mb-2" style="font-size: 0.95rem;"><i class="fa fa-envelope mr-1"></i> <?php echo $row['email'] ?></p>
                            <p class="mb-1"><i class="fa fa-map-marker-alt mr-1 text-primary"></i> <b>Clinic:</b> <?php echo $row['clinic_address'] ?></p>
                            <p class="mb-1"><i class="fa fa-phone mr-1 text-primary"></i> <b>Contact:</b> <?php echo $row['contact'] ?></p>
                            <div class="mb-2">
                                <b>Specialties:</b><br>
                                <?php if(!empty($row['specialty_ids'])): ?>
                                    <?php foreach(explode(",", str_replace(array("[","]"),"",$row['specialty_ids'])) as $k => $val): ?>
                                        <span class="badge badge-pill badge-info specialty-badge mb-1 mr-1"><?php echo $ms_arr[$val] ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto text-center">
                                <a href="javascript:void(0)" class="btn btn-outline-primary btn-sm view_schedule mb-2 w-100" data-id="<?php echo $row['id'] ?>" data-name="<?php echo 'Dr. '.$row['name'].', '.$row['name_pref'] ?>"><i class='fa fa-calendar'></i> View Schedule</a>
                                <button class="btn btn-primary btn-sm set_appointment w-100" type="button" data-id="<?php echo $row['id'] ?>"  data-name="<?php echo 'Dr. '.$row['name'].', '.$row['name_pref'] ?>">Set Appointment</button>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
                </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <style>
        .doctor-card {
            transition: box-shadow 0.3s, transform 0.3s;
            border-radius: 1rem;
            background: #fff;
        }
        .doctor-card:hover {
            box-shadow: 0 8px 32px rgba(0,0,0,0.18), 0 1.5px 6px rgba(0,123,255,0.12);
            transform: translateY(-6px) scale(1.03);
        }
        .doctor-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12);
        }
        .specialty-badge {
            font-size: 0.95rem;
            padding: 0.5em 1em;
            background: linear-gradient(90deg, #17a2b8 60%, #007bff 100%);
            color: #fff;
            box-shadow: 0 1px 4px rgba(23,162,184,0.12);
        }
        .btn-primary, .btn-outline-primary {
            border-radius: 2rem;
            font-weight: 500;
            letter-spacing: 0.03em;
        }
        .btn-primary {
            background: linear-gradient(90deg, #007bff 60%, #17a2b8 100%);
            border: none;
        }
        .btn-primary:hover, .btn-outline-primary:hover {
            background: linear-gradient(90deg, #17a2b8 60%, #007bff 100%);
            color: #fff;
        }
        @media (max-width: 767px) {
            .doctor-img {
                width: 90px;
                height: 90px;
            }
            .doctor-card {
                margin-bottom: 1.5rem;
            }
        }
    </style>
    <script>
        // Doctor search functionality
        function filterDoctors() {
            var search = $('#doctor-search').val().toLowerCase().trim();
            $('#doctor-list .doctor-card').each(function() {
                var name = $(this).find('.card-title').text().toLowerCase();
                if (name.indexOf(search) !== -1) {
                    $(this).closest('.col-md-6, .col-lg-4').show();
                } else {
                    $(this).closest('.col-md-6, .col-lg-4').hide();
                }
            });
        }
        $('#doctor-search').on('input', filterDoctors);
        $('#doctor-search-btn').on('click', filterDoctors);
        $('#doctor-search').on('keypress', function(e) {
            if (e.which === 13) filterDoctors();
        });
        $('.view_schedule').click(function(){
            uni_modal($(this).attr('data-name')+" - Schedule","view_doctor_schedule.php?id="+$(this).attr('data-id'))
        })
        $('.set_appointment').click(function(){
            if('<?php echo isset($_SESSION['login_id']) ?>' == 1)
                uni_modal("Set Appointment with "+$(this).attr('data-name'),"set_appointment.php?id="+$(this).attr('data-id'),'mid-large')
            else{
                uni_modal("Login First","login.php")
            }
        })
    </script>
	
