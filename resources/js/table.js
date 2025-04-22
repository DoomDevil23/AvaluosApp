document.addEventListener('DOMContentLoaded', function () {
    // Check if there are filters in the URL (query parameters)
    if (window.location.search.includes('idProvincia') || window.location.search.includes('page')) {
        const table = document.getElementById('registersTable');
        if (table) {
            table.scrollIntoView({ behavior: 'smooth' });
        }
    }
});

//THIS DONT BELONG TO THIS NAME,
// BUT I COULD RENAME THIS FILE TO ELEMENT BEHAVIOR OR SOMETHING SIMILAR TO HANDLE ALL ELEMENTS THAT HAS VIEWS THAT CREATE, UPDATE, QUERY OR DELETE REGISTERS
//FUNCTION TO REMOVE ALERT MESSAGES AFTER SOME TIME
document.addEventListener('DOMContentLoaded', () => {
    const alerts = document.querySelectorAll('[class^="alert-"]'); // Select all alert divs

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.classList.add('fade-out'); // Apply fade-out animation
            setTimeout(() => alert.remove(), 500); // Remove element after animation
        }, 10000); // 10-second timeout
    });
});