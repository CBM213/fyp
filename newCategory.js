document.getElementById('add-category-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var catName = document.getElementById('cat-name').value;
    var catDesc = document.getElementById('cat-desc').value;
    var catQuantity = document.getElementById('cat-quantity').value;

    var formData = new FormData();
    formData.append('CatName', catName);
    formData.append('Description', catDesc); // Make sure this matches the $_POST key in PHP
    formData.append('Quantity', catQuantity); // Make sure this matches the $_POST key in PHP

    fetch('addCategory.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            window.location.href = 'categorieslist.php'; // Redirect back to categories list
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add category: ' + error.message);
    });
});
