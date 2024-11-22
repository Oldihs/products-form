document.addEventListener('DOMContentLoaded', function() {
    const addressInput = document.getElementById('alamat');
    const addressError = document.getElementById('addressError');
    const addressSuggestion = document.getElementById('addressSuggestion');

    // Required components for a valid Indonesian address
    const addressComponents = {
        jalan: /jalan|jl\.|gang|gg\.|komplek|komp\./i,
        nomor: /no\.|nomor|[0-9]+/i,
        rt: /rt/i,
        rw: /rw/i,
        kelurahan: /kelurahan|desa/i,
        kecamatan: /kecamatan/i,
        kota: /kota|kabupaten/i,
        provinsi: /(DKI Jakarta|Jawa Barat|Jawa Tengah|Jawa Timur|DI Yogyakarta|Banten|Aceh|Sumatera Utara|Sumatera Barat|Riau|Kepulauan Riau|Jambi|Sumatera Selatan|Bengkulu|Lampung|Bangka Belitung|Kalimantan Barat|Kalimantan Tengah|Kalimantan Selatan|Kalimantan Timur|Kalimantan Utara|Sulawesi Utara|Gorontalo|Sulawesi Tengah|Sulawesi Barat|Sulawesi Selatan|Sulawesi Tenggara|Maluku|Maluku Utara|Papua|Papua Barat)/i,
        kodepos: /\b\d{5}\b/
    };

    let validationTimeout;

    addressInput.addEventListener('input', function() {
        // Clear previous timeout
        clearTimeout(validationTimeout);

        // Set new timeout to validate after user stops typing
        validationTimeout = setTimeout(() => {
            validateAddress(this.value);
        }, 800);
    });

    function validateAddress(address) {
        let missingComponents = [];
        let isValid = true;

        // Check for minimum length
        if (address.length < 20) {
            showError('Alamat terlalu pendek. Mohon masukkan alamat lengkap.');
            showSuggestion();
            return;
        }

        // Check for each component
        if (!addressComponents.jalan.test(address)) {
            missingComponents.push('nama jalan');
            isValid = false;
        }
        if (!addressComponents.nomor.test(address)) {
            missingComponents.push('nomor');
            isValid = false;
        }
        if (!addressComponents.rt.test(address) || !addressComponents.rw.test(address)) {
            missingComponents.push('RT/RW');
            isValid = false;
        }
        if (!addressComponents.kelurahan.test(address)) {
            missingComponents.push('kelurahan/desa');
            isValid = false;
        }
        if (!addressComponents.kecamatan.test(address)) {
            missingComponents.push('kecamatan');
            isValid = false;
        }
        if (!addressComponents.kota.test(address)) {
            missingComponents.push('kota/kabupaten');
            isValid = false;
        }
        if (!addressComponents.provinsi.test(address)) {
            missingComponents.push('provinsi');
            isValid = false;
        }
        if (!addressComponents.kodepos.test(address)) {
            missingComponents.push('kode pos (5 digit)');
            isValid = false;
        }

        // Show or hide error/suggestion based on validation
        if (!isValid) {
            showError(`Alamat kurang lengkap. Mohon tambahkan: ${missingComponents.join(', ')}`);
            showSuggestion();
        } else {
            hideError();
            hideSuggestion();
        }

        // Add or remove validation classes
        if (isValid) {
            addressInput.classList.remove('border-red-500');
            addressInput.classList.add('border-green-500');
        } else {
            addressInput.classList.remove('border-green-500');
            addressInput.classList.add('border-red-500');
        }
    }

    function showError(message) {
        addressError.textContent = message;
        addressError.classList.remove('hidden');
    }

    function hideError() {
        addressError.classList.add('hidden');
    }

    function showSuggestion() {
        addressSuggestion.classList.remove('hidden');
    }

    function hideSuggestion() {
        addressSuggestion.classList.add('hidden');
    }
});