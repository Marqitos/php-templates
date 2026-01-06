/**
  * Stores JWT token information
  */
class JWToken {
  constructor(tokenString) {
    this.tokenString = tokenString;
    let parts = tokenString.split('.');
    if (parts.length > 1) {
      this.payload = JSON.parse(atob(parts[1]));
    } else {
      throw new TokenError("Invalid token");
    }
    this.signed = parts.length == 3;
  }
  exp() {
    if(this.payload.exp) { // If expiration date is set, check token validity
      let date = new Date(this.payload.exp * 1000);
      let now = new Date();
      return date < now;
    }
    return false; // If no expiration date, it's not expired
  }
  toString() {
    return this.tokenString;
  }
}
