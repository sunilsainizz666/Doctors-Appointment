<style>
	.logo {
    font-size: 24px;
    background: white;
    padding: 7px 11px;
    border-radius: 50%;
    color: #007bff;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 48px;
    width: 48px;
}
    .system-title {
        font-size: 1.5rem;
        font-weight: bold;
        letter-spacing: 1px;
    }
    .logout-btn {
        background: #dc3545;
        color: #fff !important;
        border: none;
        border-radius: 25px;
        padding: 8px 20px;
        font-size: 1rem;
        display: flex;
        align-items: center;
        transition: background 0.2s;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
    }
    .logout-btn:hover {
        background: #c82333;
        color: #fff !important;
        text-decoration: none;
    }
</style>

<nav class="navbar navbar-light fixed-top" style="padding:0;background: #00000575 !important">
  <div class="container-fluid mt-2 mb-2">
    <div class="d-flex w-100 align-items-center justify-content-between">
      <div class="d-flex align-items-center">
        <div class="logo mr-3">
          <span class="fa fa-laptop-medical"></span>
        </div>
        <span class="text-white system-title ml-2">Doctor's Appointment System</span>
      </div>
      <div class="d-flex align-items-center">
        <span class="text-white mr-3 d-none d-md-inline">Welcome, <?php echo $_SESSION['login_name']; ?></span>
        <a href="#" id="logoutBtn" class="logout-btn"><i class="fa fa-power-off mr-2"></i> Logout</a>
      </div>
    </div>
  </div>
</nav>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    var logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        if (typeof window._conf === 'function') {
          window._conf('Are you sure you want to logout?', 'logout_now', []);
        }
      });
    }
  });
  function logout_now() {
    window.location.href = 'ajax.php?action=logout';
  }
</script>