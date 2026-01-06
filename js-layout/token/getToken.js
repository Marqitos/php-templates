/**
  * Searches for a JWT token and validates it
  *
  * @returns Token string, or undefined
  */
function getToken() {
  // Search in cookies
  let token = document.cookie.replace(
    /(?:(?:^|.*;\s*)token\s*\=\s*([^;]*).*$)|^.*$/,
    "$1",
  );

  if (token == undefined ||
      token == '') { // Token not found in cookies
    // Search in local storage
    token = sessionStorage.getItem('token') ?? localStorage.getItem('token');
  }

  if (token != undefined) {
    try {
      token = new JWToken(token);
    } catch (error) {
      console.error(error);
      let ru = logout();
      throw new TokenError("Token no válido", ru);
    }
    if(token.exp()) { // Token has expired
      let ru = logout();
      throw new TokenExpiredError("Token expirado", ru);
    }
  }

  return token;
}
