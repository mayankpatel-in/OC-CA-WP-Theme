/**
 * OC CA Theme — Customizer Preview
 *
 * Listens for postMessage value changes from the Customizer panel
 * and injects a live <style> tag into the preview iframe so logo
 * size updates are instant — no page reload needed.
 */
( function () {
    'use strict';

    var STYLE_ID = 'oc-ca-logo-size-live';

    var settings = {
        header_logo_height_desktop: 42,
        header_logo_height_mobile:  32,
        footer_logo_height_desktop: 42,
        footer_logo_height_mobile:  32,
    };

    function buildCSS() {
        var hd = settings.header_logo_height_desktop;
        var hm = settings.header_logo_height_mobile;
        var fd = settings.footer_logo_height_desktop;
        var fm = settings.footer_logo_height_mobile;

        return (
            '.main-header .logo img,' +
            '.main-header .logo .custom-logo{height:' + hd + 'px;width:auto;}' +

            '.main-footer .col-info .custom-logo-link img,' +
            '.main-footer .footer-logo{height:' + fd + 'px;width:auto;}' +

            '@media(max-width:768px){' +
                '.main-header .logo img,' +
                '.main-header .logo .custom-logo{height:' + hm + 'px;width:auto;}' +
                '.main-footer .col-info .custom-logo-link img,' +
                '.main-footer .footer-logo{height:' + fm + 'px;width:auto;}' +
            '}'
        );
    }

    function injectStyle() {
        var el = document.getElementById( STYLE_ID );
        if ( ! el ) {
            el = document.createElement( 'style' );
            el.id = STYLE_ID;
            document.head.appendChild( el );
        }
        el.textContent = buildCSS();
    }

    Object.keys( settings ).forEach( function ( id ) {
        wp.customize( id, function ( value ) {
            value.bind( function ( newVal ) {
                settings[ id ] = parseInt( newVal, 10 ) || settings[ id ];
                injectStyle();
            } );
        } );
    } );

} )();
