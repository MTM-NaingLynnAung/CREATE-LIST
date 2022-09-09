<?php

return [
      'name' => env('ADMIN_NAME') ?: 'User',
      'email' => env('ADMIN_EMAIL') ?: 'user@gmail.com',
      'password' => env('ADMIN_PASSWORD') ?: 'password',
];
