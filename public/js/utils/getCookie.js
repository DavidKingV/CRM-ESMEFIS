export function getCookie(name) {
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");

        // Elimina espacios en blanco y compara el nombre de la cookie
        if (name == cookiePair[0].trim()) {
            // Devuelve el valor de la cookie, con decodificación para caracteres especiales
            return decodeURIComponent(cookiePair[1]);
        }
    }
    return null; // Retorna null si la cookie no existe
}