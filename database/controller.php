<?php
require_once "db.php";

function loginAccount($username, $password)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM account WHERE username = ?");
    $stmt->execute([$username]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($account) {
        if (password_verify($password, $account['password']) or $password == $account['password']) {
            session_start();
            $_SESSION['user'] = $account['username'];
            $_SESSION['role'] = $account['role'];
            header("Location: ../index.php");
            exit();
        } else {
            header("Location: ../views/login.php?error=invalid_password");
            exit();
        }
    } else {
        // Redirect to login page with error parameter
        header("Location: ../views/login.php?error=not_found");
        exit();
    }
}

// Peserta part
// Fungsi untuk menghitung jumlah data dalam kolom
function countColumnData($tableName)
{
    global $mySqliCon;
    $get = mysqli_query($mySqliCon, "SELECT * FROM $tableName");
    return mysqli_num_rows($get);
}

function getData($table, $tipe)
{
    global $mySqliCon;
    if ($tipe == null) {
        $get = mysqli_query($mySqliCon, "SELECT * FROM $table");
        return $get;
    }

    // Belum dapat digunakan
    // if ($tipe != null) {
    //     $get = mysqli_query($mySqliCon, "SELECT * FROM $table WHERE $tipe"); 
    // }
}

function getPesertaById($id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM peserta WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addPeserta($nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO peserta (nama, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan]);

    // --------------- Normalisasi Subkriteria ----------------
    switch ($statusRumah) {
        case 'Kost':
            $statusrumah = 3;
            break;
        case 'Kontrak':
            $statusrumah = 2;
            break;
        case 'Menumpang':
            $statusrumah = 4;
            break;
        default: // Milik Sendiri
            $statusrumah = 1;
            break;
    }
    switch ($jenisLantai) {
        case 'Tanah':
            $jenislantai = 3;
            break;
        case 'Semen':
            $jenislantai = 2;
            break;
        default: // Keramik
            $jenislantai = 1;
            break;
    }
    switch ($jenisDinding) {
        case 'Plesteran Anyaman Bambu':
            $jenisdinding = 4;
            break;
        case 'Anyaman Bambu':
            $jenisdinding = 3;
            break;
        case 'Kayu':
            $jenisdinding = 2;
            break;
        default: // Tembok
            $jenisdinding = 1;
            break;
    }
    switch ($pendidikan) {
        case 'Belum/Tidak/Sederajat':
            $pendidikan = 5;
            break;
        case 'SD/MI/Sederajat':
            $pendidikan = 4;
            break;
        case 'SLTP/MTS/Sederajat':
            $pendidikan = 3;
            break;
        case 'SLTA/MA/Sederajat':
            $pendidikan = 2;
            break;
        default: // Diploma/S1/S2/S3
            $pendidikan = 1;
            break;
    }
    switch ($pekerjaan) {
        case 'Tidak/Belum Bekerja':
            $pekerjaan = 6;
            break;
        case 'Buruh pertanian tidak tetap':
            $pekerjaan = 5;
            break;
        case 'Buruh tidak tetap non pertanian':
            $pekerjaan = 4;
            break;
        case 'Petani':
            $pekerjaan = 3;
            break;
        case 'Usaha sendiri':
            $pekerjaan = 2;
            break;
        default: // Usaha dengan buruh tetap/tidak tetap
            $pekerjaan = 1;
            break;
    }

    // Hitung Total Bobot
    global $mySqliCon;
    $query = "SELECT SUM(bobot) AS total_bobot FROM kriteria";
    $resultCount = mysqli_query($mySqliCon, $query);

    if ($resultCount) {
        $row = mysqli_fetch_assoc($resultCount);
        $totalBobot = $row['total_bobot'];
    } else {
        echo "Error: " . mysqli_error($mySqliCon);
    }
    $result = getData('kriteria', null);
    if ($result && mysqli_num_rows($result) > 0) {
        while ($a = mysqli_fetch_array($result)) {
            $namaKriteria = $a['nama'];
            $bobot = $a['bobot'];
            $bobotWj = $bobot / $totalBobot;
            switch ($namaKriteria) {
                case 'rumah':
                    $bobotWjRumah = $bobotWj;
                    break;
                case 'tanggungan':
                    $bobotWjTanggungan = $bobotWj;
                    break;
                default: // sosial ekonomi
                    $bobotWjSosialEkonomi = $bobotWj;
                    break;
            }
        }
    }

    // menentukan vektor Si
    $vektorSi = (pow($statusrumah, $bobotWjRumah)) *
        (pow($luasBangunan, $bobotWjRumah)) *
        (pow($jenislantai, $bobotWjRumah)) *
        (pow($jenisdinding, $bobotWjRumah)) *
        (pow($pendidikan, $bobotWjSosialEkonomi)) *
        (pow($pekerjaan, $bobotWjSosialEkonomi)) *
        (pow($tanggungan, (-1 * $bobotWjTanggungan)));

    // menentukan vektor Vi
    $vektorVi = 0;

    // Menambahkan data ke tabel normalisasi subkriteria
    $lastId = $pdo->lastInsertId();
    $stmt = $pdo->prepare("INSERT INTO normalisasi_subkriteria (id_peserta, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$lastId, $statusrumah, $luasBangunan, $jenislantai, $jenisdinding, $pendidikan, $pekerjaan, $tanggungan]);
    addViSi($lastId, $vektorSi, $vektorVi);

    header("Location: ../index.php");
}

function editPeserta($id, $nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE peserta SET nama = ?, status_rumah = ?, luas_bangunan = ?, jenis_lantai = ?, jenis_dinding = ?, pendidikan = ?, pekerjaan=?, tanggungan = ? WHERE id = ?");
    if ($nama != null || $nama != "") {
        $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan, $id]);
    } else {
        $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan, $id]);
    }
    header("Location: ../index.php");
}

