<?php

namespace Optomedia\Tools;

class DataTools
{
    public static function bindOrm($src, &$dst)
    {
        if(!is_object($dst) || !is_object($src))
        {
            return;
        }

        foreach($src as $key => $val)
        {
            $key2 = self::camelize($key);

            if(property_exists(get_class($dst), $key2 ))
            {
                $rp = new \ReflectionProperty($dst,$key2);
                if($rp->isPrivate() || $rp->isProtected()) {
                    // Run if the property is private
                    $setterName = 'set'.ucfirst($key2);
                    if( method_exists ($dst , $setterName ))
                    {
                        if(!is_null($val)){
                            if(preg_match('/@var\s+([^\s]+)/', $rp->getDocComment(), $matches)) {
                                $type = $matches[1];
                                if('DateTime' == $type || '\DateTime' == $type){
                                    $val = new \DateTime($val);
                                }
                            }
                        }
                        call_user_func_array(array($dst, $setterName), array($val));
                    }
                } else {
                    // Run if the property is Public
                    if(!is_null($val)){
                        if(preg_match('/@var\s+([^\s]+)/', $rp->getDocComment(), $matches)) {
                            $type = $matches[1];
                            if('DateTime' == $type || '\DateTime' == $type){
                                $val = new \DateTime($val);
                            }
                        }
                    }
                    $dst->$key2 = $val;
                }
            }

        }
    }

    public static function camelize($src, $with_null = false)
    {
        if(!is_object($src))
        {
            return [];
        }
        $ret = [];
        $reflection = new ReflectionClass($src);

        foreach($reflection->getProperties() as $property)
        {
            $key =$property->getName();
            if($key == 'tableName'){
                continue;
            }
            if($property->isPublic()){

                $value = $property->getValue($src);
                if($value instanceof \DateTime){
                    $value = $value->format("Y-m-d H:i:s");
                }
                if($with_null)
                {
                    $ret[self::camel2under($key)] = $value;
                    continue;
                } elseif (!is_null($value)){

                    $ret[self::camel2under($key)] = $value;
                }
            } else {
                $getterName = 'get'. ucfirst($key);
                $checkerName = 'is'. ucfirst($key);
                if(method_exists($src , $getterName))
                {
                    $value = call_user_func(array($src, $getterName));
                    if($value instanceof \DateTime){
                        $value = $value->format("Y-m-d H:i:s");
                    }
                    if($with_null)
                    {
                        $ret[self::camel2under($key)] = $value;
                        continue;
                    } elseif (!is_null($value)){

                        $ret[self::camel2under($key)] = $value;
                    }
                } elseif(method_exists($src , $checkerName)){

                    $value = call_user_func(array($src, $checkerName));
                    if($value instanceof \DateTime){
                        $value = $value->format("Y-m-d H:i:s");
                    }
                    if($with_null)
                    {
                        $ret[self::camel2under($key)] = $value;
                        continue;
                    } elseif (!is_null($value)){

                        $ret[self::camel2under($key)] = $value;
                    }
                }
            }
        }
        return $ret;
    }

    public static function under2camel($string)
    {
        $string = explode( "_", $string );
        $first = true;
        foreach( $string as &$v ) {
            if( $first ) {
                $first = false;
                continue;
            }
            $v = ucfirst( $v );
        }
        return implode( "", $string );
    }

    public static function camel2under($string)
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', '$1_$2', $string));
    }

}
