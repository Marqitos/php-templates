<?php
$settings = include __DIR__ . '/../settings.php';
?>
/**
  * Realiza una solicitud a la API mediante GET
  *
  * @param {string} url EndPoint al que realizar la petición, ruta relativa
  * @param {object} params Parámetros enviados como Query Params
  * @returns {object} Datos devueltos por la solicitud
  */
async function requestGet(url, params = {}) {
  let lang = sessionStorage.getItem('language') ?? localStorage.getItem('language');
  let input = new URL('<?= $settings["api"] ?>' + url);
  Object.entries(params).forEach(([key, value]) => input.searchParams.append(key, value));
  console.log('GET: ' + input.toString());
  let response = await window.fetch(input.toString(), {
      method: 'GET',
      headers: {
        'Accept-Language': lang,
        'Accept': 'application/json'
      }
    });
  return await response.json();
}
