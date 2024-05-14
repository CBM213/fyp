document.addEventListener('DOMContentLoaded', function() {
    fetchCategories(); // Fetch categories when the DOM is fully loaded

    var searchInput = document.querySelector('.main-search-input-item input');
    var searchButton = document.querySelector('.main-search-button');

    if (searchInput) {
        searchInput.addEventListener('input', function() {
            searchCategories();
        });

        searchInput.addEventListener('keypress', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault(); // Prevent form submission on Enter
            }
        });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default button click behavior
            searchCategories();
        });
    }
});

function fetchCategories() {
    fetch('getCategories.php')
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        return response.json();
    })
    .then(data => {
        if (data.error) {
            console.error('Error fetching categories:', data.error);
            return;
        }
        const tableBody = document.querySelector('#categories-list tbody');
        tableBody.innerHTML = ''; // Clear the table first
        data.forEach(category => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${category.CatName}</td>
                <td>${category.Quantity}</td>
            `;
            tableBody.appendChild(tr);
        });
    })
    .catch(error => {
        console.error('Failed to fetch categories:', error);
    });
}

function searchCategories() {
    var searchText = document.querySelector('.main-search-input-item input').value.toLowerCase();
    var rows = document.querySelectorAll('#categories-list tbody tr');

    rows.forEach(function(row) {
        var categoryName = row.cells[0].textContent.toLowerCase(); // Assuming the category name is in the first cell
        if (searchText === '' || categoryName.includes(searchText)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
