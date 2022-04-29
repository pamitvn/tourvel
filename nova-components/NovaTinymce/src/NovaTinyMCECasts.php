<?php

namespace Emilianotisato\NovaTinyMCE;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class NovaTinyMCECasts implements CastsAttributes
{

   /**
    * Cast the given value.
    *
    * @param Model $model
    * @param string $key
    * @param string $value
    * @param array $attributes
    * @return string
    */
   public function get($model, $key, $value, $attributes): string
   {
      return urldecode($value);
   }

   /**
    * Prepare the given value for storage.
    *
    * @param Model $model
    * @param string $key
    * @param string $value
    * @param array $attributes
    * @return string
    */
   public function set($model, $key, $value, $attributes): string
   {
      return urldecode(trim($value)) == trim($value) ? urlencode(urldecode($value)) : urlencode($value);
   }
}
