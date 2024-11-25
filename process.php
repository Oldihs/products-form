<?php
$host = "localhost";        
$user = "root";             
$pass = "";                 
$db   = "products_db";      

// Create database connection
$connection = mysqli_connect($host, $user, $pass, $db);

// Check connection
if (!$connection) {
    // Redirect with connection error
    header("Location: index.php?status=connection_error");
    exit();
}

// Check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Function to sanitize input data
    function sanitize_input($data, $connection) {
        return htmlspecialchars(mysqli_real_escape_string($connection, trim($data)));
    }

    // Get and sanitize data from form
    $leader_name   = sanitize_input($_POST['nama_pimpinan'], $connection);
    $company_name  = sanitize_input($_POST['nama_perusahaan'], $connection);
    $address       = sanitize_input($_POST['alamat'], $connection);
    $product_name  = sanitize_input($_POST['nama_produk'], $connection);
    $product_model = sanitize_input($_POST['model_produk'], $connection);
    $description   = sanitize_input($_POST['deskripsi'], $connection);
    $weight        = sanitize_input($_POST['berat'], $connection);
    $selling_price = sanitize_input(str_replace('.', '', $_POST['harga_jual']), $connection); // Remove dots from number format
    $quantity      = sanitize_input($_POST['quantity'], $connection);
    $minimum_order = sanitize_input($_POST['minimum_order'], $connection);

    // Process photo upload
    if (isset($_FILES['foto_produk'])) {
        $photo_name = $_FILES['foto_produk']['name'];
        $photo_tmp  = $_FILES['foto_produk']['tmp_name'];
        $photo_error = $_FILES['foto_produk']['error'];
        $photo_size = $_FILES['foto_produk']['size'];

        // Check if file was uploaded without errors
        if ($photo_error === UPLOAD_ERR_OK) {
            // Extract file extension
            $photo_extension = strtolower(pathinfo($photo_name, PATHINFO_EXTENSION));

            // Allowed file types
            $allowed_types = ['jpeg', 'jpg', 'png', 'gif'];

            // Validate file type
            if (!in_array($photo_extension, $allowed_types)) {
                // Redirect with invalid file type error
                header("Location: index.php?status=invalid_file_type");
                exit();
            }

            // Validate file size (e.g., max 10MB)
            $max_size = 10 * 1024 * 1024; // 10MB
            if ($photo_size > $max_size) {
                // Redirect with file size error
                header("Location: index.php?status=file_size_exceeded");
                exit();
            }

            // Create unique name for photo file
            $photo_unique_name = date('YmdHis') . '_' . uniqid() . '.' . $photo_extension;

            // Photo storage directory
            $upload_dir = 'uploads/';

            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            // Complete photo path
            $photo_path = $upload_dir . $photo_unique_name;

            // Move uploaded file to the uploads directory
            if (move_uploaded_file($photo_tmp, $photo_path)) {
                // File uploaded successfully
                // Proceed to insert data into the database
            } else {
                // Redirect with upload error
                header("Location: index.php?status=upload_error");
                exit();
            }
        } else {
            // Redirect with upload error (could be no file uploaded or other errors)
            header("Location: index.php?status=upload_error");
            exit();
        }
    } else {
        // Redirect with upload error (file input not set)
        header("Location: index.php?status=upload_error");
        exit();
    }

    // Prepare SQL statement to prevent SQL injection
    $stmt = mysqli_prepare($connection, "INSERT INTO products (
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
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    if ($stmt) {
        // Bind parameters
        mysqli_stmt_bind_param(
            $stmt, 
            "ssssssddsds", 
            $leader_name, 
            $company_name, 
            $address, 
            $product_name, 
            $product_model, 
            $description, 
            $weight, 
            $selling_price, 
            $quantity, 
            $minimum_order, 
            $photo_path
        );
        
        // Execute statement
        if (mysqli_stmt_execute($stmt)) {
            // If successful, redirect with success status
            header("Location: index.php?status=success");
            exit();
        } else {
            // If failed, redirect with database error status
            header("Location: index.php?status=database_error");
            exit();
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // If statement preparation failed
        header("Location: index.php?status=database_error");
        exit();
    }
    
    // Close database connection
    mysqli_close($connection);
} else {
    // If accessed without POST method, redirect to form
    header("Location: index.php");
    exit();
}
?>
