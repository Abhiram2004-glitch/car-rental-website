// Simple validation for date/time fields in booking form
document.addEventListener("DOMContentLoaded", () => {
    const bookingForms = document.querySelectorAll("form");

    bookingForms.forEach(form => {
        form.addEventListener("submit", (e) => {
            const startTime = form.querySelector("input[name='start_time']").value;
            const endTime = form.querySelector("input[name='end_time']").value;

            if (new Date(endTime) <= new Date(startTime)) {
                e.preventDefault();
                alert("End time must be after start time.");
            }
        });
    });
});
