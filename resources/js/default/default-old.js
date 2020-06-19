const dev_site = true;

/** Start default functions **/

/* Function to log when in dev mode */
function dev_log( text ) {
    const log = dev_site ? console.log( text ) : "" ;
}

/* Function to mimic the jQuery equivalent */
function get_element( selector ) {
    return document.querySelectorAll( selector )[0];
}

/* Function to smoothly scroll to an element. */
function scroll_to( selector ) {

    const el = get_element( selector );
    const offset = el.getBoundingClientRect().top + window.pageYOffset;
    const whitespace = -25;
    window.scrollTo( {
            top: offset + whitespace,
            behavior: 'smooth'
        });

}

/* Function to check if the url contains a string. */
function url_contains( url_string ) {
    return window.location.href.indexOf( url_string ) > -1;
}

/* Function to change a CSS variable */
function change_var( var_name, new_value ) {
    document.documentElement.style.setProperty( '--' + var_name, new_value );
}

/* Function to check the screen size */
function screensize_is( type, size ) {
    if( type !== 'equal to' && type !== 'smaller than' && type !== 'larger than' ) {
        dev_log( 'Dit type bestaat niet, je hebt ' + type + ' ingevuld.' );
        return false;
    }
    if( type === 'equal to' ) {
        if( window.innerWidth === size ) {
            return true;
        }
    }
    if( type === 'smaller than' ) {
        if( window.innerWidth < size ) {
            return true;
        }
    }
    if( type === 'larger than' ) {
        if( window.innerWidth > size ) {
            return true;
        }
    }
    return false;
}

/* Function to add a breadcrumb item */
function add_breadcrumb_item( breadcrumb_class, breadcrumb_item_class, new_breadcrumb_insert_after_item, new_breadcrumb_item_name, new_breadcrumb_item_url ) {

    const breadcrumb_item_el = $('.' + breadcrumb_item_class );
    const insert_after_el = breadcrumb_item_el[new_breadcrumb_insert_after_item];
    if( $( '.' + breadcrumb_class ).length === 0 ) {
        dev_log( 'Heb je wel de juiste breadcrumb class ingevoerd? Dit is wat je hebt ingevuld: ' + breadcrumb_class );
        return false;
    }
    if( breadcrumb_item_el.length === 0 ) {
        dev_log( 'Heb je wel de juiste breadcrumb item class ingevoerd? Dit is wat je hebt ingevuld: ' + breadcrumb_item_class );
        return false;
    }
    if( !insert_after_el ) {
        dev_log( 'Er zijn niet genoeg breadcrumb items om jouw item na de ' + new_breadcrumb_insert_after_item + 'e breadcrumb toe te voegen.' );
        return false;
    }
    $( '<a class="' + breadcrumb_item_class + '" href="' + new_breadcrumb_item_url + '"><span class="crumb">' + new_breadcrumb_item_name + '</span></a>' ).insertAfter( insert_after_el );
    return true;

}

/** End default functions **/

/** Start custom functions **/

function create_standard_css_variables() {
    change_var( 'js--screen-width', window.innerWidth + 'px' );
    change_var( 'js--screen-height', window.innerHeight + 'px' );
}

function toggleTheme() {
    const html_el = document.getElementsByTagName( 'html' )[0];
    const currentTheme = html_el.getAttribute( 'data-theme' );
    if( currentTheme == 'light' ) {
        html_el.setAttribute( 'data-theme', 'dark' );
    } else {
        html_el.setAttribute( 'data-theme', 'light' );
    }
    return true;
}

/** End custom functions **/

/* Code to be executed when the site is loaded. */
function execute_on_load() {
    create_standard_css_variables();
    console.log( 'hoi' );
}

/* Code to be executed when the site resizes. */
function execute_on_resize() {
    create_standard_css_variables();
}

/* Start executing functions */

$( document ).ready( function() {
    execute_on_load();
} );

$( window ).resize( function() {
    execute_on_resize();
} );

/* End executing functions */
