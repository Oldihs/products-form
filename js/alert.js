// alert.js

document.addEventListener('DOMContentLoaded', function () {
    /**
     * Retrieves the value of a specific query parameter from the URL.
     * @param {string} param - The name of the query parameter.
     * @returns {string|null} The value of the query parameter or null if not found.
     */
    function getQueryParam(param) {
        const params = new URLSearchParams(window.location.search);
        return params.get(param);
    }

    /**
     * Displays a SweetAlert2 modal based on the provided status.
     * @param {string} status - The status flag indicating the type of modal to display.
     */
    function showStatusModal(status) {
        let modalOptions = {};

        switch(status) {
            case 'success':
                modalOptions = {
                    title: 'Success',
                    text: 'Data saved successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                };
                break;
            case 'connection_error':
                modalOptions = {
                    title: 'Connection Error',
                    text: 'Failed to connect to the database. Please try again later.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                };
                break;
            case 'database_error':
                modalOptions = {
                    title: 'Database Error',
                    text: 'There was an error saving your data. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                };
                break;
            case 'upload_error':
                modalOptions = {
                    title: 'Upload Error',
                    text: 'There was an error uploading your photo. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                };
                break;
            case 'invalid_file_type':
                modalOptions = {
                    title: 'Invalid File Type',
                    text: 'Only JPEG, PNG, and GIF files are allowed.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                };
                break;
            case 'file_size_exceeded':
                modalOptions = {
                    title: 'File Size Exceeded',
                    text: 'The uploaded file exceeds the maximum allowed size of 10MB.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                };
                break;
            case 'invalid_csrf':
                modalOptions = {
                    title: 'Security Error',
                    text: 'Invalid form submission. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                };
                break;
            default:
                // Unknown status; no action taken
                return;
        }

        // Display the modal and then remove the 'status' parameter from the URL
        Swal.fire(modalOptions).then(() => {
            removeQueryParam('status');
        });
    }

    /**
     * Removes a specific query parameter from the URL without reloading the page.
     * @param {string} param - The name of the query parameter to remove.
     */
    function removeQueryParam(param) {
        const url = new URL(window.location);
        url.searchParams.delete(param);
        window.history.replaceState({}, document.title, url.toString());
    }

    /**
     * Initializes the status modal based on URL parameters.
     */
    function initStatusModal() {
        const status = getQueryParam('status');
        if (status) {
            showStatusModal(status);
        }
    }

    /**
     * Initializes the form submission confirmation modal.
     */
    function initFormConfirmation() {
        const form = document.getElementById('productForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Are you sure want to submit?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    focusCancel: true,
                    customClass: {
                        popup: 'dark-transition', // Optional: add your transition class
                        confirmButton: 'bg-indigo-600 text-white',
                        cancelButton: 'bg-gray-300 text-gray-800'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show a loading modal while submitting
                        Swal.fire({
                            title: 'Submitting...',
                            text: 'Please wait while we submit your form.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        // Submit the form after showing the loading modal
                        // Using a slight delay to ensure the loading modal is visible
                        setTimeout(() => {
                            form.submit();
                        }, 1000);
                    }
                    // If canceled, do nothing
                });
            });
        }
    }

    // Initialize both functionalities
    initStatusModal();
    initFormConfirmation();
});
