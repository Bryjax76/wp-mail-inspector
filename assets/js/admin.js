document.addEventListener('click', function (e) {

    // MESSAGE toggle
    if (e.target.classList.contains('wmi-toggle')) {
        const content = e.target.previousElementSibling;

        content.classList.toggle('wmi-message-short');

        e.target.textContent = content.classList.contains('wmi-message-short')
            ? 'Czytaj więcej'
            : 'Zwiń';
    }

    // ERROR toggle
    if (e.target.classList.contains('wmi-toggle-error')) {
        const content = e.target.previousElementSibling;

        content.classList.toggle('wmi-error-short');

        e.target.textContent = content.classList.contains('wmi-error-short')
            ? 'Pokaż błąd'
            : 'Zwiń';
    }
});