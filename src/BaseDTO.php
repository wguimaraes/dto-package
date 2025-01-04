<?php

namespace Wguimaraes\Dto;

abstract class BaseDTO
{
    public static function fromArray(array $data)
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                if($dtoInstance = self::isDTO($instance, $key)){
                    if(is_array($value)){
                        $instance->$key = $dtoInstance::fromArray($value);
                    }
                }else{
                    $instance->$key = $value;
                }
            }
        }
        return $instance;
    }

    public static function fromObject($data)
    {
        $instance = new static();
        foreach ($data as $key => $value) {
            if (property_exists($instance, $key)) {
                $instance->$key = $value;
            }
        }
        return $instance;
    }

    public function toArray()
    {
        $array = [];
        foreach ($this as $key => $value) {
            if(is_object($value) && $value instanceof BaseDTO){
                $array[$key] = $value->toArray();
            }else{
                $array[$key] = $value;
            }
        }
        return $array;
    }

    protected static function isDTO($instance, $propertieName)
    {
        $reflection = new \ReflectionMethod($instance, '__construct');
        $parameters = $reflection->getParameters();
        foreach($parameters as $parameter){
            if($parameter->getName() == $propertieName){
                $typeName = $parameter->getType()->getName();
                if(class_exists($typeName) && (new $typeName) instanceof BaseDTO){
                    return $typeName;
                }
            }
        }
        return false;
    }
}