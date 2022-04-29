<?php

namespace App\Models;

use Emilianotisato\NovaTinyMCE\NovaTinyMCECasts;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
   protected $fillable = [
      'title',
      'slug',
      'content',
      'short_description',
      'seo_title',
      'seo_description',
      'seo_image',
      'feature_image'
   ];

   protected $casts = [
      'content' => NovaTinyMCECasts::class
   ];
}
