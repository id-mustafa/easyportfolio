document.addEventListener("DOMContentLoaded", function() {
    var currentDate = new Date();
    var formattedDate = currentDate.toLocaleString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        second: 'numeric',
        hour12: true
    });
    document.getElementById("lastUpdated").textContent = formattedDate;
});
