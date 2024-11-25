<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="shortcut icon" href="favicon/box-favicon.png" type="image/x-icon">

    <!-- Remove Heroicons script if using inline SVGs -->
    <!-- <script src="https://unpkg.com/heroicons@2.0.13/dist/outline.js"></script> -->

    <link rel="stylesheet" href="./css/style.css">

    <title>Product Form</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');

        /* Dark Transition */
        .dark-transition {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Custom Cursor Styles */
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
        /* Light Mode Scrollbar Styling */
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

        /* Light Mode Scrollbar Hover Effect */
        /* WebKit Browsers */
        ::-webkit-scrollbar-thumb:hover {
            background-color: #4f46e5; /* Tailwind's indigo-600 */
        }

        /* Firefox Scrollbar Styling */
        * {
            scrollbar-width: thin; /* "auto" or "thin" */
            scrollbar-color: #6366f1 #f3f4f6; /* thumb and track colors */
        }

        /* Light Mode Scrollbar Hover Effect */
        /* Firefox */
        *:hover {
            scrollbar-color: #4f46e5 #f3f4f6;
        }

        /* Dark Mode Scrollbar Styling */
        /* Chrome, Safari, Edge */
        .dark ::-webkit-scrollbar-track {
            background: #374151; 
        }

        .dark ::-webkit-scrollbar-thumb {
            background-color: #818cf8; /* Tailwind's indigo-300 */
            border: 3px solid #374151; /* Creates padding around thumb */
        }

        /* Dark Mode Scrollbar Hover Effect */
        /* WebKit Browsers */
        .dark ::-webkit-scrollbar-thumb:hover {
            background-color: #a5b4fc; /* Tailwind's indigo-200 */
        }

        /* Firefox Scrollbar Styling for Dark Mode */
        .dark * {
            scrollbar-width: thin; /* "auto" or "thin" */
            scrollbar-color: #818cf8 #374151; /* thumb and track colors */
        }

        /* Dark Mode Scrollbar Hover Effect */
        /* Firefox */
        .dark *:hover {
            scrollbar-color: #a5b4fc #374151;
        }

        /* Smooth Transition for Scrollbar Colors */
        ::-webkit-scrollbar-thumb,
        .dark ::-webkit-scrollbar-thumb {
            transition: background-color 0.3s ease;
        }

        *::-webkit-scrollbar-thumb,
        .dark *::-webkit-scrollbar-thumb {
            transition: background-color 0.3s ease;
        }

        /* Fully Rounded Scrollbar Track */
        ::-webkit-scrollbar-track,
        .dark ::-webkit-scrollbar-track {
            border-radius: 9999px; /* Fully rounded */
        }

        .font-outfit {
            font-family: 'Outfit', sans-serif;
        }   

    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 dark-transition">

    <!-- Custom Cursor Element -->
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

        <!-- New Circular Table Button -->
        <a href="table.php" class="p-3 rounded-full bg-white dark:bg-gray-800 shadow-lg hover:shadow-xl transition-all duration-200" aria-label="Go to Table Page">
            <!-- Detailed Table Cells SVG Icon from Heroicons -->
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M4 6h16M4 12h16M4 18h16M4 6v12M20 6v12M8 6v12M16 6v12" />
            </svg>
        </a>
    </div>

    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-8 dark:bg-gray-800 transition-colors">
                <h1 class="text-2xl font-bold font-outfit text-gray-900 dark:text-gray-100 mb-8 text-center">PRODUCTS INPUT FORM</h2>
                
                <form id="productForm" action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6">

                    <!-- Nama Pimpinan -->
                    <div class="space-y-2">
                        <label for="nama_pimpinan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Pimpinan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_pimpinan" name="nama_pimpinan" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Nama Perusahaan -->
                    <div class="space-y-2">
                        <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                placeholder="Contoh: Jalan Sudirman No. 123, RT 001/RW 002, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk, Jakarta Barat, Kota DKI Jakarta 11530"
                                aria-required="true"></textarea>
                            <div id="addressError" class="hidden mt-2 text-sm text-red-600 dark:text-red-400"></div>
                            <div id="addressSuggestion" class="hidden mt-2 p-4 bg-yellow-50 dark:bg-yellow-700 rounded-md">
                                <p class="text-sm text-yellow-700 dark:text-yellow-300 font-medium mb-2">Saran format alamat yang benar:</p>
                                <div class="text-sm text-yellow-600 dark:text-yellow-400">
                                    <p class="mb-1">Format yang disarankan:</p>
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Nama jalan dan nomor rumah</li>
                                        <li>RT/RW (jika ada)</li>
                                        <li>Kelurahan/Desa</li>
                                        <li>Kecamatan</li>
                                        <li>Kota/Kabupaten</li>
                                        <li>Provinsi</li>
                                        <li>Kode Pos</li>
                                    </ul>
                                    <p class="mt-2">Contoh yang benar:</p>
                                    <p class="italic mt-1">Jalan Gatot Subroto No. 15, RT 003/RW 005, Kelurahan Kuningan Timur, Kecamatan Setiabudi, Jakarta Selatan, Kota DKI Jakarta 12950</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Produk -->
                    <div class="space-y-2">
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Model/Tipe Produk -->
                    <div class="space-y-2">
                        <label for="model_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Model/Tipe Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="model_produk" name="model_produk" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Deskripsi <span class="text-red-500">*</span>
                            <span class="text-sm text-gray-500 dark:text-gray-400 ml-1">(Minimum 10 kata)</span>
                        </label>
                        <div class="relative">
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="4" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                aria-required="true"></textarea>
                            <div class="mt-1 flex justify-between items-center">
                                <div id="descriptionError" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                                <div id="wordCount" class="text-sm text-gray-500 dark:text-gray-400">0 kata</div>
                            </div>
                        </div>
                    </div>

                    <!-- Berat -->
                    <div class="space-y-2">
                        <label for="berat" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Berat <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            <div class="relative flex-1">
                                <input type="number" 
                                    id="berat" 
                                    name="berat" 
                                    min="0" 
                                    step="0.01" 
                                    required
                                    placeholder="0.00"
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                    aria-required="true">
                                <span id="displayUnit" class="absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400"></span>
                            </div>
                            <select id="weightUnit" 
                                    name="weight_unit" 
                                    class="w-24 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                    aria-label="Select weight unit">
                                <option value="g">gram</option>
                                <option value="kg">kilogram</option>
                                <option value="mg">miligram</option>
                                <option value="oz">ons</option>
                                <option value="lbs">pound</option>
                            </select>
                        </div>
                        <div id="weightError" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                        <div id="weightHelper" class="text-xs text-gray-500 dark:text-gray-400">
                            <!-- Weight conversion info will be shown here -->
                        </div>
                    </div>

                    <!-- Harga Jual -->
                    <div class="space-y-2">
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            <select id="currency" 
                                    name="currency" 
                                    class="w-28 px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                    aria-label="Select currency">
                                <option value="IDR">IDR (Rp)</option>
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="JPY">JPY (¥)</option>
                                <option value="SGD">SGD (S$)</option>
                                <option value="AUD">AUD (A$)</option>
                            </select>
                            <div class="relative flex-1">
                                <span id="currencySymbol" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-700 dark:text-gray-300 font-medium"></span>
                                <input type="text" 
                                    id="harga_jual" 
                                    name="harga_jual" 
                                    required
                                    placeholder="0"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                                    aria-required="true">
                            </div>
                        </div>
                        <div id="priceError" class="hidden text-sm text-red-600 dark:text-red-400"></div>
                        <div id="priceInWords" class="text-xs text-gray-500 dark:text-gray-400"></div>
                        <div id="priceConversion" class="text-xs text-gray-500 dark:text-gray-400"></div>
                    </div>

                    <!-- Quantity -->
                    <div class="space-y-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Minimum Order -->
                    <div class="space-y-2">
                        <label for="minimum_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Minimum Order <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="minimum_order" name="minimum_order" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:text-gray-100 transition-colors"
                            aria-required="true">
                    </div>

                    <!-- Foto Produk -->
                    <div class="space-y-2">
                        <label for="foto_produk" class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Foto Produk <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex flex-col items-center">
                            <!-- Loading Spinner -->
                            <div id="loadingSpinner" class="hidden w-full flex justify-center items-center my-4">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                            </div>

                            <!-- Image Preview Container -->
                            <div id="imagePreviewContainer" class="hidden w-full mb-4 relative">
                                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-white dark:bg-gray-700 rounded-full p-1 shadow-lg hover:bg-gray-100 dark:hover:bg-gray-600 focus:outline-none" aria-label="Remove Image">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600 dark:text-gray-300" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <img id="imagePreview" src="" alt="Preview" class="max-h-64 w-full object-contain rounded-lg shadow-md">
                            </div>
                            
                            <!-- Upload Container -->
                            <div id="uploadContainer" class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-gray-600 border-dashed rounded-md hover:border-indigo-500 dark:hover:border-indigo-400 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                        <label for="foto_produk" class="relative cursor-pointer bg-white dark:bg-gray-700 rounded-md font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="foto_produk" name="foto_produk" type="file" class="sr-only" required accept="image/*" aria-required="true">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, GIF up to 10MB</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                            Submit Form
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PLUGINS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Javascript Links -->
    <script src="js/nameValidation.js"></script>
    <script src="js/fieldsValidation.js"></script>
    <script src="js/addressValidation.js"></script>
    <script src="js/descriptionValidation.js"></script>
    <script src="js/weightValidation.js"></script>
    <script src="js/currencyValidation.js"></script>
    <script src="js/imageUpload.js"></script>
    <script src="js/darkMode.js"></script>
    <script src="js/alert.js"></script>
    <script src="js/cursor.js"></script>
    
    <script src="tailwind.config.js"></script>
</body>
</html>
