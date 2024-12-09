<?php
// Aktifkan error reporting untuk menampilkan pesan error
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Informasi koneksi ke database
$servername = "localhost";
$username = "root"; // username default di XAMPP/WAMP
$password = "123"; // password kosong secara default di XAMPP
$dbname = "ses"; // Ganti dengan nama database yang Anda buat

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    // Jika terjadi error, tampilkan pesan error
    die("Koneksi gagal: " . $conn->connect_error);
} else {
    // Jika koneksi berhasil
    echo "Koneksi ke database '$dbname' berhasil!";
}

// Tutup koneksi setelah selesai
$conn->close();

$client->setRedirectUri('http://localhost/Sustain-Energy-Solution-main/callback.php');

<?php
// Load Composer's autoloader
require_once 'vendor/autoload.php';

// Setup Google Client
$client = new Google_Client();
$client->setClientId('1084069754802-37nq93lnp9odkc86dhbfv7o2q5prjjq6.apps.googleusercontent.com');  // Ganti dengan Client ID Anda
$client->setClientSecret('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');  // Ganti dengan Client Secret Anda
$client->setRedirectUri('http://localhost/Sustain-Energy-Solution-main/callback.php');  // Ganti dengan URL callback Anda
$client->addScope(Google_Service_Oauth2::USERINFO_PROFILE);
$client->addScope(Google_Service_Oauth2::USERINFO_EMAIL);

// Cek apakah ada parameter "code" di URL, yang menandakan pengguna telah login
if (isset($_GET['code'])) {
    // Tukar kode dengan token akses
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    // Dapatkan informasi profil pengguna
    $oauth = new Google_Service_Oauth2($client);
    $user = $oauth->userinfo->get();

    // Tampilkan informasi pengguna
    echo 'Nama: ' . $user->name . '<br>';
    echo 'Email: ' . $user->email . '<br>';
    echo 'Foto Profil: <img src="' . $user->picture . '" /><br>';

    // Simpan data pengguna ke database jika diperlukan (misalnya, ke tabel users)
    // Simpan data $user->name, $user->email, dll ke database MySQL Anda.

    // Redirect setelah sukses login
    header('Location: index.php'); // Redirect ke halaman utama setelah login
    exit();
} else {
    // Jika tidak ada kode, buat URL untuk login
    $authUrl = $client->createAuthUrl();
    echo "<a href='" . $authUrl . "'>Login dengan Google</a>";
}
?>

?>

