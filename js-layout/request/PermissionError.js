/**
  * Representa un error de permisos al realizar una solicitud
  *
  */
class PermissionError extends Error {
  constructor(message, errorCode) {
    super(message);
    this.name = "PermissionError";
    if (errorCode) {
      this.errorCode = errorCode;
    }
  }
}
