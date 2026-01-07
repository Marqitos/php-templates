/**
  * Comprueba si hay un código de error en una respuest de la API
  * 
  * @author Marcos Porto
  */

// Códigos de error
const noToken         = 0x0004; // No se ha recibido el token
const tokenError      = 0x0008; // El token no es válido
const tokenIsExpired  = 0x000c; // El token está expirado
const noPermissions   = 0x0010; // No tiene permisos para realizar la acción
const tokenRenew      = 0x0020; // Debe renovar el token
const filterToken     = 0x003c; // Filtro con todos los valores posibles

/**
  * Comprueba si la respuesta a una solicitud ha
  * indicado un error en el token,
  * También lo actualiza si la solicitud lo indica
  *
  * @param    {object}            json  Respuesta a una solicitud a la API
  * @returns  {bool}                    true si no hay errores en el token
  * @throws   {TokenError}              Si el token no es válido
  * @throws   {TokenExpiredError}       Si la sesión ha caducado
  * @throws   {PermissionError}         Si el usuario no tiene permisos para realizar dicha acción
  */
function checkToken(json) {
  let error = json.error & filterToken;
  let renew = (error & tokenRenew) != 0;
  if (renew) {
    renewToken();
  }
  // Token no válido
  if (error === noToken ||
      error === tokenError) {
    throw new TokenError(json.message);
  } else if(error === tokenIsExpired) { // Token expirado
    throw new TokenExpiredError(json.message);
  } else if (error === noPermissions) {
    console.warn("No tiene permisos para realizar esa acción:", json.message);
    throw new PermissionError(json.message);
  }
  return true;
}