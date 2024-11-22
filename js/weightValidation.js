document.addEventListener('DOMContentLoaded', function() {
    const weightInput = document.getElementById('berat');
    const weightUnit = document.getElementById('weightUnit');
    const displayUnit = document.getElementById('displayUnit');
    const weightError = document.getElementById('weightError');
    const weightHelper = document.getElementById('weightHelper');

    // Conversion rates to grams
    const conversions = {
        g: 1,
        kg: 1000,
        mg: 0.001,
        oz: 28.3495,
        lbs: 453.592
    };

    // Unit labels for display
    const unitLabels = {
        g: 'g',
        kg: 'kg',
        mg: 'mg',
        oz: 'oz',
        lbs: 'lbs'
    };

    // Function to format number with commas
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 2,
            minimumFractionDigits: 0
        }).format(num);
    }

    // Function to convert weight to different units
    function convertWeight(value, fromUnit) {
        const inGrams = value * conversions[fromUnit];
        const conversionsText = [];

        for (const [unit, rate] of Object.entries(conversions)) {
            if (unit !== fromUnit) {
                const converted = inGrams / rate;
                if (converted >= 0.01 && converted < 1000000) {  // Only show reasonable conversions
                    conversionsText.push(`${formatNumber(converted)} ${unitLabels[unit]}`);
                }
            }
        }

        weightHelper.textContent = `Setara dengan: ${conversionsText.join(' / ')}`;
    }

    // Function to validate weight input
    function validateWeight(value, unit) {
        const numValue = parseFloat(value);
        
        if (isNaN(numValue)) {
            showError('Masukkan berat yang valid');
            return false;
        }
        
        if (numValue <= 0) {
            showError('Berat harus lebih dari 0');
            return false;
        }

        // Validate based on unit
        switch(unit) {
            case 'kg':
                if (numValue > 1000) {
                    showError('Berat maksimal 1000 kg');
                    return false;
                }
                break;
            case 'g':
                if (numValue > 1000000) {
                    showError('Berat maksimal 1.000.000 g');
                    return false;
                }
                break;
            case 'mg':
                if (numValue > 1000000000) {
                    showError('Berat maksimal 1.000.000.000 mg');
                    return false;
                }
                break;
            case 'oz':
                if (numValue > 35274) {
                    showError('Berat maksimal 35.274 oz');
                    return false;
                }
                break;
            case 'lbs':
                if (numValue > 2204.62) {
                    showError('Berat maksimal 2.204,62 lbs');
                    return false;
                }
                break;
        }

        hideError();
        return true;
    }

    function showError(message) {
        weightError.textContent = message;
        weightError.classList.remove('hidden');
        weightInput.classList.add('border-red-500');
        weightInput.classList.remove('border-green-500');
    }

    function hideError() {
        weightError.classList.add('hidden');
        weightInput.classList.remove('border-red-500');
        weightInput.classList.add('border-green-500');
    }

    // Update display unit when unit changes
    weightUnit.addEventListener('change', function() {
        displayUnit.textContent = unitLabels[this.value];
        if (weightInput.value) {
            validateWeight(weightInput.value, this.value);
            convertWeight(parseFloat(weightInput.value), this.value);
        }
    });

    // Validate and convert on input
    weightInput.addEventListener('input', function() {
        if (this.value) {
            if (validateWeight(this.value, weightUnit.value)) {
                convertWeight(parseFloat(this.value), weightUnit.value);
            }
        } else {
            hideError();
            weightHelper.textContent = '';
        }
    });

    // Initial setup
    displayUnit.textContent = unitLabels[weightUnit.value];

    // Form validation
    weightInput.closest('form').addEventListener('submit', function(e) {
        if (!validateWeight(weightInput.value, weightUnit.value)) {
            e.preventDefault();
            weightInput.focus();
        }
    });
});