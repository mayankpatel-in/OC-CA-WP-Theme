/**
 * OC CA Theme — Customizer Controls
 *
 * Handles:
 *  1. Range slider live value display
 *  2. Show/hide desktop vs mobile logo-size controls
 *     based on the active device tab in the Customizer
 */
( function ( $ ) {
    'use strict';

    // ── 1. Live value display ─────────────────────────────────
    $( document ).on( 'input', '.oc-ca-range-input', function () {
        $( this ).siblings( '.oc-ca-range-value' ).text( this.value );
    } );

    // ── 2. Device-tab visibility ──────────────────────────────
    wp.customize.bind( 'ready', function () {
        var device = wp.customize.previewedDevice;

        function syncDeviceControls( activeDevice ) {
            // desktop controls: visible on desktop + tablet
            $( '.oc-ca-range-wrap[data-device="desktop"]' )
                .closest( 'li.customize-control' )
                .toggle( activeDevice !== 'mobile' );

            // mobile controls: visible only on mobile
            $( '.oc-ca-range-wrap[data-device="mobile"]' )
                .closest( 'li.customize-control' )
                .toggle( activeDevice === 'mobile' );
        }

        // run immediately with the current device
        syncDeviceControls( device.get() );

        // re-run whenever the user switches device tabs
        device.bind( syncDeviceControls );
    } );

} )( jQuery );
