/**
  * Represents a token error
  */
class TokenError extends Error {
  constructor(message = "", url = undefined) {
    super(message, url);
    this.name = "TokenError";
    this.url = url;
  }
}
