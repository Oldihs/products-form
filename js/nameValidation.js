document.addEventListener('DOMContentLoaded', function() {
    const nameInput = document.getElementById('nama_pimpinan');

    // Function to validate the name
    function validateName(name) {
        if (name.length < 5) {
            nameInput.classList.remove('border-green-500');
            nameInput.classList.add('border-red-500');
            return false;
        } else {
            nameInput.classList.remove('border-red-500');
            nameInput.classList.add('border-green-500');
            return true;
        }
    }

    // Add input event listener with debounce
    let validationTimeout;
    nameInput.addEventListener('input', function() {
        clearTimeout(validationTimeout);

        // Set new timeout to validate after user stops typing
        validationTimeout = setTimeout(() => {
            validateName(this.value);
        }, 500);
    });

    // Validate on form submission
    nameInput.closest('form').addEventListener('submit', function(e) {
        if (!validateName(nameInput.value)) {
            e.preventDefault();
            nameInput.focus();
        }
    });

    // Initial validation
    if (nameInput.value.trim() !== '') {
        validateName(nameInput.value);
    } else {
        nameInput.classList.remove('border-red-500');
        nameInput.classList.remove('border-green-500');
    }
});