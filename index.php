<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.js"></script>

    <link rel="shortcut icon" href="favicon/box-favicon.png" type="image/x-icon">

    <title>Product Form</title>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">PRODUCTS INPUT FORM</h2>
                
                <form action="process.php" method="POST" enctype="multipart/form-data" class="space-y-6">

                    <!-- Nama Pimpinan -->
                    <div class="space-y-2">
                        <label for="nama_pimpinan" class="block text-sm font-medium text-gray-700">
                            Nama Pimpinan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_pimpinan" name="nama_pimpinan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Nama Perusahaan -->
                    <div class="space-y-2">
                        <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700">
                            Nama Perusahaan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_perusahaan" name="nama_perusahaan" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Alamat -->
                    <div class="space-y-2">
                        <label for="alamat" class="block text-sm font-medium text-gray-700">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <textarea id="alamat" name="alamat" rows="3" required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                                placeholder="Contoh: Jalan Sudirman No. 123, RT 001/RW 002, Kelurahan Kebon Jeruk, Kecamatan Kebon Jeruk, Jakarta Barat, Kota DKI Jakarta 11530"></textarea>
                            <div id="addressError" class="hidden mt-2 text-sm text-red-600"></div>
                            <div id="addressSuggestion" class="hidden mt-2 p-4 bg-yellow-50 rounded-md">
                                <p class="text-sm text-yellow-700 font-medium mb-2">Saran format alamat yang benar:</p>
                                <div class="text-sm text-yellow-600">
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
                        <label for="nama_produk" class="block text-sm font-medium text-gray-700">
                            Nama Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_produk" name="nama_produk" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Model/Tipe Produk -->
                    <div class="space-y-2">
                        <label for="model_produk" class="block text-sm font-medium text-gray-700">
                            Model/Tipe Produk <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="model_produk" name="model_produk" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Deskripsi -->
                    <div class="space-y-2">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                            Deskripsi <span class="text-red-500">*</span>
                            <span class="text-sm text-gray-500 ml-1">(Minimum 10 kata)</span>
                        </label>
                        <div class="relative">
                            <textarea 
                                id="deskripsi" 
                                name="deskripsi" 
                                rows="4" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                            ></textarea>
                            <div class="mt-1 flex justify-between items-center">
                                <div id="descriptionError" class="hidden text-sm text-red-600"></div>
                                <div id="wordCount" class="text-sm text-gray-500">0 kata</div>
                            </div>
                        </div>
                    </div>

                    <!-- Berat -->
                    <div class="space-y-2">
                        <label for="berat" class="block text-sm font-medium text-gray-700">
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
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                                <span id="displayUnit" class="absolute right-10 top-1/2 transform -translate-y-1/2 text-gray-500"></span>
                            </div>
                            <select id="weightUnit" 
                                    name="weight_unit" 
                                    class="w-24 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition-colors">
                                <option value="g">gram</option>
                                <option value="kg">kilogram</option>
                                <option value="mg">miligram</option>
                                <option value="oz">ons</option>
                                <option value="lbs">pound</option>
                            </select>
                        </div>
                        <div id="weightError" class="hidden text-sm text-red-600"></div>
                        <div id="weightHelper" class="text-xs text-gray-500">
                            <!-- Weight conversion info will be shown here -->
                        </div>
                    </div>

                    <!-- Harga Jual -->
                    <div class="space-y-2">
                        <label for="harga_jual" class="block text-sm font-medium text-gray-700">
                            Harga Jual <span class="text-red-500">*</span>
                        </label>
                        <div class="flex space-x-2">
                            <select id="currency" 
                                    name="currency" 
                                    class="w-28 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 bg-white transition-colors">
                                <option value="IDR">IDR (Rp)</option>
                                <option value="USD">USD ($)</option>
                                <option value="EUR">EUR (€)</option>
                                <option value="GBP">GBP (£)</option>
                                <option value="JPY">JPY (¥)</option>
                                <option value="SGD">SGD (S$)</option>
                                <option value="AUD">AUD (A$)</option>
                            </select>
                            <div class="relative flex-1">
                                <span id="currencySymbol" class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-700 font-medium"></span>
                                <input type="text" 
                                    id="harga_jual" 
                                    name="harga_jual" 
                                    required
                                    placeholder="0"
                                    class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                            </div>
                        </div>
                        <div id="priceError" class="hidden text-sm text-red-600"></div>
                        <div id="priceInWords" class="text-xs text-gray-500"></div>
                        <div id="priceConversion" class="text-xs text-gray-500"></div>
                    </div>

                    <!-- Quantity -->
                    <div class="space-y-2">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">
                            Quantity <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="quantity" name="quantity" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Minimum Order -->
                    <div class="space-y-2">
                        <label for="minimum_order" class="block text-sm font-medium text-gray-700">
                            Minimum Order <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="minimum_order" name="minimum_order" min="1" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors">
                    </div>

                    <!-- Foto Produk -->
                    <div class="space-y-2">
                        <label for="foto_produk" class="block text-sm font-medium text-gray-700">
                            Foto Produk <span class="text-red-500">*</span>
                        </label>
                        <div class="mt-1 flex flex-col items-center">
                            <!-- Loading Spinner -->
                            <div id="loadingSpinner" class="hidden w-full flex justify-center items-center my-4">
                                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-indigo-600"></div>
                            </div>

                            <!-- Image Preview Container -->
                            <div id="imagePreviewContainer" class="hidden w-full mb-4 relative">
                                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-white rounded-full p-1 shadow-lg hover:bg-gray-100 focus:outline-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <img id="imagePreview" src="" alt="Preview" class="max-h-64 w-full object-contain rounded-lg shadow-md">
                            </div>
                            
                            <!-- Upload Container -->
                            <div id="uploadContainer" class="w-full flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-indigo-500 transition-colors duration-200">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="foto_produk" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                            <span>Upload a file</span>
                                            <input id="foto_produk" name="foto_produk" type="file" class="sr-only" required accept="image/*">
                                        </label>
                                        <p class="pl-1">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF up to 10MB</p>
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

    <!-- Javascript Links -->
    <script src="js/nameValidation.js"></script>
    <script src="js/fieldsValidation.js"></script>
    <script src="js/addressValidation.js"></script>
    <script src="js/descriptionValidation.js"></script>
    <script src="js/weightValidation.js"></script>
    <script src="js/currencyValidation.js"></script>
    <script src="js/imageUpload.js"></script>
    <script src="js/darkMode.js"></script>
</body>
</html>