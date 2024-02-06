<?php

namespace App\Traits;

trait TransformTrait
{
    public function normalize($str)
    {
        $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);

        return strtolower($str);
    }

    public function toSnakeCase($str)
    {

        $str = $this->normalize($str);

        $str = preg_replace('/[^a-z0-9]+/i', '_', $str);

        return trim($str, '_');
    }

    function toCamelCase($str)
    {

        $str = $this->normalize($str);

        $str = preg_replace('/[^a-z0-9]+/i', ' ', $str);

        $str = str_replace(' ', '', ucwords($str));

        return lcfirst($str);
    }


}
