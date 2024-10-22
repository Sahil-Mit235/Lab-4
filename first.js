document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        if (validateForm()) {
            alert('Form submitted successfully!');
            form.submit();
        }
    });

    function validateForm() {
        let isValid = true;

        const nameInput = document.getElementById('name');
        if (nameInput.value.trim() === '') {
            alert('Please enter your name.');
            isValid = false;
        }

        const emailInput = document.getElementById('email');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(emailInput.value)) {
            alert('Please enter a valid email address.');
            isValid = false;
        }

        const phoneInput = document.getElementById('phone');
        const phonePattern = /^[0-9]{10}$/;
        if (!phonePattern.test(phoneInput.value)) {
            alert('Please enter a valid 10-digit phone number.');
            isValid = false;
        }

        const dobInput = document.getElementById('dob');
        if (dobInput.value === '') {
            alert('Please select your date of birth.');
            isValid = false;
        }

        const genderInput = document.getElementById('gender');
        if (genderInput.value === '') {
            alert('Please select your gender.');
            isValid = false;
        }

        const addressInput = document.getElementById('address');
        if (addressInput.value.trim() === '') {
            alert('Please enter your address.');
            isValid = false;
        }

        return isValid;
    }
});
