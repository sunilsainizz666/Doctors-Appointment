<?php
include('header.php');
include('admin/db_connect.php');
?>
<style>
header.masthead {
    background: url(assets/img/<?php echo $_SESSION['setting_cover_img'] ?>);
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
}
.search-bar {
    margin: 40px auto 30px auto;
    max-width: 500px;
    display: flex;
    align-items: center;
}
.search-bar input[type="text"] {
    flex: 1;
    padding: 10px 15px;
    border: 1px solid #ccc;
    border-radius: 4px 0 0 4px;
    font-size: 1.1em;
}
.search-bar button {
    padding: 10px 20px;
    border: none;
    background: #007bff;
    color: #fff;
    border-radius: 0 4px 4px 0;
    font-size: 1.1em;
    cursor: pointer;
}
.doctor-list {
    margin: 0 auto;
    max-width: 900px;
    display: flex;
    flex-wrap: wrap;
    gap: 30px;
    justify-content: center;
}
.doctor-card {
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    padding: 24px 18px;
    width: 350px;
    text-align: center;
}
.doctor-card img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 50%;
    margin-bottom: 12px;
}
.doctor-card h4 {
    margin-bottom: 6px;
}
</style>
<body id="page-top">
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-10 align-self-end">
                    <h1 class="text-uppercase text-white font-weight-bold">Find a Doctor</h1>
                    <hr class="divider my-4" />
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <form class="search-bar" method="get" action="index.php">
            <input type="hidden" name="page" value="search">
            <input type="text" name="q" id="searchInput" placeholder="Search doctor by name, specialty, etc..." value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
            <button type="submit"><i class="fa fa-search"></i> Search</button>
            <button type="button" id="clearSearch" style="margin-left:8px;background:#6c757d;" class="btn btn-secondary">Clear</button>
        </form>
        <script>
            document.getElementById('clearSearch').onclick = function() {
                document.getElementById('searchInput').value = '';
                // Remove query param and reload default
                window.location.href = 'index.php?page=search';
            };
        </script>
        <div class="doctor-list mb-4">
            <?php
            // Fetch all specialties for mapping
            $specialties = [];
            $spec_res = $conn->query("SELECT id, name FROM medical_specialty");
            while($spec_row = $spec_res->fetch_assoc()) {
                $specialties[$spec_row['id']] = $spec_row['name'];
            }
            $where = '';
            $limit = 'LIMIT 2';
            $is_search = false;
            if(isset($_GET['q']) && trim($_GET['q']) != '') {
                $q = $conn->real_escape_string($_GET['q']);
                $q_lc = strtolower($q);
                $where = "WHERE (
                    LOWER(name) LIKE '%$q_lc%' OR
                    LOWER(name_pref) LIKE '%$q_lc%' OR
                    LOWER(CONCAT(name, ' ', name_pref)) LIKE '%$q_lc%' OR
                    LOWER(CONCAT('dr. ', name, ', ', name_pref)) LIKE '%$q_lc%' OR
                    REPLACE(LOWER(name), ' ', '') LIKE '%" . str_replace(' ', '', $q_lc) . "%' OR
                    LOWER(clinic_address) LIKE '%$q_lc%' OR
                    LOWER(email) LIKE '%$q_lc%' OR
                    LOWER(contact) LIKE '%$q_lc%' OR
                    specialty_ids LIKE '%$q%'
                )";
                $limit = '';
                $is_search = true;
            }
            $sql = "SELECT * FROM doctors_list $where ORDER BY id DESC $limit";
            $doctors = $conn->query($sql);
            if($doctors && $doctors->num_rows > 0) {
                while($row = $doctors->fetch_assoc()) {
                    $img = !empty($row['img_path']) ? 'assets/img/'.htmlspecialchars($row['img_path']) : 'assets/img/logo.svg';
                    // Convert specialty_ids to names
                    $spec_names = [];
                    if(!empty($row['specialty_ids'])) {
                        $ids = str_replace(['[',']',' '],'',$row['specialty_ids']);
                        $ids = explode(',', $ids);
                        foreach($ids as $id) {
                            if(isset($specialties[$id])) $spec_names[] = $specialties[$id];
                        }
                    }
                    echo '<div class="doctor-card">';
                    echo '<img src="'.$img.'" alt="Doctor">';
                    echo '<h4>'.htmlspecialchars($row['name']).'</h4>';
                    echo '<div><b>Specialization:</b> '.htmlspecialchars(implode(', ', $spec_names)).'</div>';
                    echo '<div><b>Contact:</b> '.htmlspecialchars($row['contact']).'</div>';
                    echo '<div><b>Clinic Address:</b> '.htmlspecialchars($row['clinic_address']).'</div>';
                    echo '</div>';
                }
            } else {
                echo '<div class="col-12 text-center">No doctors found.</div>';
            }
            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>
<?php $conn->close(); ?> 