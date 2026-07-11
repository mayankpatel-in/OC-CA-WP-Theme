/**
 * OC CA Theme — Customizer Preview
 *
 * Listens for postMessage value changes and updates :root CSS custom
 * properties so the logo height reflects instantly in the preview iframe.
 *
 * Uses CSS vars (--logo-h-desktop etc.) instead of selector-based CSS so
 * there are no specificity conflicts with theme.css rules.
 */
( function () {
    'use strict';

    var STYLE_ID = 'oc-ca-logo-size-live';

    // Keyed by Customizer setting ID → current value
    var settings = {
        header_logo_height_desktop: 42,
        header_logo_height_mobile:  32,
        footer_logo_height_desktop: 42,
        footer_logo_height_mobile:  32,
    };

    // Map setting ID → CSS custom property name
    var varMap = {
        header_logo_height_desktop: '--logo-h-desktop',
        header_logo_height_mobile:  '--logo-h-mobile',
        footer_logo_height_desktop: '--footer-logo-h-desktop',
        footer_logo_height_mobile:  '--footer-logo-h-mobile',
    };

    function injectStyle() {
        var el = document.getElementById( STYLE_ID );
        if ( ! el ) {
            el = document.createElement( 'style' );
            el.id = STYLE_ID;
            document.head.appendChild( el );
        }

        var css = ':root{';
        Object.keys( varMap ).forEach( function ( id ) {
            css += varMap[ id ] + ':' + settings[ id ] + 'px;';
        } );
        css += '}';

        el.textContent = css;
    }

    Object.keys( settings ).forEach( function ( id ) {
        wp.customize( id, function ( value ) {
            // Seed with the current saved value so all vars are correct from
            // the moment the Customizer opens — not just after a change.
            var current = parseInt( value.get(), 10 );
            if ( current > 0 ) {
                settings[ id ] = current;
            }
            injectStyle();

            value.bind( function ( newVal ) {
                var n = parseInt( newVal, 10 );
                if ( n > 0 ) {
                    settings[ id ] = n;
                }
                injectStyle();
            } );
        } );
    } );

} )();
