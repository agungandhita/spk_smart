<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle password visibility
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeOpen = document.getElementById('eyeOpen');
        const eyeClosed = document.getElementById('eyeClosed');

        if (togglePassword) {
            togglePassword.addEventListener('click', function() {
                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                password.setAttribute('type', type);
                
                eyeOpen.classList.toggle('d-none');
                eyeClosed.classList.toggle('d-none');
            });
        }

        // Handle role selection for registration form
        const roleSelect = document.getElementById('role');
        const mahasiswaFields = document.getElementById('mahasiswa-fields');
        const dosenFields = document.getElementById('dosen-fields');
        const commonFields = document.getElementById('common-fields');

        if (roleSelect) {
            // Function to toggle fields based on role
            function toggleFields() {
                const selectedRole = roleSelect.value;
                
                // Hide all fields first
                if (mahasiswaFields) mahasiswaFields.style.display = 'none';
                if (dosenFields) dosenFields.style.display = 'none';
                if (commonFields) commonFields.style.display = 'none';
                
                // Clear required attributes
                clearRequiredAttributes();
                
                if (selectedRole === 'mahasiswa') {
                    if (mahasiswaFields) mahasiswaFields.style.display = 'block';
                    if (commonFields) commonFields.style.display = 'block';
                    setMahasiswaRequired();
                } else if (selectedRole === 'dosen') {
                    if (dosenFields) dosenFields.style.display = 'block';
                    if (commonFields) commonFields.style.display = 'block';
                    setDosenRequired();
                }
            }
            
            function clearRequiredAttributes() {
                // Remove required from all conditional fields
                const allInputs = document.querySelectorAll('#mahasiswa-fields input, #dosen-fields input, #common-fields input, #common-fields select, #common-fields textarea');
                allInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
            
            function setMahasiswaRequired() {
                // Set required for mahasiswa fields
                const requiredFields = ['nim', 'tahun_masuk', 'alamat', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'prodi', 'fakultas'];
                requiredFields.forEach(fieldName => {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (field) field.setAttribute('required', 'required');
                });
            }
            
            function setDosenRequired() {
                // Set required for dosen fields
                const requiredFields = ['nidn', 'pendidikan_terakhir', 'tahun_bergabung', 'alamat', 'tanggal_lahir', 'tempat_lahir', 'jenis_kelamin', 'prodi', 'fakultas'];
                requiredFields.forEach(fieldName => {
                    const field = document.querySelector(`[name="${fieldName}"]`);
                    if (field) field.setAttribute('required', 'required');
                });
            }
            
            // Initial call to set correct fields on page load
            toggleFields();
            
            // Listen for role changes
            roleSelect.addEventListener('change', toggleFields);
        }
    });
</script>
