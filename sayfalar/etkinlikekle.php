<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>etkinlik ekle</title>
    <style>
table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #dddddd;
            padding: 8px;
            text-align: left;
            background-color: white;
        }

        th {
            background-color: #f2f2f2;
        }

        .delete-button {
            background-color: #f44336;
            border: none;
            color: white;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }





</style>
</head>
<body>
    
<?php
    // Veritabanı bağlantısı için bilgiler
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "site";
    
    // Veritabanına bağlan
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Bağlantıyı kontrol et
    if ($conn->connect_error) {
        die("Veritabanı bağlantısı başarısız: " . $conn->connect_error);
    }
    
    if(isset($_POST['etkinlik_baslik'])) {
        // Formdan gelen verileri al
        $etkinlik_baslik = $_POST['etkinlik_baslik'];
        $etkinlik_link = $_POST['etkinlik_link'];
        $etkinlik_date = $_POST['etkinlik_date'];
        $etkinlik_desc = $_POST['etkinlik_desc'];
        
        // SQL sorgusu oluştur
        $sql = "INSERT INTO etkinlikler (etkinlik_baslik, etkinlik_link, etkinlik_date, etkinlik_desc) 
                VALUES ('$etkinlik_baslik', '$etkinlik_link', '$etkinlik_date', '$etkinlik_desc')";
    
        // Sorguyu çalıştır ve sonucu kontrol et
        if ($conn->query($sql) === TRUE) {
            echo "Yeni etkinlik başarıyla eklendi.";
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    }
?>
<form action="etkinlikekle.php" method="post"> 
    <label for="etkinlik_baslik" style="font-size: 35px;">etkinlik Başlık:</label><br>
    <input type="text" id="etkinlik_baslik" name="etkinlik_baslik"><br>
            
    <label for="etkinlik_link">etkinlik Link:</label><br>
    <input type="text" id="etkinlik_link" name="etkinlik_link"><br>
            
    <label for="etkinlik_date">etkinlik Tarih:</label><br>
    <input type="date" id="etkinlik_date" name="etkinlik_date"><br>
            
    <label for="etkinlik_desc">etkinlik Açıklama:</label><br>
    <textarea id="etkinlik_desc" name="etkinlik_desc"></textarea><br>
            
    <input type="submit" name="submit" value="etkinlik Ekle">
</form>


<!-------------------------------------------------Silme işlemleri------------------------------------>
<?php
// Kartı silme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
$id = $_POST["id"];
$sql = "DELETE FROM duyurular WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "etkinlikler başarıyla silindi.";
  
} else {
    echo "Hata oluştu: " . $conn->error;
}
}



// Kartları sorgula ve listele
$sql = "SELECT * FROM etkinlikler";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>etkinlik ID</th><th>Başlık</th><th></th></tr>"; // Tablo başlıkları
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["etkinlik_baslik"] . "</td>";
        echo "<td><form action='etkinlikekle.php' method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><input class='delete-button' type='submit' value='Sil'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Veritabanında hiç etkinlik bulunamadı.";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>
</body>
</html>















