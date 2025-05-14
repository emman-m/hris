document.addEventListener('DOMContentLoaded', function() {
    // Get current theme
    const theme = localStorage.getItem('tablerTheme') || 'light';

    // Initialize Tom Select
    const recipientsSelect = new TomSelect('#recipients', {
        plugins: ['remove_button'],
        valueField: 'id',
        labelField: 'name',
        searchField: ['name'],
        create: false,
        maxItems: null,
        load: function(query, callback) {
            const url = `${searchUserUrl}?search=${encodeURIComponent(query)}&page=1`;
            
            // Show loading state
            this.settings.loadingClass = 'loading';
            this.wrapper.classList.add(this.settings.loadingClass);
            
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.items);
                }).catch(() => {
                    callback();
                })
                .finally(() => {
                    // Remove loading state
                    this.wrapper.classList.remove(this.settings.loadingClass);
                });
        },
        render: {
            option: function(item, escape) {
                return `<div class="py-2">
                    <div class="font-weight-medium">${escape(item.name)}</div>
                </div>`;
            },
            no_results: function() {
                return '<div class="py-2">No results found</div>';
            },
            loading: function() {
                return '<div class="py-2">Searching...</div>';
            }
        },
        onInitialize: function() {
            // Set theme
            this.control.classList.add(theme === 'dark' ? 'ts-dark' : 'ts-light');
        },
        onItemAdd: function() {
            this.setTextboxValue('');
        },
        onDropdownClose: function() {
            // Ensure the select element has the selected values
            const select = document.getElementById('recipients');
            const selectedValues = this.getValue();
            
            // Clear existing options
            while (select.options.length > 0) {
                select.remove(0);
            }
            
            // Add selected values as options
            selectedValues.forEach(value => {
                const option = document.createElement('option');
                option.value = value;
                option.selected = true;
                select.appendChild(option);
            });
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const selectedValues = recipientsSelect.getValue();
        if (selectedValues.length === 0) {
            e.preventDefault();
            alert('Please select at least one recipient');
            recipientsSelect.focus();
        }
    });

    // Listen for theme changes
    // document.addEventListener('themeChange', function(e) {
    //     const newTheme = e.detail.theme;
    //     recipientsSelect.control.classList.remove('ts-dark', 'ts-light');
    //     recipientsSelect.control.classList.add(newTheme === 'dark' ? 'ts-dark' : 'ts-light');
    // });
});

