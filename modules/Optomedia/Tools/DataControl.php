<?php

namespace Optomedia\Tools;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DataControl
{
    public static function camelize($string)
    {
        $parts = \explode( "_", $string );
        $first = true;
        foreach( $parts as &$v ) {
            if( $first ) {
                $first = false;
                continue;
            }
            $v = ucfirst( $v );
        }
        return \implode( "", $parts );
    }
}