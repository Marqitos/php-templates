<?php
$settings = include __DIR__ . '/../settings.php';
?>
/**
  * Realiza una solicitud a la API mediante POST, utilizando autenticación mediante token JWT
  *
  * @param {string} url EndPoint al que realizar la petición, ruta relativa
  * @param {object} data Objeto a enviar en el cuerpo de la petición
  * @param {object} params Parámetros enviados como Query Params
  * @returns {object} Datos devueltos por la solicitud
  */
 async function requestAuthPost(url, data, params = {}) {
  let lang = sessionStorage.getItem('language') ?? localStorage.getItem('language');
  let input = new URL('<?= $settings["api"] ?>' + url);
  let token = await getToken();
  if (token == undefined) {
    throw new TokenError("No se ha encontrado el token");
  }
  Object.entries(params).forEach(([key, value]) => input.searchParams.append(key, value));
  let response = await window.fetch(input.toString(), {
      method: 'POST',
      headers: {
        'Accept-Language': lang,
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'Authorization': 'Bearer ' + token.toString()
      },
      body: JSON.stringify(data)
    });
  let json = await response.json();
  if (json.error) {
    checkToken(json);
  }
  return json;
}
