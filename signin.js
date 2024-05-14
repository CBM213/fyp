document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form'); 

    form.addEventListener('submit', function(event) {
        event.preventDefault(); 

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            alert('Please fill in all fields.');
            return;
        }

        const formData = new FormData();
        formData.append('email', email);
        formData.append('password', password);

        fetch('admin.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => { 
            if (data.status) {
                window.location.href = data.redirect; // Redirect to the URL sent in the response
            } else {
                alert(data.message); // Show error message
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request. Please try again.');
        });
        
    });
});
