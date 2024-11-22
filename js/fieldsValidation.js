// Format currency input for Harga Jual
const hargaInput = document.getElementById('harga_jual');
hargaInput.addEventListener('input', function(e) {
    // Remove non-numeric characters
    let value = this.value.replace(/[^\d]/g, '');
    // Format with thousand separator
    this.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
});

