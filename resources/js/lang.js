window.cambiarIdioma = function (lang) {
    const currentLocale = document.documentElement.lang; 
    let url = window.location.pathname; // solo la parte del path
    const baseUrl = window.location.origin; 

    // si ya estamos en el idioma elegido, no hacer nada
    if (lang === currentLocale) return;

    // reemplazar el idioma actual si existe
    const localePattern = /^\/(es|en)(\/|$)/; // detecta prefijos /es o /en
    if (localePattern.test(url)) {
        url = url.replace(localePattern, `/${lang}/`);
    } else {
        // Si no hay prefijo de idioma, agregarlo
        if (!url.startsWith(`/${lang}`)) {
            url = `/${lang}${url}`;
        }
    }

    // redirigir 
    window.location.href = baseUrl + url;
};
