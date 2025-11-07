const filters = document.querySelectorAll('.filter');
const applyButton = document.getElementById('apply-filters');
const clearButton = document.getElementById('clear-filters');
const tableDiv = document.querySelector('.table-div');

filters.forEach(filter => {
    const item = filter.querySelector('.filter-item');
    const optionsContainer = filter.querySelector('.filter-options');
    const searchInput = filter.querySelector('.filter-search');
    const optionItems = [...optionsContainer.querySelectorAll('.filter-option')];

    // toggle dropdown when clicking the filter
    item.addEventListener('click', (e) => {
        e.stopPropagation();
        filter.classList.toggle('active');
        if (filter.classList.contains('active')) searchInput.focus();
    });

    // filter options
    searchInput.addEventListener('input', () => {
        const filterText = searchInput.value.toLowerCase();
        optionItems.forEach(option => {
            option.style.display = option.textContent.toLowerCase().includes(filterText) ? '' : 'none';
        });
    });

    // toggle options
    optionItems.forEach(option => {
        option.addEventListener('click', () => {
            option.classList.toggle('selected');
        });
    });
});

// fetches populated table
function fetchTable(filters = {}) {
    tableDiv.textContent = 'Loading...';

    fetch('api/get_student_answers.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(filters)
    })
    .then(res => res.json())
    .then(data => populateTable(data))
    .catch(err => {
        console.error(err);
        tableDiv.textContent = 'Error loading data';
    });
}

// applies filters
applyButton.addEventListener('click', () => {
    const selectedFilters = {};

    filters.forEach(filter => {
        const filterName = filter.querySelector('.filter-item').textContent.trim();
        const selectedOptions = [...filter.querySelectorAll('.filter-option.selected')]
            .map(opt => opt.dataset.value);
        if (selectedOptions.length) selectedFilters[filterName] = selectedOptions;
    });

    fetchTable(selectedFilters);
});

// clears filters
clearButton.addEventListener('click', () => {
    filters.forEach(filter => {
        filter.querySelectorAll('.filter-option.selected').forEach(opt => opt.classList.remove('selected'));
        filter.querySelector('.filter-search').value = '';
        filter.querySelectorAll('.filter-option').forEach(opt => opt.style.display = '');
    });

    fetchTable(); // no filters
});

// populates the table with student answers
function populateTable(data) {
    tableDiv.textContent = '';

    if (!data.length) {
        tableDiv.textContent = 'No results';
        return;
    }

    const table = document.createElement('table');
    table.style.width = '100%';
    table.style.borderCollapse = 'collapse';

    // header row
    const header = table.insertRow();
    Object.keys(data[0]).forEach(key => {
        const th = document.createElement('th');
        th.textContent = key;
        th.style.border = '1px solid #ccc';
        th.style.padding = '6px';
        header.appendChild(th);
    });

    // data rows
    let lastId = null;

    data.forEach((row, rowIndex) => {
        const tr = table.insertRow();
        const values = Object.values(row);

        const nextRow = data[rowIndex + 1];
        const isLastRowForId = !nextRow || nextRow[Object.keys(nextRow)[0]] !== row[Object.keys(row)[0]];

        values.forEach((value, colIndex) => {
            const td = tr.insertCell();
            td.style.borderLeft = '1px solid #ccc';
            td.style.borderRight = '1px solid #ccc';
            td.style.padding = '6px';

            if (colIndex === 0) {
                if (value !== lastId) {
                    td.textContent = value;
                    td.style.borderTop = '1px solid #ccc';
                } else {
                    td.textContent = '';
                    td.style.borderTop = '0';
                }
                td.style.borderBottom = isLastRowForId ? '1px solid #ccc' : '0';
                lastId = value !== lastId ? value : lastId;
            } else {
                td.textContent = value;
                td.style.borderTop = '1px solid #ccc';
                td.style.borderBottom = isLastRowForId ? '1px solid #ccc' : '0';
            }

            tr.appendChild(td);
        });
    });

    tableDiv.appendChild(table);
}

// show table on load
fetchTable();
