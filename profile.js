document.addEventListener('DOMContentLoaded', function() {
    fetchProfileData();
});

function fetchProfileData() {
    fetch('adminprofile.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.status) {
            const profileContainer = document.getElementById('profileContainer');

            profileContainer.innerHTML = `
                <form>
                    <fieldset disabled>
                        <legend>My Profile</legend>
                        <div class="mb-3">
                            <label for="disabledTextInput" class="form-label">ID Number</label>
                            <input type="text" id="disabledTextInput" class="form-control" placeholder="ID Number" value="${data.data.AdminID}">
                        </div>
                        <div class="mb-3">
                            <label for="disabledEmailInput" class="form-label">Email</label>
                            <input type="email" id="disabledEmailInput" class="form-control" placeholder="Email" value="${data.data.Email}">
                        </div>
                        <div class="mb-3">
                            <label for="disabledNameInput" class="form-label">Full Name</label>
                            <input type="text" id="disabledNameInput" class="form-control" placeholder="Full Name" value="${data.data.FirstName} ${data.data.LastName}">
                        </div>
                    </fieldset>
                </form>
            `;
        } else {
            console.error('Failed to load profile:', data.message);
        }
    })
    .catch(error => {
        console.error('Error fetching profile data:', error);
    });
}
