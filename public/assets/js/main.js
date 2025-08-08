
// // Data for flatpickr
// flatpickr("#task-date", {
//     dateFormat: "Y-m-d",   // Data format
//     locale: "pl"           // Localisatnion
// });

document.addEventListener("DOMContentLoaded", function () {
  const dateInput = document.getElementById("task-date");

  // flatpickr initialization
  const picker = flatpickr(dateInput, {
    dateFormat: "Y-m-d",
    locale: "pl"
  });

  // Button to open the flatpickr calendar
  document.getElementById("open-flatpickr").addEventListener("click", function () {
    picker.open(); // <- otwiera kalendarz
  });
});


