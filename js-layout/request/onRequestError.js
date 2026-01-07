/**
 * Muestra un mensaje en pantalla, usando Syncfusion.Message,
 * Muestra un boton de reintentar, que vuelve a realizar la consulta a la API y oculta el mensaje
 */
function onRequestError(errorCode, message, request, endPoint, success, container) {
  console.error(errorCode, message, typeof(message));
  let retryLink = document.createElement('a');
  retryLink.href = "javascript:void(0);"
  retryLink.id = "retryLink";
  retryLink.innerText = "Reintentar";

  let msg = new SyncfusionNotifications.Message({
    content: message + ', ' + retryLink.outerHTML,
    severity: "Warning"
  });
  if (this.message &&
      this.message.element &&
      this.message.syncfusion) {
    this.message.syncfusion.destroy();
    while(this.message.element.hasChildNodes()) {
      this.message.element.removeChild(this.msg.element.children[0]);
    }
  } else {
    this.message = {
      element: container,
    }
  }
  this.message.syncfusion = msg;
  msg.appendTo(container);
  retryLink = document.getElementById('retryLink');
  retryLink.addEventListener('click', (event) => {
    event.preventDefault();
    msg.destroy();
    request(endPoint).then(
      json => success.apply(this, [json, request, endPoint]));
  });
}
