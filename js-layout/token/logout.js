/**
  * Deletes token information
  */
function logout() {
  // Remove token
  document.cookie = 'token=;max-age=-1;path=/';
  // Remove stored data
  localStorage.clear();
  sessionStorage.clear();
  // Redirect to login page
  document.location.href = '/login';
}
