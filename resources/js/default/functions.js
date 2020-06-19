/** The standard functions **/

/* Function to check if the url contains a string. */
function url_contains( url_string ) {
    return window.location.href.indexOf( url_string ) > -1;
}

/* Function to change a CSS variable */
function change_var( var_name, new_value ) {
    document.documentElement.style.setProperty( '--' + var_name, new_value );
}

/** The custom functions **/

function create_standard_css_variables() {
    change_var( 'js--screen-width', window.innerWidth + 'px' );
    change_var( 'js--screen-height', window.innerHeight + 'px' );
}

function toggleTheme() {
    const html_el = document.getElementsByTagName( 'html' )[0];
    const currentTheme = html_el.getAttribute( 'data-theme' );
    if( currentTheme === 'light' ) {
        html_el.setAttribute( 'data-theme', 'dark' );
    } else {
        html_el.setAttribute( 'data-theme', 'light' );
    }
    return true;
}

/** The place to execute the functions **/

/* Code to be executed when the site is loaded. */
function executeOnLoad() {
    create_standard_css_variables();
}

/** -----   -----   -----   -----   -----   -----   -----   -----   -----   -----   ----- **/

window.addEventListener( 'DOMContentLoaded', function() {
    executeOnLoad();
} );

document.getElementById("theme-button").addEventListener( "click", function() {
    toggleTheme();
} );