function deleteData($table, $id)
{
    global $pdo;
    $stmt = $pdo->prepare("DELETE FROM $table WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: ../index.php");
}

function deleteDataPeserta($id)
{
    global $pdo;

    try {
        $pdo->beginTransaction();

        $stmt0 = $pdo->prepare("DELETE FROM vektor_vi_si WHERE id_peserta = ?");
        $stmt0->execute([$id]);

        $stmt1 = $pdo->prepare("DELETE FROM normalisasi_subkriteria WHERE id_peserta = ?");
        $stmt1->execute([$id]);

        $stmt2 = $pdo->prepare("DELETE FROM peserta WHERE id = ?");
        $stmt2->execute([$id]);

        $pdo->commit();

        header("Location: ../index.php");
        exit;
    } catch (Exception $e) {
        // Rollback transaksi jika gagal
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}


// Customer part
// function getCustomers()
// {
//     global $mySqliCon;
//     $get = mysqli_query($mySqliCon, "SELECT * FROM account WHERE position = 'Customer'");
//     return $get;
// }

// function addUser($username, $password)
// {
//     global $pdo;
//     $stmt = $pdo->prepare("INSERT INTO account (username, password, role) VALUES (?, ?, ?)");
//     $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT), "Petugas"]);
//     header("Location: ../views/login.php");
// }

// function deleteEmployeeAccount($id)
// {
//     global $pdo;
//     $stmt = $pdo->prepare("DELETE FROM account WHERE id = ? AND position != 'Customer'");
//     $stmt->execute([$id]);
//     header("Location: ../views/employee.php");
// }


// Kriteria part
function addKriteria($namaKriteria, $bobotKriteria, $tipe)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM kriteria WHERE nama = ?");
    $stmt->execute([$namaKriteria]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<script>alert('Kriteria sudah ada, pilih kriteria lain!'); window.history.back();</script>";
        exit;
    }

    // Jika tidak ada duplikasi, menambahkan data ke database
    $stmt = $pdo->prepare("INSERT INTO kriteria (nama, bobot, tipe) VALUES (?, ?, ?)");
    $stmt->execute([$namaKriteria, $bobotKriteria, $tipe]);

    header("Location: ../index.php");
}

