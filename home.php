<?php 
include 'admin/db_connect.php'; 
?>
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center justify-content-center text-center" style="min-height: 60vh; background: linear-gradient(rgba(25, 118, 210, 0.7), rgba(25, 118, 210, 0.5)), url('assets/img/medical-appointment-cover.jpg') center/cover no-repeat;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 align-self-end mb-4 py-4 page-title bg-white bg-opacity-75 rounded-3 shadow-lg animate__animated animate__fadeInDown">
                <h1 class="display-4 fw-bold text-primary mb-3">Welcome to <?php echo $_SESSION['setting_name']; ?></h1>
                <p class="lead text-dark mb-4">Book appointments with top doctors, explore specialties, and manage your health easily.</p>
                <a class="btn btn-primary btn-xl px-5 py-3 shadow animate__animated animate__pulse animate__infinite" href="index.php?page=doctors">Find a Doctor</a>
            </div>
        </div>
    </div>
</section>

<!-- Medical Specialties Section -->
<section id="portfolio" class="container-fluid py-5" style="background: linear-gradient(120deg, #e3f0ff 0%, #f8fbff 100%);">
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="fw-bold text-primary mb-3">Medical Specialties</h2>
            <hr class="divider mx-auto mb-4" style="width: 60px;">
            <p class="text-muted mb-0">Explore our wide range of specialties and find the right doctor for your needs.</p>
        </div>
    </div>
    <div class="row g-4 justify-content-center">
        <?php
        $cats = $conn->query("SELECT * FROM medical_specialty order by id asc");
        while($row=$cats->fetch_assoc()):
        ?>
        <div class="col-6 col-sm-4 col-md-3 col-lg-2 d-flex align-items-stretch">
            <a class="portfolio-box w-100 text-decoration-none" href="index.php?page=doctors&sid=<?php echo $row['id'] ?>">
                <div class="card h-100 border-0 shadow specialty-card animate__animated animate__zoomIn">
                    <div class="specialty-img-wrapper mx-auto mt-3 mb-2">
                        <img class="specialty-img" src="assets/img/<?php echo $row['img_path'] ?>" alt="<?php echo $row['name'] ?>">
                    </div>
                    <div class="card-body p-2 text-center">
                        <div class="project-name fw-bold text-primary mb-1" style="font-size: 1.1rem;"><?php echo $row['name'] ?></div>
                        <div class="project-category text-secondary small mb-2">Find Doctor</div>
                        <div class="specialty-desc text-muted small">Specialized care for your health and well-being.</div>
                    </div>
                </div>
            </a>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-us-section py-5 bg-light">
    <div class="container">
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="fw-bold text-primary mb-3">Why Choose Us?</h2>
                <hr class="divider mx-auto mb-4" style="width: 60px;">
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center animate__animated animate__fadeInUp">
                    <div class="card-body">
                        <i class="fa fa-user-md fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Expert Doctors</h5>
                        <p class="card-text">Our platform connects you with highly qualified and experienced medical professionals.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center animate__animated animate__fadeInUp animate__delay-1s">
                    <div class="card-body">
                        <i class="fa fa-calendar-check fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Easy Appointments</h5>
                        <p class="card-text">Book, reschedule, or cancel appointments with just a few clicks, anytime, anywhere.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 shadow-sm text-center animate__animated animate__fadeInUp animate__delay-2s">
                    <div class="card-body">
                        <i class="fa fa-shield-alt fa-3x text-primary mb-3"></i>
                        <h5 class="card-title fw-bold">Secure & Private</h5>
                        <p class="card-text">Your health data is protected with top-level security and privacy standards.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Add Animate.css for animations if not already included -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

<style>
.hero-section {
    background-size: cover;
    background-position: center;
    min-height: 60vh;
    position: relative;
    margin-top: 90px;
}
.hero-section .page-title {
    background: rgba(255,255,255,0.85);
    border-radius: 18px;
    box-shadow: 0 4px 24px rgba(25,118,210,0.10);
}
@media (max-width: 767.98px) {
    .hero-section .page-title {
        padding: 1.5rem 0.5rem;
    }
    .hero-section h1 {
        font-size: 2rem;
    }
}
.why-us-section .card {
    transition: transform 0.2s, box-shadow 0.2s;
}
.why-us-section .card:hover {
    transform: translateY(-8px) scale(1.03);
    box-shadow: 0 8px 32px rgba(25,118,210,0.15);
}
#portfolio {
    background: linear-gradient(120deg, #e3f0ff 0%, #f8fbff 100%);
}
.specialty-card {
    border-radius: 18px;
    box-shadow: 0 2px 12px rgba(25,118,210,0.08);
    transition: box-shadow 0.25s, transform 0.22s;
    background: #fff;
    position: relative;
    overflow: hidden;
}
.specialty-card:hover {
    box-shadow: 0 8px 32px rgba(25,118,210,0.18), 0 1.5px 6px rgba(0,123,255,0.10);
    transform: translateY(-8px) scale(1.05);
    z-index: 2;
}
.specialty-img-wrapper {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: linear-gradient(135deg, #e3f0ff 60%, #badaf7 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(25,118,210,0.10);
    border: 3px solid #fff;
    margin-bottom: 0.5rem;
}
.specialty-img {
    width: 68px;
    height: 68px;
    object-fit: cover;
    border-radius: 50%;
    border: 2px solid #badaf7;
    box-shadow: 0 1px 4px rgba(25,118,210,0.10);
    background: #f8fbff;
}
.specialty-desc {
    min-height: 36px;
    color: #6c757d;
    font-size: 0.93rem;
}
@media (max-width: 575.98px) {
    #portfolio .col-6 {
        max-width: 50%;
        flex: 0 0 50%;
    }
    .specialty-img-wrapper {
        width: 60px;
        height: 60px;
    }
    .specialty-img {
        width: 48px;
        height: 48px;
    }
}
</style>
	