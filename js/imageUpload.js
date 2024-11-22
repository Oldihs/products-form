// Image upload functionality
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('foto_produk');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadContainer = document.getElementById('uploadContainer');
    const removeButton = document.getElementById('removeImage');
    const loadingSpinner = document.getElementById('loadingSpinner');

    // Handle drag and drop
    uploadContainer.addEventListener('dragover', (e) => {
        e.preventDefault();
        uploadContainer.classList.add('border-indigo-600', 'bg-indigo-50');
    });

    uploadContainer.addEventListener('dragleave', (e) => {
        e.preventDefault();
        uploadContainer.classList.remove('border-indigo-600', 'bg-indigo-50');
    });

    uploadContainer.addEventListener('drop', (e) => {
        e.preventDefault();
        uploadContainer.classList.remove('border-indigo-600', 'bg-indigo-50');
        
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            fileInput.files = e.dataTransfer.files;
            handleImageUpload(file);
        }
    });

    // Handle file input change
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageUpload(file);
        }
    });

    // Handle image upload with loading animation
    function handleImageUpload(file) {
        if (file && file.type.startsWith('image/')) {
            // Show loading spinner and hide other containers
            loadingSpinner.classList.remove('hidden');
            imagePreviewContainer.classList.add('hidden');
            uploadContainer.classList.add('hidden');

            const reader = new FileReader();
            
            reader.onload = function(e) {
                // Create a new image object to check dimensions and file size
                const img = new Image();
                img.src = e.target.result;
                
                img.onload = function() {
                    // Simulate loading delay (remove this in production)
                    setTimeout(() => {
                        // Hide loading spinner
                        loadingSpinner.classList.add('hidden');
                        
                        // Show preview
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.classList.remove('hidden');
                    }, 1000); // Simulated 1 second delay
                };

                img.onerror = function() {
                    // Handle image load error
                    loadingSpinner.classList.add('hidden');
                    uploadContainer.classList.remove('hidden');
                    alert('Error loading image. Please try again.');
                };
            };

            reader.onerror = function() {
                // Handle FileReader error
                loadingSpinner.classList.add('hidden');
                uploadContainer.classList.remove('hidden');
                alert('Error reading file. Please try again.');
            };

            reader.readAsDataURL(file);
        }
    }

    // Remove image
    function removeImage(showError = false) {
        // Only show error alert if it's a genuine error, not a manual removal
        if (showError) {
            alert('Error loading image. Please try again.');
        }
        
        fileInput.value = '';
        // Set a blank data URL instead of empty string to avoid triggering error event
        imagePreview.src = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        imagePreviewContainer.classList.add('hidden');
        uploadContainer.classList.remove('hidden');
    }

    // Add click event listener to remove button
    removeButton.addEventListener('click', () => removeImage(false));

    // Add error handling for the image preview
    imagePreview.addEventListener('error', function(e) {
        // Check if this is a genuine error or just clearing the image
        if (e.target.src && !e.target.src.startsWith('data:image/gif;base64')) {
            removeImage(true);
        }
    });
});