<?php
$settings = include __DIR__ . '/../settings.php';
?>
/**
 * Renueva el token de sesión
 */
async function renewToken() {
  let input = '<?= $settings["api"] . $settings["endPoints"]["renewToken"] ?>';
  let token = await getToken();
  console.log('GET: ' + input.toString());
  let response = await window.fetch(input, {
      method: 'GET',
      headers: {
        'Accept': 'application/json',
        'Authorization': 'Bearer ' + token.toString()
      }
    });
  let json = await response.json();
  console.log('token renovado', json.data);
  let expires = '';
  let parts = json.data.split('.');
  if (parts.length > 1) {
    let payload = JSON.parse(atob(parts[1]));
    if(payload.exp) {
      let date = new Date(payload.exp * 1000);
      expires = ';expires=' + date.toUTCString();
    }
  }
  document.cookie = "token=" + json.data + expires + ";path=/";
}
