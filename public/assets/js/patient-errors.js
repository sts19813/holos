// Mensajes seguros para los errores que pueden ocurrir al guardar pacientes.
window.showPatientSaveError = function (xhr) {
    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
        Object.values(xhr.responseJSON.errors).flat().forEach(message => toastr.error(message));
        return;
    }
    const messages = {
        0: 'No se pudo conectar con el servidor. Revisa tu conexión e inténtalo de nuevo.',
        401: 'Tu sesión terminó. Inicia sesión nuevamente y vuelve a intentarlo.',
        403: 'No tienes permiso para realizar esta acción. Contacta al administrador.',
        404: 'No se encontró el recurso solicitado. Actualiza la página e inténtalo de nuevo.',
        413: 'Los archivos superan el tamaño total permitido por el servidor. Reduce su tamaño o cantidad.',
        419: 'Tu sesión venció. Copia los datos del formulario, actualiza la página e inicia sesión de nuevo si es necesario.',
        429: 'Se hicieron demasiados intentos. Espera un momento y vuelve a intentarlo.',
        500: 'Ocurrió un error en el servidor al guardar. Contacta al administrador e indica la hora del intento.',
        502: 'El servidor no respondió correctamente. Espera un momento y vuelve a intentarlo.',
        503: 'El servicio no está disponible temporalmente. Vuelve a intentarlo más tarde.',
        504: 'El servidor tardó demasiado en responder. Comprueba si el paciente se guardó antes de volver a intentarlo.'
    };
    toastr.error(messages[xhr.status] || 'No se pudo guardar el paciente (código ' + xhr.status + '). Contacta al administrador.');
};
