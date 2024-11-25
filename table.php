<?php
// table.php

// Database configuration
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

// Define default number of records per page
$default_limit = 10;

// Define allowed limits to prevent abuse
$allowed_limits = [10, 25, 50, 100];

// Get the 'limit' parameter from GET request or set to default
if (isset($_GET['limit']) && in_array((int)$_GET['limit'], $allowed_limits)) {
    $limit = (int)$_GET['limit'];
} else {
    $limit = $default_limit;
}

// Get the current page or set default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;

// Calculate the offset
$offset = ($page - 1) * $limit;

// Handle Query Options (Filtering)
$filter = '';
$filter_param = '';
if (isset($_GET['filter']) && !empty($_GET['filter'])) {
    $filter_value = mysqli_real_escape_string($connection, $_GET['filter']);
    $filter = " WHERE nama_perusahaan = '$filter_value' ";
    $filter_param = "&filter=" . urlencode($filter_value);
}

// Handle Search Query
$search = '';
$search_param = '';
if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_value = mysqli_real_escape_string($connection, trim($_GET['search']));
    if (empty($filter)) {
        $filter = " WHERE (nama_pimpinan LIKE '%$search_value%' OR nama_perusahaan LIKE '%$search_value%' OR nama_produk LIKE '%$search_value%') ";
    } else {
        $filter .= " AND (nama_pimpinan LIKE '%$search_value%' OR nama_perusahaan LIKE '%$search_value%' OR nama_produk LIKE '%$search_value%') ";
    }
    $search_param = "&search=" . urlencode($search_value);
}

// Get the total number of records
$total_query = "SELECT COUNT(*) FROM products" . $filter;
$total_result = mysqli_query($connection, $total_query);
$total_row = mysqli_fetch_array($total_result);
$total = $total_row[0];
$total_pages = ceil($total / $limit);

// Fetch the required records
$query = "SELECT * FROM products " . $filter . " ORDER BY id ASC LIMIT $limit OFFSET $offset";
$result = mysqli_query($connection, $query);

