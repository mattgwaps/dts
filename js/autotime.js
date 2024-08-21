
document.addEventListener("DOMContentLoaded", function() {
    const timeInput = document.getElementById('denrformtime');

    // Get the current time from the user's browser
    const currentTime = new Date();

    // Extract hours and minutes
    const hours = currentTime.getHours();
    const minutes = currentTime.getMinutes();

    // Format hours for 12-hour clock
    let hours12 = hours % 12 || 12; // Convert 0 to 12

    // Determine AM/PM
    const period = hours < 12 ? 'AM' : 'PM';

    // Format hours and minutes to ensure two digits
    const hoursFormatted = String(hours12).padStart(2, '0');
    const minutesFormatted = String(minutes).padStart(2, '0');

    // Set the value of the time input
    timeInput.value = `${hoursFormatted}:${minutesFormatted} ${period}`;
  });
  
document.addEventListener("DOMContentLoaded", function() {
  const timeInput = document.getElementById('returntime');

  // Get the current time from the user's browser
  const currentTime = new Date();

  // Extract hours and minutes
  const hours = currentTime.getHours();
  const minutes = currentTime.getMinutes();

  // Format hours for 12-hour clock
  let hours12 = hours % 12 || 12; // Convert 0 to 12

  // Determine AM/PM
  const period = hours < 12 ? 'AM' : 'PM';

  // Format hours and minutes to ensure two digits
  const hoursFormatted = String(hours12).padStart(2, '0');
  const minutesFormatted = String(minutes).padStart(2, '0');

  // Set the value of the time input
  timeInput.value = `${hoursFormatted}:${minutesFormatted} ${period}`;
});