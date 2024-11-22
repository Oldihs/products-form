document.addEventListener('DOMContentLoaded', function() {
    const descriptionInput = document.getElementById('deskripsi');
    const descriptionError = document.getElementById('descriptionError');
    const wordCount = document.getElementById('wordCount');
    const minWords = 10;

    let validationTimeout;

    // Function to count words
    function countWords(str) {
        // Remove extra spaces and trim
        str = str.replace(/\s+/g, ' ').trim();
        return str === '' ? 0 : str.split(' ').length;
    }

    // Function to validate description
    function validateDescription(text) {
        const words = countWords(text);
        wordCount.textContent = `${words} kata`;

        if (words === 0) {
            descriptionError.textContent = 'Deskripsi tidak boleh kosong';
            descriptionError.classList.remove('hidden');
            descriptionInput.classList.add('border-red-500');
            descriptionInput.classList.remove('border-green-500');
            return false;
        } else if (words < minWords) {
            descriptionError.textContent = `Deskripsi minimal ${minWords} kata (kurang ${minWords - words} kata lagi)`;
            descriptionError.classList.remove('hidden');
            descriptionInput.classList.add('border-red-500');
            descriptionInput.classList.remove('border-green-500');
            return false;
        } else {
            descriptionError.classList.add('hidden');
            descriptionInput.classList.remove('border-red-500');
            descriptionInput.classList.add('border-green-500');
            return true;
        }
    }

    // Add input event listener with debounce
    descriptionInput.addEventListener('input', function() {
        clearTimeout(validationTimeout);

        // Set new timeout to validate after user stops typing
        validationTimeout = setTimeout(() => {
            validateDescription(this.value);
        }, 500);
    });

    // Validate on form submission
    descriptionInput.closest('form').addEventListener('submit', function(e) {
        if (!validateDescription(descriptionInput.value)) {
            e.preventDefault();
            descriptionInput.focus();
        }
    });

    // Initial validation
    if (descriptionInput.value.trim() !== '') {
        validateDescription(descriptionInput.value);
    } else {
        descriptionInput.classList.remove('border-red-500');
        descriptionInput.classList.remove('border-green-500');
    }
});