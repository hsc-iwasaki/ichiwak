/**
 * navigation.js
 *
 * Handles toggling the navigation menu for small screens.
 * Also adds a focus class to parent li's for accessibility.
 * Finally adds a class required to reveal the search in the handheld footer bar.
 */
( function() {

    // Wait for DOM to be ready.
    document.addEventListener( 'DOMContentLoaded', function() {
        var container = document.getElementsByClassName( 'handheld-header' );
        if ( ! container ) {
            return;
        }

        // Add dropdown toggle that displays child menu items.
        var handheld = document.getElementsByClassName( 'off-canvas-navigation' );

        if ( handheld.length > 0 ) {
            [].forEach.call( handheld[0].querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' ), function( anchor ) {

                // Add dropdown toggle that displays child menu items
                var btn = document.createElement( 'button' );
                btn.setAttribute( 'aria-expanded', 'false' );
                btn.classList.add( 'dropdown-toggle' );

                var btnSpan = document.createElement( 'span' );
                btnSpan.classList.add( 'screen-reader-text' );
                btnSpan.appendChild( document.createTextNode( jobhuntScreenReaderText.expand ) );

                btn.appendChild( btnSpan );

                anchor.parentNode.insertBefore( btn, anchor.nextSibling );

                // Set the active submenu dropdown toggle button initial state
                if ( anchor.parentNode.classList.contains( 'current-menu-ancestor' ) ) {
                    btn.setAttribute( 'aria-expanded', 'true' );
                    btn.classList.add( 'toggled-on' );
                    btn.nextElementSibling.classList.add( 'toggled-on' );
                }

                // Add event listener
                btn.addEventListener( 'click', function() {
                    btn.classList.toggle( 'toggled-on' );

                    // Remove text inside span
                    while ( btnSpan.firstChild ) {
                        btnSpan.removeChild( btnSpan.firstChild );
                    }

                    var expanded = btn.classList.contains( 'toggled-on' );

                    btn.setAttribute( 'aria-expanded', expanded );
                    btnSpan.appendChild( document.createTextNode( expanded ? jobhuntScreenReaderText.collapse : jobhuntScreenReaderText.expand ) );
                    btn.nextElementSibling.classList.toggle( 'toggled-on' );
                } );
            } );
        }

        // Add class to footer search when clicked.
        [].forEach.call( document.querySelectorAll( '.kidos-handheld-footer-bar .search > a' ), function( anchor ) {
            anchor.addEventListener( 'click', function( event ) {
                anchor.parentElement.classList.toggle( 'active' );
                event.preventDefault();
            } );
        } );

        // Add focus class to body when an input field is focused.
        // This is used to hide the Handheld Footer Bar when an input is focused.
        var footer_bar = document.getElementsByClassName( 'kidos-handheld-footer-bar' );
        var forms      = document.forms;
        var isFocused  = function( focused ) {
            return function() {
                if ( !! focused ) {
                    document.body.classList.add( 'sf-input-focused' );
                } else {
                    document.body.classList.remove( 'sf-input-focused' );
                }
            };
        };

        if ( footer_bar.length && forms.length ) {
            for ( var i = 0; i < forms.length; i++ ) {
                if ( footer_bar[0].contains( forms[ i ] ) ) {
                    continue;
                }

                forms[ i ].addEventListener( 'focus', isFocused( true ), true );
                forms[ i ].addEventListener( 'blur', isFocused( false ), true );
            }
        }

        // Add focus class to parents of sub-menu anchors.
        [].forEach.call( document.querySelectorAll( '.site-header .menu-item > a, .site-header .page_item > a, .site-header-cart a' ), function( anchor ) {
            var li = anchor.parentNode;
            anchor.addEventListener( 'focus', function() {
                li.classList.add( 'focus' );
            } );
            anchor.addEventListener( 'blur', function() {
                li.classList.remove( 'focus' );
            } );
        } );

        // Add an identifying class to dropdowns when on a touch device
        // This is required to switch the dropdown hiding method from a negative `left` value to `display: none`.
        if ( ( 'ontouchstart' in window || navigator.maxTouchPoints ) && window.innerWidth > 767 ) {
            [].forEach.call( document.querySelectorAll( '.site-header ul ul, .site-header-cart .widget_shopping_cart' ), function( element ) {
                element.classList.add( 'sub-menu--is-touch-device' );
            } );
        }
    } );
} )();
