document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('harga_jual');
    const currencySelect = document.getElementById('currency');
    const currencySymbol = document.getElementById('currencySymbol');
    const priceError = document.getElementById('priceError');
    const priceInWords = document.getElementById('priceInWords');
    const priceConversion = document.getElementById('priceConversion');

    // Currency configuration
    const currencies = {
        IDR: { symbol: 'Rp', rate: 1, format: 'id-ID', maxDigits: 0 },
        USD: { symbol: '$', rate: 0.000064, format: 'en-US', maxDigits: 2 },
        EUR: { symbol: '€', rate: 0.000059, format: 'de-DE', maxDigits: 2 },
        GBP: { symbol: '£', rate: 0.000051, format: 'en-GB', maxDigits: 2 },
        JPY: { symbol: '¥', rate: 0.0095, format: 'ja-JP', maxDigits: 0 },
        SGD: { symbol: 'S$', rate: 0.000086, format: 'en-SG', maxDigits: 2 },
        AUD: { symbol: 'A$', rate: 0.000098, format: 'en-AU', maxDigits: 2 }
    };

    // Format number based on currency
    function formatNumber(value, currency) {
        const config = currencies[currency];
        return new Intl.NumberFormat(config.format, {
            maximumFractionDigits: config.maxDigits,
            minimumFractionDigits: config.maxDigits
        }).format(value);
    }

    // Convert number to words (for IDR)
    function numberToWords(num) {
        const units = ['', 'ribu', 'juta', 'miliar', 'triliun'];
        const digits = ['nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
        
        if (num === 0) return 'nol rupiah';
        
        let words = '';
        let unitIndex = 0;
        
        while (num > 0) {
            const segment = num % 1000;
            if (segment !== 0) {
                const segmentWords = [];
                
                // Hundreds
                const hundreds = Math.floor(segment / 100);
                if (hundreds > 0) {
                    segmentWords.push(hundreds === 1 ? 'seratus' : (digits[hundreds] + ' ratus'));
                }
                
                // Tens and ones
                const remainder = segment % 100;
                if (remainder > 0) {
                    if (remainder < 10) {
                        segmentWords.push(digits[remainder]);
                    } else if (remainder === 10) {
                        segmentWords.push('sepuluh');
                    } else if (remainder === 11) {
                        segmentWords.push('sebelas');
                    } else if (remainder < 20) {
                        segmentWords.push(digits[remainder % 10] + ' belas');
                    } else {
                        const tens = Math.floor(remainder / 10);
                        const ones = remainder % 10;
                        segmentWords.push(digits[tens] + ' puluh' + (ones > 0 ? ' ' + digits[ones] : ''));
                    }
                }
                
                words = segmentWords.join(' ') + (units[unitIndex] ? ' ' + units[unitIndex] : '') + 
                        (words ? ' ' + words : '');
            }
            
            num = Math.floor(num / 1000);
            unitIndex++;
        }
        
        return words + ' rupiah';
    }

    // Handle price input
    let timeout;
    priceInput.addEventListener('input', function(e) {
        // Remove non-numeric characters except decimal point
        let value = this.value.replace(/[^\d.]/g, '');
        
        // Ensure only one decimal point
        const parts = value.split('.');
        if (parts.length > 2) value = parts[0] + '.' + parts.slice(1).join('');
        
        // Update input value
        this.value = value;
        
        clearTimeout(timeout);
        timeout = setTimeout(() => validateAndFormatPrice(value), 500);
    });

    function validateAndFormatPrice(value) {
        const numValue = parseFloat(value);
        const currency = currencySelect.value;
        
        if (isNaN(numValue) || numValue <= 0) {
            showError('Masukkan harga yang valid');
            return false;
        }

        // Validate maximum values
        const maxValues = {
            IDR: 999999999999,  // 999 billion
            USD: 1000000,       // 1 million
            EUR: 1000000,
            GBP: 1000000,
            JPY: 100000000,     // 100 million
            SGD: 1000000,
            AUD: 1000000
        };

        if (numValue > maxValues[currency]) {
            showError(`Nilai maksimum untuk ${currency} adalah ${formatNumber(maxValues[currency], currency)}`);
            return false;
        }

        hideError();
        
        // Format price in words (only for IDR)
        if (currency === 'IDR') {
            priceInWords.textContent = numberToWords(Math.floor(numValue));
        } else {
            priceInWords.textContent = '';
        }

        // Show conversion to other currencies
        showConversions(numValue, currency);
        
        return true;
    }

    function showConversions(value, fromCurrency) {
        const baseValue = value / currencies[fromCurrency].rate; // Convert to IDR first
        const conversions = [];

        Object.entries(currencies).forEach(([currency, config]) => {
            if (currency !== fromCurrency) {
                const convertedValue = baseValue * config.rate;
                if (convertedValue > 0.01 && convertedValue < currencies[currency].maxValue) {
                    conversions.push(`${config.symbol}${formatNumber(convertedValue, currency)} ${currency}`);
                }
            }
        });

        priceConversion.textContent = conversions.length > 0 ? 
            `≈ ${conversions.join(' / ')}` : '';
    }

    function showError(message) {
        priceError.textContent = message;
        priceError.classList.remove('hidden');
        priceInput.classList.add('border-red-500');
        priceInput.classList.remove('border-green-500');
    }

    function hideError() {
        priceError.classList.add('hidden');
        priceInput.classList.remove('border-red-500');
        priceInput.classList.add('border-green-500');
    }

    // Handle currency change
    currencySelect.addEventListener('change', function() {
        const currency = this.value;
        currencySymbol.textContent = currencies[currency].symbol;
        
        if (priceInput.value) {
            validateAndFormatPrice(priceInput.value);
        }
    });

    // Initialize currency symbol
    currencySymbol.textContent = currencies[currencySelect.value].symbol;

    // Form validation
    priceInput.closest('form').addEventListener('submit', function(e) {
        if (!validateAndFormatPrice(priceInput.value)) {
            e.preventDefault();
            priceInput.focus();
        }
    });
});