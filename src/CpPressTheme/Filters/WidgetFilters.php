<?php
/**
 * Created by Marco 'Marcoski' Trognoni.
 */

namespace CpPressTheme\Filters;


use CpPress\Application\WP\Hook\Filter;
use CpPress\CpPress;

class WidgetFilters extends Filter
{

    private static $instance = null;

    public static function add(){
        if(is_null(self::$instance)){
            self::$instance = new static(CpPress::$App);
        }

        self::$instance->execAll();
    }
}