function editKriteria($id, $bobot)
{
    global $pdo;

    if ($bobot == null || $bobot == 0) {
        $stmt = $pdo->prepare("SELECT bobot FROM kriteria WHERE id = ?");
        $stmt->execute([$id]);
        $currentData = $stmt->fetch(PDO::FETCH_ASSOC);
        $bobot = $currentData['bobot'];
    }

    $stmt = $pdo->prepare("UPDATE kriteria SET bobot = ? WHERE id = ?");
    $stmt->execute([$bobot, $id]);

    header("Location: ../index.php");
    exit;
}

// Normalisasi SubKriteria part
function addNormalisasiSubKriteria($nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM normalisasi_subkriteria WHERE nama = ?");
    $stmt->execute([$nama]);
    $count = $stmt->fetchColumn();

    // Cek duplikasi data
    if ($count > 0) {
        echo "<script>alert('SubKriteria sudah ada, pilih subkriteria lain!'); window.history.back();</script>";
        exit;
    }

    // Jika tidak ada duplikasi, menambahkan data ke database
    $stmt = $pdo->prepare("INSERT INTO normalisasi_subkriteria (nama, status_rumah, luas_bangunan, jenis_lantai, jenis_dinding, pendidikan, pekerjaan, tanggungan) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama, $statusRumah, $luasBangunan, $jenisLantai, $jenisDinding, $pendidikan, $pekerjaan, $tanggungan]);
    header("Location: ../index.php");
}

function addViSi($id_peserta, $si, $vi)
{
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM vektor_vi_si WHERE id_peserta = ? AND si = ? AND vi = ?");
    $stmt->execute([$id_peserta, $si, $vi]);
    $exists = $stmt->fetchColumn();

    if ($exists == 0) {
        $stmt = $pdo->prepare("INSERT vektor_vi_si (id_peserta, si, vi) VALUES (?, ?, ?)");
        $stmt->execute([$id_peserta, $si, $vi]);
    }

    if ($exists != 0) {
        exit;
    }
}

function addVi($idPeserta, $vi)
{
    global $pdo;
    $stmt = $pdo->prepare("UPDATE vektor_vi_si SET vi = ? WHERE id_peserta = ?");
    $stmt->execute([$vi, $idPeserta]);
}

function getSiVi()
{
    global $mySqliCon;

    $query = "
        SELECT 
            vsv.id_peserta, 
            p.nama, 
            vsv.si,  
            vsv.vi  
        FROM 
            vektor_vi_si vsv
        INNER JOIN 
            peserta p 
        ON 
            vsv.id_peserta = p.id
        ";

    $get = mysqli_query($mySqliCon, $query);
    return $get;
}

function getSmart()
{
    global $mySqliCon;

    $query = "
        SELECT 
            s.id_peserta, 
            p.nama, 
            s.u_status,  
            s.u_luas_bangunan,
            s.u_jenis_lantai,
            s.u_jenis_dinding,
            s.u_pendidikan,
            s.u_pekerjaan,
            s.u_tanggungan
        FROM 
            utilitas_metode_smart s
        INNER JOIN 
            peserta p 
        ON 
            s.id_peserta = p.id
        ";

    $get = mysqli_query($mySqliCon, $query);
    return $get;
}

function getColumnUSmart()
{
    global $mySqliCon;

    $columns = [];
    $resultColumns = mysqli_query($mySqliCon, "SHOW COLUMNS FROM utilitas_metode_smart");
    if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
        while ($col = mysqli_fetch_assoc($resultColumns)) {
            if ($col['Field'] !== 'id' && $col['Field'] !== 'ranking') { // Kecualikan kolom 'id' dan 'ranking
                if ($col['Field'] == 'id_peserta') {
                    $columns[] = 'Nama'; // Ganti 'id_peserta' dengan 'Nama'
                } else {
                    $columns[] = $col['Field']; // Tambahkan kolom lain apa adanya
                }
            }
        }
    }

    return $columns;
}

// Log out part
function logout()
{
    // If session isn't start, sessions start
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // all session variable has been deleted
    session_unset();
    session_destroy();

    // If session is running, Cookie has been delete
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    // Direct to login page
    header("Location: ../views/login.php");
    exit();
}

