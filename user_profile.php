<?php 
// User Profile Page
if (session_status() === PHP_SESSION_NONE) session_start();
if(!isset($_SESSION['login_id'])){
    echo '<div class="alert alert-danger">You must be logged in to view this page.</div>';
    return;
}
include 'admin/db_connect.php';

// Fetch doctor list
$doctor= $conn->query("SELECT * FROM doctors_list ");
while($row = $doctor->fetch_assoc()){
    $doc_arr[$row['id']] = $row;
}
// Fetch user info
$user = $conn->query("SELECT * FROM users WHERE id = ".intval($_SESSION['login_id']));
$user_info = $user->fetch_assoc();

// Fetch appointments for this user
$qry = $conn->query("SELECT * FROM appointment_list WHERE patient_id = ".intval($_SESSION['login_id'])." ORDER BY id DESC");
?>
<!-- Masthead-->
<header class="masthead" style="background: url('assets/img/<?php echo $_SESSION['setting_cover_img'] ?>'); background-repeat: no-repeat; background-size: cover; background-position: center; width: 100%;">
    <div class="container h-100">
        <div class="row h-100 align-items-center justify-content-center text-center">
            <div class="col-lg-10 align-self-end mb-4" style="background: #0000002e;">
                <h1 class="text-uppercase text-white font-weight-bold">User Profile</h1>
                <hr class="divider my-4" />
            </div>
        </div>
    </div>
</header>
<section class="page-section">
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User Profile</h4>
                    <button id="logout_btn" class="btn btn-danger btn-sm"><i class="fa fa-power-off"></i> Logout</button>
                </div>
                <div class="card-body">
                    <h5>Welcome, <?php echo htmlspecialchars($user_info['name']); ?></h5>
                    <hr>
                    <h6>Your Appointments</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Doctor</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if($qry->num_rows > 0):
                            while($row = $qry->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo date("l M d, Y h:i A",strtotime($row['schedule'])) ?></td>
                                <td><?php echo isset($doc_arr[$row['doctor_id']]) ? "DR. ".$doc_arr[$row['doctor_id']]['name'] : 'N/A'; ?></td>
                                <td>
                                    <?php if($row['status'] == 0): ?>
                                        <span class="badge badge-warning">Pending Request</span>
                                    <?php elseif($row['status'] == 1): ?>
                                        <span class="badge badge-primary">Confirmed</span>
                                    <?php elseif($row['status'] == 2): ?>
                                        <span class="badge badge-info">Rescheduled</span>
                                    <?php elseif($row['status'] == 3): ?>
                                        <span class="badge badge-success">Done</span>
                                    <?php else: ?>
                                        <span class="badge badge-secondary">Unknown</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; else: ?>
                            <tr><td colspan="3" class="text-center">No appointments found.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
<script>
// Logout confirmation
$(document).ready(function() {
    $('#logout_btn').click(function(e) {
        e.preventDefault();
        $('#delete_content').html('Are you sure you want to logout?');
        $('#confirm_modal').modal('show');
        $('#confirm').off('click').on('click', function() {
            window.location.href = 'admin/ajax.php?action=logout2';
        });
    });
});
</script> 