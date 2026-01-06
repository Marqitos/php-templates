/**
  * Represents an expired token error
  */
class TokenExpiredError extends TokenError {
  constructor(message = "", url = undefined) {
    super(message, url);
    this.name = "TokenExpiredError";
  }
}
