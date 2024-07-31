

    <!DOCTYPE html>
    <html lang="en">
    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>duyuruekle</title>




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

if(isset($_POST['duyuru_baslik'])) {
    // Formdan gelen verileri al
    $duyuru_baslik = $_POST['duyuru_baslik'];
    $duyuru_link = $_POST['duyuru_link'];
    $duyuru_date = $_POST['duyuru_date'];
    $duyuru_desc = $_POST['duyuru_desc'];
    
    // SQL sorgusu oluştur
    $sql = "INSERT INTO duyurular (duyuru_baslik, duyuru_link, duyuru_date, duyuru_desc) 
            VALUES ('$duyuru_baslik', '$duyuru_link', '$duyuru_date', '$duyuru_desc')";

    // Sorguyu çalıştır ve sonucu kontrol et
    if ($conn->query($sql) === TRUE) {
        echo "Yeni duyuru başarıyla eklendi.";
    } else {
        echo "Hata: " . $sql . "<br>" . $conn->error;
    }
}
?>
<form action="duyuruekle.php" method="post"> 
<label for="duyuru_baslik" style="font-size: 35px;">Duyuru Başlık:</label><br>
<input type="text" id="duyuru_baslik" name="duyuru_baslik"><br>
        
<label for="duyuru_link">Duyuru Link:</label><br>
<input type="text" id="duyuru_link" name="duyuru_link"><br>
        
<label for="duyuru_date">Duyuru Tarih:</label><br>
<input type="date" id="duyuru_date" name="duyuru_date"><br>
        
<label for="duyuru_desc">Duyuru Açıklama:</label><br>
<textarea id="duyuru_desc" name="duyuru_desc"></textarea><br>
        
<input type="submit" name="submit" value="Duyuru Ekle">
</form>



<!-------------------------------------------------Silme işlemleri------------------------------------>
<?php
// Kartı silme işlemi
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"])) {
$id = $_POST["id"];
$sql = "DELETE FROM duyurular WHERE id = $id";

if ($conn->query($sql) === TRUE) {
    echo "duyuru başarıyla silindi.";
  
} else {
    echo "Hata oluştu: " . $conn->error;
}
}



// Kartları sorgula ve listele
$sql = "SELECT * FROM duyurular";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Duyuru ID</th><th>Başlık</th><th></th></tr>"; // Tablo başlıkları
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["duyuru_baslik"] . "</td>";
        echo "<td><form action='duyuruekle.php' method='post'><input type='hidden' name='id' value='" . $row["id"] . "'><input class='delete-button' type='submit' value='Sil'></form></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Veritabanında hiç duyuru bulunamadı.";
}

// Veritabanı bağlantısını kapat
$conn->close();
?>

    </body>
    </html>




















