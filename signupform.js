function validatePassword(password) {
    const minLength = /.{7,}/;
    const hasCapital = /[A-Z]/;
    const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/;
    const hasNumber = /[0-9]/;

    return minLength.test(password) && hasCapital.test(password) &&
           hasSpecialChar.test(password) && hasNumber.test(password);
}

function validateEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function validatePhoneNumber(phone) {
    const phonePattern = /^\+?\d{10,15}$/;
    return phonePattern.test(phone);
}

function validateUsername(username) {
    const usernamePattern = /^[a-zA-Z0-9]{5,15}$/;
    return usernamePattern.test(username);
}

function validatePasswords(password, confirmPassword) {
    return password === confirmPassword;
}

function validateForm(event) {
    const username = document.getElementById('username').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    const errorMessages = [];

    if (!validateUsername(username)) {
        errorMessages.push('Username must be 5-15 alphanumeric characters.');
    }

    if (!validateEmail(email)) {
        errorMessages.push('Please enter a valid email address.');
    }

    if (!validatePhoneNumber(phone)) {
        errorMessages.push('Phone number must be 10-15 digits and may include an optional +.');
    }

    if (!validatePassword(password)) {
        errorMessages.push('Password must be at least 7 characters long and include one uppercase letter, one special character, and one number.');
    }

    if (!validatePasswords(password, confirmPassword)) {
        errorMessages.push('Passwords do not match.');
    }

    if (errorMessages.length > 0) {
        event.preventDefault(); // Prevent form submission
        alert(errorMessages.join('\n')); // Display errors
    }
}

window.onload = function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', validateForm);
};
