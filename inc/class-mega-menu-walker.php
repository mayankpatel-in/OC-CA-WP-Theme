<?php
/**
 * OC CA Theme — Mega Menu Walker
 *
 * Detects 3-level menu structure automatically:
 *  - depth 0   → top nav item  (always)
 *  - depth 1   → column header (when depth-0 item has grandchildren → mega layout)
 *              → simple link   (when depth-0 item has no grandchildren → dropdown layout)
 *  - depth 2   → leaf link     (inside a mega column)
 *
 * Generated HTML structures
 * ─────────────────────────
 * Mega (3-level):
 *   <li class="nav-item is-mega">
 *     <a class="nav-link">…</a>
 *     <div class="mega-menu">
 *       <div class="mega-grid">
 *         <div class="mega-col">
 *           <div class="mega-col-title">AUDIT</div>
 *           <ul class="mega-col-list">
 *             <li><a>Internal Audit</a></li>…
 *           </ul>
 *         </div>…
 *       </div>
 *     </div>
 *   </li>
 *
 * Simple dropdown (2-level):
 *   <li class="nav-item has-dropdown">
 *     <a class="nav-link">…</a>
 *     <div class="dropdown-menu">
 *       <ul>
 *         <li><a>Item</a></li>…
 *       </ul>
 *     </div>
 *   </li>
 *
 * @package OC_CA_Theme
 */

class OC_CA_Mega_Menu_Walker extends Walker_Nav_Menu {

    /** Whether the current depth-0 item's children have their own children. */
    private $is_mega = false;

    /** Number of direct children (columns) for the current depth-0 item. */
    private $col_count = 0;

    // ── Layout detection ──────────────────────────────────────

    /**
     * Peek at children and grandchildren before rendering each depth-0 element.
     * Sets $is_mega and $col_count so start_lvl can output the right container
     * and a data-cols attribute for CSS-driven width.
     */
    public function display_element( $element, &$children_elements, $max_depth, $depth, $args, &$output ) {
        if ( 0 === $depth ) {
            $this->is_mega   = false;
            $this->col_count = 0;
            if ( isset( $children_elements[ $element->ID ] ) ) {
                foreach ( $children_elements[ $element->ID ] as $child ) {
                    $this->col_count++;
                    if ( isset( $children_elements[ $child->ID ] ) ) {
                        $this->is_mega = true;
                    }
                }
            }
        }
        parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

    // ── Walker overrides ──────────────────────────────────────

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $indent       = str_repeat( "\t", $depth );
        $classes      = empty( $item->classes ) ? [] : (array) $item->classes;
        $has_children = in_array( 'menu-item-has-children', $classes );

        // ── Level 0: top nav items ────────────────────────────
        if ( 0 === $depth ) {
            if ( $has_children ) {
                $classes[] = $this->is_mega ? 'is-mega' : 'has-dropdown';
            }
            $class_str = esc_attr( trim( implode( ' ', apply_filters(
                'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth
            ) ) ) );

            $output .= "\n{$indent}<li id=\"menu-item-{$item->ID}\" class=\"nav-item {$class_str}\">";
            $output .= $this->render_link( $item, $has_children, 'nav-link', $args, $depth );
        }

        // ── Level 1 in mega layout: column header or solo link ─
        elseif ( 1 === $depth && $this->is_mega ) {
            if ( $has_children ) {
                $title   = esc_html( apply_filters( 'nav_menu_item_title',
                    apply_filters( 'the_title', $item->title, $item->ID ),
                    $item, $args, $depth
                ) );
                $output .= "\n{$indent}<div class=\"mega-col\">";
                $output .= "<div class=\"mega-col-title\">{$title}</div>";
            } else {
                // Standalone item (no sub-items) — render as a small solo column
                $output .= "\n{$indent}<div class=\"mega-col mega-col-solo\">";
                $output .= $this->render_link( $item, false, 'mega-solo-link', $args, $depth );
                // div closed in end_el
            }
        }

        // ── Level 1 in simple dropdown ────────────────────────
        elseif ( 1 === $depth ) {
            $output .= "\n{$indent}<li>";
            $output .= $this->render_link( $item, false, '', $args, $depth );
        }

        // ── Level 2+: leaf items ──────────────────────────────
        else {
            $output .= "\n{$indent}<li>";
            $output .= $this->render_link( $item, false, '', $args, $depth );
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
        if ( 0 === $depth ) {
            $output .= "</li>\n";
        } elseif ( 1 === $depth && $this->is_mega ) {
            $output .= "</div>\n"; // close .mega-col or .mega-col-solo
        } else {
            $output .= "</li>\n";
        }
    }

    public function start_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );

        if ( 0 === $depth ) {
            if ( $this->is_mega ) {
                $cols    = (int) $this->col_count;
                $output .= "\n{$indent}<div class=\"mega-menu\" role=\"navigation\" data-cols=\"{$cols}\">\n{$indent}\t<div class=\"mega-grid\">\n";
            } else {
                $output .= "\n{$indent}<div class=\"dropdown-menu\">\n{$indent}\t<ul>\n";
            }
        } elseif ( 1 === $depth && $this->is_mega ) {
            $output .= "\n{$indent}\t<ul class=\"mega-col-list\">\n";
        } else {
            $output .= "\n{$indent}<ul>\n";
        }
    }

    public function end_lvl( &$output, $depth = 0, $args = array() ) {
        $indent = str_repeat( "\t", $depth );

        if ( 0 === $depth ) {
            if ( $this->is_mega ) {
                $output .= "{$indent}\t</div>\n{$indent}</div>\n"; // mega-grid + mega-menu
            } else {
                $output .= "{$indent}\t</ul>\n{$indent}</div>\n"; // ul + dropdown-menu
            }
        } elseif ( 1 === $depth && $this->is_mega ) {
            $output .= "{$indent}\t</ul>\n";
        } else {
            $output .= "{$indent}</ul>\n";
        }
    }

    // ── Helper ────────────────────────────────────────────────

    private function render_link( $item, $has_children, $class, $args, $depth ) {
        $atts = [
            'href'   => ! empty( $item->url )        ? $item->url        : '#',
            'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
            'target' => ! empty( $item->target )     ? $item->target     : '',
            'rel'    => ! empty( $item->xfn )        ? $item->xfn        : '',
        ];
        if ( $class ) {
            $atts['class'] = $class;
        }
        if ( $has_children ) {
            $atts['aria-haspopup'] = 'true';
            $atts['aria-expanded'] = 'false';
        }

        $atts     = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
        $attr_str = '';
        foreach ( $atts as $attr => $value ) {
            if ( '' !== $value ) {
                $value     = 'href' === $attr ? esc_url( $value ) : esc_attr( $value );
                $attr_str .= " {$attr}=\"{$value}\"";
            }
        }

        $title = apply_filters( 'nav_menu_item_title',
            apply_filters( 'the_title', $item->title, $item->ID ),
            $item, $args, $depth
        );

        $html  = ( isset( $args->before ) ? $args->before : '' );
        $html .= "<a{$attr_str}>";
        $html .= ( isset( $args->link_before ) ? $args->link_before : '' );
        $html .= esc_html( $title );
        if ( $has_children ) {
            $html .= ' <i class="fa-solid fa-chevron-down" aria-hidden="true"></i>';
        }
        $html .= ( isset( $args->link_after ) ? $args->link_after : '' );
        $html .= '</a>';
        $html .= ( isset( $args->after ) ? $args->after : '' );

        return apply_filters( 'walker_nav_menu_start_el', $html, $item, $depth, $args );
    }
}
