<?php
/**
 * OC CA Theme - Custom Walker for Mega Menu
 *
 * Extends Walker_Nav_Menu to add CSS classes for mega-menu columns
 * and dropdown containers, enabling the premium mega-menu design.
 *
 * @package OC_CA_Theme
 */

class OC_CA_Mega_Menu_Walker extends Walker_Nav_Menu {

    /**
     * Start the element output.
     * Adds 'has-dropdown' class to items that have children.
     */
    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;

        // Check if item has children
        $has_children = in_array( 'menu-item-has-children', $classes );

        // Add custom class
        if ( $has_children ) {
            $classes[] = 'has-dropdown';
        }

        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
        $class_names = $class_names ? ' class="nav-item ' . esc_attr( $class_names ) . '"' : ' class="nav-item"';

        $id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
        $id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
        $atts['target'] = ! empty( $item->target ) ? $item->target : '';
        $atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
        $atts['href']   = ! empty( $item->url ) ? $item->url : '';
        $atts['class']  = 'nav-link';

        // Add aria attributes
        if ( $has_children ) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

        $attributes = '';
        foreach ( $atts as $attr => $value ) {
            if ( ! empty( $value ) ) {
                $value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        // Build the link
        $title = apply_filters( 'the_title', $item->title, $item->ID );
        $title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

        $item_output = '';
        $item_output .= isset( $args->before ) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= isset( $args->link_before ) ? $args->link_before : '';
        $item_output .= $title;
        if ( $has_children ) {
            $item_output .= ' <i class="fa-solid fa-chevron-down"></i>';
        }
        $item_output .= isset( $args->link_after ) ? $args->link_after : '';
        $item_output .= '</a>';
        $item_output .= isset( $args->after ) ? $args->after : '';

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Start the sub-menu list (dropdown container).
     * Uses mega-menu wrapper for top-level items with children.
     */
    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( 0 === $depth ) {
            // First level dropdown — use dropdown-menu class
            $output .= "\n$indent<div class=\"dropdown-menu\">\n$indent\t<ul>\n";
        } else {
            $output .= "\n$indent<ul class=\"sub-menu\">\n";
        }
    }

    /**
     * End the sub-menu list.
     */
    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );
        if ( 0 === $depth ) {
            $output .= "$indent\t</ul>\n$indent</div>\n";
        } else {
            $output .= "$indent</ul>\n";
        }
    }
}
