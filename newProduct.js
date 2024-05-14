document.getElementById('add-category-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var prodName = document.getElementById('prod-name').value;
    var catName = document.getElementById('cat-name').value;
    var prodPrice = document.getElementById('prod-price').value;
    var prodQuantity = document.getElementById('prod-quantity').value;

    var formData = new FormData();
    formData.append('CatName', catName);
    formData.append('ProdName', prodName); // Make sure this matches the $_POST key in PHP
    formData.append('Quantity', prodQuantity);
    formData.append('Price', prodPrice);  // Make sure this matches the $_POST key in PHP

    fetch('addProduct.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert('Error: ' + data.error);
        } else {
            window.location.href = 'productslist.php'; // Redirect back to categories list
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to add Product: ' + error.message);
    });
});
