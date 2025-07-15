
// // Data for flatpickr
// flatpickr("#task-date", {
//     dateFormat: "Y-m-d",   // Data format
//     locale: "pl"           // Localisatnion
// });

document.addEventListener("DOMContentLoaded", function () {
  const dateInput = document.getElementById("task-date");

  // Inicjalizacja flatpickr
  const picker = flatpickr(dateInput, {
    dateFormat: "Y-m-d",
    locale: "pl"
  });

  // Obsługa kliknięcia w przycisk
  document.getElementById("open-flatpickr").addEventListener("click", function () {
    picker.open(); // <- otwiera kalendarz
  });
});
