
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('signupButton').addEventListener('click', function () {
        var email = document.getElementsByName('signup-form-email')[0].value;
        var password = document.getElementsByName('signup-form-password')[0].value;
        var confirmPassword = document.getElementsByName('signup-form-confirm-password')[0].value;
        var termsCheckbox = document.getElementById('termsCheckbox');

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        var passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/; // Updated regex to allow symbols

        if (email.trim() === '' || password.trim() === '' || confirmPassword.trim() === '') {
            showAlert('Validation Error', 'Please fill in all fields.');
        } else if (!emailRegex.test(email)) {
            showAlert('Validation Error', 'Please enter a valid email.');
        } else if (!passRegex.test(password)) {
            showAlert('Validation Error', 'Password is not valid.', '<p>At least one lowercase letter<br>' +
                'At least one uppercase letter<br>' +
                'At least one number<br>' +
                'Minimum length of 8 characters</p>');
        } else if (password !== confirmPassword) {
            showAlert('Validation Error', 'Passwords do not match.');
        } else if (!termsCheckbox.checked) {
            showAlert('Validation Error', 'Please accept the terms and conditions.');
        } else {
            showSuccess('Success', 'You have registered successfully.', 'login.html'); // Redirect to login page after successful signup
        }
    });
});

function showAlert(title, text, html = '') {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        confirmButtonText: 'OK',
        background: '#000000',
        confirmButtonColor: '#ff0000',
        iconColor: '#ff0000',
        html: html
    });
}

function showSuccess(title, text, redirectUrl) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'success',
        confirmButtonText: 'OK',
        background: '#000000',
        confirmButtonColor: '#00ff00',
        iconColor: '#00ff00'
    }).then(function () {
        window.location.href = redirectUrl;
    });
}