// Check for query errors
if (!$result) {
    // Redirect with database error
    header("Location: index.php?status=database_error");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Table</title>
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Tailwind CSS Configuration for Class-Based Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class', // Enable class-based dark mode
            theme: {
                extend: {},
            },
            variants: {
                extend: {},
            },
            plugins: [],
        }
    </script>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Optional: Remove Heroicons script if using inline SVGs -->
    <!-- <script src="https://unpkg.com/heroicons@2.0.13/dist/outline.js"></script> -->
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

    /* Dark Transition */
    .dark-transition {
        transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    /* Custom Cursor Styles (Optional) */
    #custom-cursor {
        width: 30px;
        height: 30px;
        background-color: rgba(99, 102, 241, 0.5); /* Indigo-500 with 50% opacity */
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: transform 0.1s ease-out, background-color 0.3s ease;
        pointer-events: none; /* Ensure cursor doesn't block interactions */
        position: fixed;
        top: 0;
        left: 0;
        z-index: 9999;
        display: none; /* Initially hidden */
    }

    /* Cursor Hover Effect (Optional) */
    a:hover ~ #custom-cursor,
    button:hover ~ #custom-cursor {
        background-color: rgba(99, 102, 241, 0.8); /* Increase opacity on hover */
        transform: translate(-50%, -50%) scale(1.5);
    }

    /* Smooth appearance */
    #custom-cursor.show {
        display: block;
    }

    /* Scrollbar Styling for WebKit Browsers */
    /* Chrome, Safari, Edge */
    ::-webkit-scrollbar {
        width: 12px; /* Width of the entire scrollbar */
    }

    ::-webkit-scrollbar-track {
        background: #f3f4f6; /* Tailwind's gray-100 */
        border-radius: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #6366f1; /* Tailwind's indigo-500 */
        border-radius: 6px;
        border: 3px solid #f3f4f6; /* Creates padding around thumb */
    }

    /* Scrollbar Styling for Firefox */
    /* Firefox */
    * {
        scrollbar-width: thin; /* "auto" or "thin" */
        scrollbar-color: #6366f1 #f3f4f6; /* thumb and track colors */
    }

    /* Optional: Scrollbar Hover Effect */
    /* WebKit Browsers */
    ::-webkit-scrollbar-thumb:hover {
        background-color: #4f46e5; /* Tailwind's indigo-600 */
    }

    /* Firefox */
    *:hover {
        scrollbar-color: #4f46e5 #f3f4f6;
    }

    /* Dark Mode Scrollbar Styling */
    /* Chrome, Safari, Edge */
    .dark ::-webkit-scrollbar-track {
        background: #111827; /* Tailwind's gray-900 - even darker grey */
    }

    /* Dark Mode Scrollbar Thumb */
    .dark ::-webkit-scrollbar-thumb {
        background-color: #818cf8; /* Tailwind's indigo-300 */
        border: 3px solid #111827; /* Matches the new darker track background */
    }

    /* Dark Mode Scrollbar Hover Effect */
    /* WebKit Browsers */
    .dark ::-webkit-scrollbar-thumb:hover {
        background-color: #a5b4fc; /* Tailwind's indigo-200 */
    }

    /* Firefox Scrollbar Styling for Dark Mode */
    .dark * {
        scrollbar-width: thin; /* "auto" or "thin" */
        scrollbar-color: #818cf8 #111827; /* thumb and track colors */
    }

    /* Dark Mode Scrollbar Hover Effect */
    /* Firefox */
    .dark *:hover {
        scrollbar-color: #a5b4fc #111827;
    }

    /* Dark Mode Dividing Lines in Table Rows */
    /* Update the dividing lines to a darker gray in dark mode */
    .dark .divide-gray-200 {
        --tw-divide-opacity: 1;
        border-color: rgba(55, 65, 81, var(--tw-divide-opacity)); /* Tailwind's gray-700 */
    }

    .font-outfit {
        font-family: 'Outfit', sans-serif;
    } 
    </style>
    
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark-transition text-gray-800 dark:text-gray-200">
    
    <!-- Custom Cursor Element (Optional) -->
    <div id="custom-cursor"></div>

    <!-- Fixed Container for Buttons at Bottom Right -->
    <div class="fixed bottom-4 right-4 flex space-x-4 z-50">
        <!-- Dark Mode Toggle Button -->
        <button id="darkModeToggle" class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-200 focus:outline-none" aria-label="Toggle Dark Mode">
            <!-- Sun Icon -->
            <svg id="sunIcon" class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg>
            <!-- Moon Icon -->
            <svg id="moonIcon" class="hidden w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                </path>
            </svg>
        </button>
    </div>

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 flex justify-between items-center">
                <h1 class="text-3xl font-bold font-outfit">My Inventory</h1>
                <a href="index.php" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300 font-medium flex items-center space-x-1">
                    <!-- Back Arrow Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Back to Form</span>
                </a>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="overflow-x-auto">
                <!-- Controls: Filter, Search, Results Per Page -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    <!-- Left Side: Filter and Search -->
                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                        <!-- Filter Dropdown -->
                        <form method="GET" action="table.php" class="flex items-center space-x-2">
                            <label for="filter" class="text-sm font-medium text-gray-700 dark:text-gray-200">Filter by Company:</label>
                            <select id="filter" name="filter" onchange="this.form.submit()" class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">All Companies</option>
                                <?php
                                // Fetch distinct company names for the dropdown
                                $companies_query = "SELECT DISTINCT nama_perusahaan FROM products ORDER BY nama_perusahaan ASC";
                                $companies_result = mysqli_query($connection, $companies_query);
                                while ($company = mysqli_fetch_assoc($companies_result)) {
                                    $selected = (isset($_GET['filter']) && $_GET['filter'] === $company['nama_perusahaan']) ? 'selected' : '';
                                    echo "<option value=\"" . htmlspecialchars($company['nama_perusahaan']) . "\" $selected>" . htmlspecialchars($company['nama_perusahaan']) . "</option>";
                                }
                                ?>
                            </select>
                        </form>
                        
                        <!-- Search Bar -->
                        <form method="GET" action="table.php" class="flex items-center space-x-2">
                            <!-- Preserve existing filters and limit when searching -->
                            <?php if (isset($_GET['filter']) && !empty($_GET['filter'])): ?>
                                <input type="hidden" name="filter" value="<?php echo htmlspecialchars($_GET['filter']); ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['limit']) && in_array((int)$_GET['limit'], $allowed_limits)): ?>
                                <input type="hidden" name="limit" value="<?php echo htmlspecialchars($_GET['limit']); ?>">
                            <?php endif; ?>
                            
                            <label for="search" class="sr-only">Search Products</label>
                            <input type="text" id="search" name="search" placeholder="Search Data..." class="mt-1 block w-full pl-3 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            
                            <button type="submit" class="flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition-colors">
                                <!-- Search Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1110.5 3a7.5 7.5 0 017.15 13.65z" />
                                </svg>
                                <span class="ml-2">Search</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Right Side: Results Per Page Dropdown and Pagination Info -->
                    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                        <!-- Results Per Page Dropdown -->
                        <form method="GET" action="table.php" class="flex items-center space-x-2">
                            <!-- Preserve existing filters and search when changing the limit -->
                            <?php if (isset($_GET['filter']) && !empty($_GET['filter'])): ?>
                                <input type="hidden" name="filter" value="<?php echo htmlspecialchars($_GET['filter']); ?>">
                            <?php endif; ?>
                            <?php if (isset($_GET['search']) && !empty(trim($_GET['search']))): ?>
                                <input type="hidden" name="search" value="<?php echo htmlspecialchars($_GET['search']); ?>">
                            <?php endif; ?>
                            
                            <label for="limit" class="text-sm font-medium text-gray-700 dark:text-gray-200">Results per page:</label>
                            <select id="limit" name="limit" onchange="this.form.submit()" class="mt-1 block pl-3 pr-10 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <?php
                                foreach ($allowed_limits as $option) {
                                    $selected = ($limit == $option) ? 'selected' : '';
                                    echo "<option value=\"$option\" $selected>$option</option>";
                                }
                                ?>
                            </select>
                        </form>
                        
                        <!-- Pagination Info -->
                        <div class="text-sm text-gray-700 dark:text-gray-300">
                            Showing <?php echo ($total > 0) ? ($offset + 1) : 0; ?> to <?php echo min($offset + $limit, $total); ?> of <?php echo $total; ?> results
                        </div>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    No
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Leader Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Company Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Product Name
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Model/Type
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Price (IDR)
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                    Photo
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                $no = $offset + 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    // Format the selling price with thousand separators
                                    $formatted_price = number_format($row['harga_jual'], 0, ',', '.');
                                    
                                    // Escape output to prevent XSS
                                    $leader_name = htmlspecialchars($row['nama_pimpinan']);
                                    $company_name = htmlspecialchars($row['nama_perusahaan']);
                                    $product_name = htmlspecialchars($row['nama_produk']);
                                    $product_model = htmlspecialchars($row['model_tipe']);
                                    $price = htmlspecialchars($formatted_price);
                                    
                                    // Image path
                                    $image_path = htmlspecialchars($row['foto_produk']);
                                    
                                    echo "<tr class='hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors'>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>$no</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>$leader_name</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>$company_name</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>$product_name</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>$product_model</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>Rp $price</td>";
                                    echo "<td class='px-6 py-4 whitespace-nowrap text-lg text-gray-700 dark:text-gray-200'>";
                                    echo "<img src='$image_path' alt='Product Photo' class='w-20 h-20 object-cover rounded-md shadow'>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr>";
                                echo "<td colspan='7' class='px-6 py-4 whitespace-nowrap text-sm text-gray-700 dark:text-gray-200 text-center'>No products found.</td>";
                                echo "</tr>";
                            }

                            // Free result set
                            mysqli_free_result($result);
                            ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Controls -->
                <div class="mt-6 flex flex-col md:flex-row items-center justify-between">
                    <!-- Pagination Buttons -->
                    <div class="flex justify-center">
                        <?php if ($page > 1): ?>
                            <a href="table.php?page=<?php echo $page - 1 . $filter_param . $search_param . '&limit=' . $limit; ?>" class="px-4 py-2 mx-1 border border-indigo-600 text-indigo-600 dark:text-indigo-400 dark:border-indigo-400 rounded-md hover:bg-indigo-600 hover:text-white dark:hover:text-white transition-colors">Previous</a>
                        <?php endif; ?>

                        <?php
                        // Display page numbers with a maximum of 5 pages visible
                        $start = max(1, $page - 2);
                        $end = min($total_pages, $page + 2);

                        for ($p = $start; $p <= $end; $p++):
                            if ($p == $page) {
                                // Active page button
                                echo "<a href=\"table.php?page=$p$filter_param$search_param&limit=$limit\" class=\"px-4 py-2 mx-1 bg-indigo-600 text-white dark:bg-indigo-700 rounded-md\">$p</a>";
                            } else {
                                // Inactive page button with border
                                echo "<a href=\"table.php?page=$p$filter_param$search_param&limit=$limit\" class=\"px-4 py-2 mx-1 border border-indigo-600 dark:border-indigo-400 text-indigo-600 dark:text-indigo-400 rounded-md hover:bg-indigo-600 hover:text-white dark:hover:text-white transition-colors\">$p</a>";
                            }
                        endfor;
                        ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="table.php?page=<?php echo $page + 1 . $filter_param . $search_param . '&limit=' . $limit; ?>" class="px-4 py-2 mx-1 border border-indigo-600 text-indigo-600 dark:text-indigo-400 rounded-md hover:bg-indigo-600 hover:text-white dark:hover:text-white transition-colors">Next</a>
                        <?php endif; ?>
                    </div>

                    <!-- Pagination Info (Optional) -->
                    <div class="text-sm text-gray-700 dark:text-gray-300 mt-4 md:mt-0">
                        Page <?php echo $page; ?> of <?php echo $total_pages; ?>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500 dark:text-gray-400">
                &copy; <?php echo date("Y"); ?> Products Management. All rights reserved.
            </div>
        </footer>
    </div>

    <!-- PLUGINS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Javascript Links -->
    <!-- Include darkMode.js to handle dark mode toggle functionality -->
    <script src="js/darkMode.js"></script>
    <!-- Optional: Include cursor.js if using a custom cursor -->
    <script src="js/cursor.js"></script>
    
    <!-- Optional: Custom scripts for alerts or other functionalities -->
    <script src="js/alert.js"></script>

    <!-- Note: The following script tag might be redundant if Tailwind is already configured inline -->
    <!-- Remove if unnecessary -->
    <script src="tailwind.config.js"></script>
    
</body>
</html>

<?php
// Close database connection
mysqli_close($connection);
?>
