const filters = document.querySelectorAll('.filter');
const applyButton = document.getElementById('apply-filters');
const clearButton = document.getElementById('clear-filters');
const tableDiv = document.querySelector('.table-div');

// filter dropdown behavior
filters.forEach(filter => {
    const item = filter.querySelector('.filter-item');
    const optionsContainer = filter.querySelector('.filter-options');
    const searchInput = filter.querySelector('.filter-search');
    const optionItems = [...optionsContainer.querySelectorAll('.filter-option')];

    item.addEventListener('click', (e) => {
        e.stopPropagation();
        filter.classList.toggle('active');
        if (searchInput && filter.classList.contains('active')) {
            searchInput.focus();
        }
    });

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const filterText = searchInput.value.toLowerCase();
            optionItems.forEach(option => {
                option.style.display = option.textContent.toLowerCase().includes(filterText) ? '' : 'none';
            });
        });
    }

    optionItems.forEach(option => {
        option.addEventListener('click', () => {
            const isSort = item.textContent.trim() === 'Sort';
            if (isSort) {
                filter.querySelectorAll('.filter-option.selected').forEach(opt => opt.classList.remove('selected'));
            }
            option.classList.toggle('selected');
        });
    });
});

// Fetch table data
function fetchTable(filtersObj = {}) {
    tableDiv.innerHTML = ''; // clear

    // create spinner
    const spinner = document.createElement('div');
    spinner.className = 'table-spinner';
    spinner.innerHTML = '<div></div>'; // inner div for spinner
    tableDiv.appendChild(spinner);

    fetch('api/get_student_answers.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(filtersObj)
    })
    .then(res => res.json())
    .then(data => {
        // only rowSpan student cards if not sorted by question
        const useRowSpan = !filtersObj['Sort'] || filtersObj['Sort'] !== 'Question';
        populateTable(data, useRowSpan);
    })
    .catch(err => {
        console.error(err);
        tableDiv.textContent = 'Error loading data';
    });
}

// apply filters
applyButton.addEventListener('click', () => {
    const selectedFilters = {};
    let sortValue = null;

    filters.forEach(filter => {
        const filterName = filter.querySelector('.filter-item').textContent.trim();
        const selectedOptions = [...filter.querySelectorAll('.filter-option.selected')]
            .map(opt => opt.dataset.value);

        if (filterName === 'Sort') {
            if (selectedOptions.length === 1) sortValue = selectedOptions[0];
        } else if (selectedOptions.length) {
            selectedFilters[filterName] = selectedOptions;
        }
    });

    if (sortValue) selectedFilters['Sort'] = sortValue;

    fetchTable(selectedFilters);
});

// clear filters and apply automatically
clearButton.addEventListener('click', () => {
    filters.forEach(filter => {
        // remove selected options
        filter.querySelectorAll('.filter-option.selected')
              .forEach(opt => opt.classList.remove('selected'));
        // clear search inputs
        const searchInput = filter.querySelector('.filter-search');
        if (searchInput) searchInput.value = '';
        // show all options
        filter.querySelectorAll('.filter-option').forEach(opt => opt.style.display = '');
    });

    // fetch table with no filters or sort applied
    fetchTable({});
});

function populateTable(data, useRowSpan = true) {
    tableDiv.textContent = '';

    if (!data.length) {
        tableDiv.textContent = 'No results';
        return;
    }

    const table = document.createElement('table');

    const hiddenStudentFields = ['name', 'major', 'section', 'term'];
    const keys = Object.keys(data[0]).filter(key => !hiddenStudentFields.includes(key));

    // header
    const thead = document.createElement('thead');
    const headerRow = thead.insertRow();
    keys.forEach(key => {
        const th = document.createElement('th');
        th.textContent = key === 'student_id' ? 'Student' : key;
        headerRow.appendChild(th);
    });
    table.appendChild(thead);

    // body
    const tbody = document.createElement('tbody');
    let lastId = null;

    data.forEach((row, rowIndex) => {
        const tr = tbody.insertRow();

        keys.forEach(key => {
            const td = tr.insertCell();
            td.style.padding = '6px';
            td.style.verticalAlign = 'top';

            if (key === 'student_id') {
                const card = document.createElement('div');
                card.classList.add('student-card');
                card.innerHTML = `
                    <div class="student-id">${row.student_id}</div>
                    <div class="student-line"><strong>Name: </strong>${row.name}</div>
                    <div class="student-line"><strong>Major: </strong>${row.major}</div>
                    <div class="student-line"><strong>Section: </strong>${row.section}</div>
                    <div class="student-line"><strong>Term: </strong>${row.term}</div>
                `;
                td.appendChild(card);

                if (useRowSpan && row.student_id !== lastId) {
                    const nextRows = data.slice(rowIndex).filter(r => r.student_id === row.student_id);
                    td.rowSpan = nextRows.length;
                } else if (useRowSpan && row.student_id === lastId) {
                    td.style.display = 'none';
                }
            } else {
                td.textContent = row[key];
            }
        });

        lastId = row.student_id;
    });

    table.appendChild(tbody);
    tableDiv.appendChild(table);
}

// initial table load
fetchTable();
