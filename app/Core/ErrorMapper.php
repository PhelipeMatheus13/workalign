<?php
// App/Core/ErrorMapper.php

namespace App\Core;

class ErrorMapper
{
   private static $map = [
      'NOT_FOUND' => [
         'friendly_message' => "Resource not found.",
         'code' => 404
      ],
      'DATABASE_ERROR' => [
         'friendly_message' => "Database connection issue. Try again later.",
         'code' => 500
      ],
      'DB_OPERATION_FAILED' => [
         'friendly_message' => "Database operation failed. Please retry.",
         'code' => 500
      ],
      'INTERNAL_ERROR' => [
         'friendly_message' => "Internal server error. Please try again.",
         'code' => 500
      ],
      'SERVICE_ERROR' => [
         'friendly_message' => "Service temporarily unavailable. Try again later.",
         'code' => 503
      ]
   ];

   public static function getFriendlyMessage($errorCode)
   {
      return self::$map[$errorCode]['friendly_message']
         ?? 'Unexpected error. Please try again.';
   }

   public static function getStatusCode($errorCode)
   {
      return self::$map[$errorCode]['code'] ?? 500;
   }

   public static function getErrorConfig($errorCode)
   {
      if (isset(self::$map[$errorCode])) {
         return [
            'friendly_message' => self::$map[$errorCode]['friendly_message'],
            'code' => self::$map[$errorCode]['code']
         ];
      }

      return [
         'friendly_message' => 'Unexpected error. Please try again.',
         'code' => 500
      ];
   }
}
