<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>admin paneli</title>    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="resimler/CİDE LOGO.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>




<body style="background-color: blue;">
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
    
    if(isset($_POST['haber_baslik'])) {
        // Formdan gelen verileri al
        $haber_baslik = $_POST['haber_baslik'];
        $haber_link = $_POST['haber_link'];
        $haber_date = $_POST['haber_date'];
        $haber_desc = $_POST['haber_desc'];
        
        // Resim dosyasını yükleme işlemi
        $target_dir = "haberler_gorsel/"; // Resimlerin kaydedileceği klasör
        $target_file = $target_dir . basename($_FILES["haber_img"]["name"]); // Yüklenen dosyanın tam yolu
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        // Resim dosyasını kontrol et
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["haber_img"]["tmp_name"]);
            if($check !== false) {
                echo "Dosya bir resim - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "Dosya bir resim değil.";
                $uploadOk = 0;
            }
        }
        
        // Dosya zaten var mı kontrol et
        if (file_exists($target_file)) {
            echo "Üzgünüz, dosya zaten var.";
            $uploadOk = 0;
        }
        
        // Boyut kontrolü yap
        if ($_FILES["haber_img"]["size"] > 9999999) {
            echo "Üzgünüz, dosyanız çok büyük.";
            $uploadOk = 0;
        }
        
        // İzin verilen dosya türlerini kontrol et
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Üzgünüz, sadece JPG, JPEG, PNG & GIF dosyalarına izin verilir.";
            $uploadOk = 0;
        }
        
        // Yükleme durumu kontrol et
        if ($uploadOk == 0) {
            echo "Üzgünüz, dosyanız yüklenemedi.";
        } else {
            if (move_uploaded_file($_FILES["haber_img"]["tmp_name"], $target_file)) {
                echo "Dosya ". htmlspecialchars( basename( $_FILES["haber_img"]["name"])). " başarıyla yüklendi.";
            } else {
                echo "Üzgünüz, dosya yüklenirken bir hata oluştu.";
            }
        }
    
        // SQL sorgusu oluştur
        $sql = "INSERT INTO haberler (haber_baslik, haber_link, haber_date, haber_desc, haber_img) 
                VALUES ('$haber_baslik', '$haber_link', '$haber_date', '$haber_desc', '$target_file')";
    
        // Sorguyu çalıştır ve sonucu kontrol et
        if ($conn->query($sql) === TRUE) {
            echo "Yeni haber başarıyla eklendi.";
        } else {
            echo "Hata: " . $sql . "<br>" . $conn->error;
        }
    }
    // Veritabanı bağlantısını kapat
    $conn->close();
    ?>
    <div class="container" style="background-color:white ;">
        <center><hr>
            <br></center>
        <hr>
        <center><h1 style="font-size: 50px; color:black">Haber Ekleme</h1></center><hr>
        
        <center>
    
        <h2 style="font-size: 40px; color: white;">-Yeni Haber Ekle-</h2>
    
        <form action="haberekle.php" method="post" enctype="multipart/form-data" target="haber_iframe"> 
            <label for="haber_baslik" style=" font-size: 35px;">Haber Başlık:</label><br>
            <input type="text" id="haber_baslik" name="haber_baslik" style=""><br>
            
            <label for="haber_link">Haber Link:</label><br>
            <input type="text" id="haber_link" name="haber_link"><br>
            
            <label for="haber_date">Haber Tarih:</label><br>
            <input type="date" id="haber_date" name="haber_date"><br>
            
            <label for="haber_desc">Haber Açıklama:</label><br>
            <textarea id="haber_desc" name="haber_desc"></textarea><br>
            
            <label for="haber_img">Haber Görsel:</label><br>
            <input type="file" id="haber_img" name="haber_img"><br>
            
            <input type="submit" name="submit" value="Haberi Ekle">
        </form>
      
         <hr>
    </div> <!--Container div end -->
    
    
    </center>



</body>
</html>