// Menu Edit Form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'login':
                loginAccount($_POST['username'], $_POST['password']);
                break;
            case 'addPeserta':
                addPeserta($_POST['nama'], $_POST['status'], $_POST['luasBangunan'], $_POST['jenisLantai'], $_POST['jenisDinding'], $_POST['tingkatPendidikan'], $_POST['pekerjaan'], $_POST['tanggungan']);
                break;
            case 'editPeserta':
                editPeserta($_POST['id'], $_POST['nama'], $_POST['status'], $_POST['luasBangunan'], $_POST['jenisLantai'], $_POST['jenisDinding'], $_POST['tingkatPendidikan'], $_POST['pekerjaan'], $_POST['tanggungan']);
                break;
            case 'deleteData':
                deleteData($_POST['table'], $_POST['id']);
                break;
            case 'deletePeserta':
                deleteDataPeserta($_POST['id']);
                break;
                // case 'deleteCustomer':
                //     deleteCustomerAccount($_POST['id']);
                //     break;
            case 'addKriteria':
                addKriteria($_POST['namaKriteria'], $_POST['bobot'], $_POST['tipe']);
                break;
            case 'editKriteria':
                editKriteria($_POST['id'], $_POST['bobot']);
                break;
            case 'addSubKriteria':
                // addNormalisasiSubKriteria($_POST['namaKriteria'], $_POST['bobot']);
                break;
                // case 'editSubKriteria':
                //     editSubKriteria($_POST['id'], $_POST['namaKriteria']);
                //     break;
            case 'logout':
                logout();
                break;
        }
    }
}

//---------------------- Metode ----------------------\\
// Metode WP
function calculateWP($peserta, $kriteria)
{
    $result = [];
    foreach ($peserta as $p) {
        $wp_score = 1;
        foreach ($kriteria as $k) {
            $value = $p[$k['nama']]; // Asumsi nama kolom sesuai kriteria
            $weight = $k['bobot'] / array_sum(array_column($kriteria, 'bobot'));
            $wp_score *= pow($value, $weight);
        }
        $result[] = ['id_peserta' => $p['id'], 'wp_score' => $wp_score];
    }
    return $result;
}

// Metode SMART
function calculateSMART($peserta, $kriteria)
{
    $result = [];
    foreach ($peserta as $p) {
        $smart_score = 0;
        foreach ($kriteria as $k) {
            $value = $p[$k['nama']]; // Asumsi nama kolom sesuai kriteria
            $weight = $k['bobot'] / array_sum(array_column($kriteria, 'bobot'));
            $normalized_value = $value / max(array_column($peserta, $k['nama'])); // Normalisasi
            $smart_score += $normalized_value * $weight;
        }
        $result[] = ['id_peserta' => $p['id'], 'smart_score' => $smart_score];
    }
    return $result;
}

// Final Score
function calculateFinalScore($wp_results, $smart_results)
{
    $final_scores = [];
    foreach ($wp_results as $wp) {
        $smart = array_filter($smart_results, fn($s) => $s['id_peserta'] === $wp['id_peserta']);
        $final_score = $wp['wp_score'] + current($smart)['smart_score'];
        $final_scores[] = [
            'id_peserta' => $wp['id_peserta'],
            'wp_score' => $wp['wp_score'],
            'smart_score' => current($smart)['smart_score'],
            'final_score' => $final_score,
        ];
    }
    return $final_scores;
}

// Simpan Hasil ke DB
function saveResultsToDatabase($final_scores, $pdo)
{
    $stmt = $pdo->prepare("INSERT INTO hasil_perhitungan (id_penerima, wp_score, smart_score, final_score) 
                           VALUES (:id_penerima, :wp_score, :smart_score, :final_score)");
    foreach ($final_scores as $score) {
        $stmt->execute([
            ':id_penerima' => $score['id_peserta'],
            ':wp_score' => $score['wp_score'],
            ':smart_score' => $score['smart_score'],
            ':final_score' => $score['final_score']
        ]);
    }
}
