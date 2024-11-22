<?php
// Database connection configuration
$host = "localhost";    // Database hostname
$user = "root";         // Database username
$pass = "";             // Database password (empty for default XAMPP)
$db   = "products_db";    // Database name

// Create database connection
$connection = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get data from form
    $leader_name = $_POST['nama_pimpinan'];
    $company_name = $_POST['nama_perusahaan'];
    $address = $_POST['alamat'];
    $product_name = $_POST['nama_produk'];
    $product_model = $_POST['model_produk'];
    $description = $_POST['deskripsi'];
    $weight = $_POST['berat'];
    $selling_price = str_replace('.', '', $_POST['harga_jual']); // Remove dots from number format
    $quantity = $_POST['quantity'];
    $minimum_order = $_POST['minimum_order'];

    // Process photo upload
    $photo_name = $_FILES['foto_produk']['name'];
    $photo_tmp = $_FILES['foto_produk']['tmp_name'];
    
    // Create unique name for photo file
    $photo_name = date('YmdHis') . '_' . $photo_name;
    
    // Photo storage directory
    $upload_dir = 'uploads/';
    
    // Create directory if it doesn't exist
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Complete photo path
    $photo_path = $upload_dir . $photo_name;
    
    // Upload photo
    if (move_uploaded_file($photo_tmp, $photo_path)) {
        // Query to save data to database
        $query = "INSERT INTO products (
                    nama_pimpinan, 
                    nama_perusahaan, 
                    alamat, 
                    nama_produk, 
                    model_tipe, 
                    deskripsi, 
                    berat, 
                    harga_jual, 
                    quantity, 
                    minimum_order, 
                    foto_produk
                ) VALUES (
                    '$leader_name',
                    '$company_name',
                    '$address',
                    '$product_name',
                    '$product_model',
                    '$description',
                    '$weight',
                    '$selling_price',
                    '$quantity',
                    '$minimum_order',
                    '$photo_path'
                )";
        
        // Execute query
        if (mysqli_query($connection, $query)) {
            // If successful, show success message
            echo "<script>
                    alert('Data saved successfully!');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            // If failed, show error message
            echo "<script>
                    alert('Error: " . mysqli_error($connection) . "');
                    window.location.href = 'index.php';
                  </script>";
        }
    } else {
        // If photo upload fails
        echo "<script>
                alert('Sorry, there was an error uploading the photo.');
                window.location.href = 'index.php';
              </script>";
    }
    
    // Close database connection
    mysqli_close($connection);
}