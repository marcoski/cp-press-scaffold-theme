<?php

namespace CpPressTheme\Walker;
/**
 * Created by Marco 'Marcoski' Trognoni.
 */
class CpPressThemeMenuWalker extends \Walker_Nav_Menu
{

    private $itemMap = [
        'home' => ['icon' => 'fa-home', 'color' => 1],
        'chi-siamo' => ['icon' => 'fa-list-ul', 'color' => 3],
        'cosa-facciamo' => ['icon' => 'fa-file-text-o', 'color' => 2],
        'labcorsi' => ['icon' => 'fa-pencil-square-o', 'color' => 4],
        'dove-siamo' => ['icon' => 'fa-map-marker', 'color' => 5],
        'news' => ['icon' => 'fa-calendar', 'color' => 6]
    ];

    public function start_el(  &$output, $item, $depth = 0, $args = array(), $id = 0 ){
        $indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' );
        if(!isset($this->itemMap[$item->post_name])){
            return;
        }
        $map = $this->itemMap[$item->post_name];
        $classes = array();

        if($depth > 0){
            $classes[] = 'item-sub';
        }else{
            $classes[] = 'singleDrop color-'.$map['color'];
        }

        if(in_array('current-menu-item', $item->classes)){
            $classes[] = 'active';
        }

        $class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item )));

        $output .= $indent . '<li id="m'. $item->ID . '" class="' . $class_names . '">';
        $attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
        $attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
        $attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

        $before = $args->before;

        $linkAfter = '</span>';

        $linkBefore = '<i class="fa '.$map['icon'].' bg-color-'.$map['color'].'"></i><span>';

        $item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
            $before,
            $attributes,
            $linkBefore,
            apply_filters( 'the_title', $item->title, $item->ID ),
            $linkAfter,
            $args->after
        );

        // build html
        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

    }
}