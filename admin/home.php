<?php
include 'db_connect.php';
// Total Users (excluding admin and staff)
$total_users = $conn->query("SELECT COUNT(*) as cnt FROM users WHERE type = 3")->fetch_assoc()['cnt'];
// Total Doctors
$total_doctors = $conn->query("SELECT COUNT(*) as cnt FROM doctors_list")->fetch_assoc()['cnt'];
// Total Appointments
$total_appointments = $conn->query("SELECT COUNT(*) as cnt FROM appointment_list")->fetch_assoc()['cnt'];
?>

<style>
   
</style>

<div class="container-fluid">
	<div class="row mt-4">
		<div class="col-md-4 mb-3">
			<div class="card text-white bg-primary h-100">
				<div class="card-body d-flex align-items-center">
					<i class="fa fa-users fa-3x mr-3"></i>
					<div>
						<h5 class="card-title mb-0">Total Users</h5>
						<h2 class="mb-0"><?php echo $total_users; ?></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<div class="card text-white bg-success h-100">
				<div class="card-body d-flex align-items-center">
					<i class="fa fa-user-md fa-3x mr-3"></i>
					<div>
						<h5 class="card-title mb-0">Total Doctors</h5>
						<h2 class="mb-0"><?php echo $total_doctors; ?></h2>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 mb-3">
			<div class="card text-white bg-info h-100">
				<div class="card-body d-flex align-items-center">
					<i class="fa fa-calendar fa-3x mr-3"></i>
					<div>
						<h5 class="card-title mb-0">Total Appointments</h5>
						<h2 class="mb-0"><?php echo $total_appointments; ?></h2>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Chart Section -->
	<div class="row mb-4">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">System Overview</h5>
					<canvas id="overviewChart" height="80"></canvas>
				</div>
			</div>
		</div>
	</div>


</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('overviewChart').getContext('2d');
const overviewChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Users', 'Doctors', 'Appointments'],
        datasets: [{
            label: 'Total',
            data: [<?php echo $total_users; ?>, <?php echo $total_doctors; ?>, <?php echo $total_appointments; ?>],
            backgroundColor: [
                'rgba(0, 123, 255, 0.7)',
                'rgba(40, 167, 69, 0.7)',
                'rgba(23, 162, 184, 0.7)'
            ],
            borderColor: [
                'rgba(0, 123, 255, 1)',
                'rgba(40, 167, 69, 1)',
                'rgba(23, 162, 184, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                precision: 0
            }
        }
    }
});
</script>