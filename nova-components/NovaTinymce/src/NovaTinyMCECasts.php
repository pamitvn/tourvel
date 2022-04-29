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
      return base64_decode($value, true) ? urldecode(base64_decode($value, true)) : $value;
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
      return base64_decode($value, true) ? $value : base64_encode(urlencode($value));
   }
}
