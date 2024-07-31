<html>


<head>
<title><?php echo $row["etkinlik_baslik"]; ?></title>


<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
}

.duyuruslider, .duyurudetay {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.duyurucard {
    margin-bottom: 20px;
    padding: 20px;
    border: 1px solid #ddd;
    background-color: #fafafa;
}

.duyurucard-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.duyurucard-header h3 {
    margin: 0;
}

.duyurucard-date, .duyurudetay-date {
    font-size: 0.9em;
    color: #888;
}

.duyurudetay h1 {
    margin-bottom: 10px;
}

.duyuru-link {
    color: #007bff;
    text-decoration: none;
}

.duyuru-link:hover {
    text-decoration: underline;
}

</style>
</head>


<body>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site";

// Bağlantıyı oluştur
$conn = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($conn->connect_error) {
    die("Bağlantı başarısız: " . $conn->connect_error);
}
?>

<?php

// Duyuru ID'sini al
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// ID ile ilgili duyuruyu sorgula
$sql = "SELECT * FROM etkinlikler WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Açıklama bulunamadı.");
}
?>
<center>
<div class="duyurudetay">
        <h1><?php echo $row["etkinlik_baslik"]; ?></h1>
        <p class="duyurudetay-date"><?php echo $row["etkinlik_date"]; ?></p>
        <hr>
        <p><?php echo $row["etkinlik_desc"]; ?></p>
    </div>

</center>




</body>






</html>