<?php

return [

	/*
    |--------------------------------------------------------------------------
    | SWORD API Service Document
    |--------------------------------------------------------------------------
    |
    | The identifier of the service document used for uploads.
    |
    */
    'service_document' => env("SWORD_SERVICE_DOC", ""),

    /*
    |--------------------------------------------------------------------------
    | SWORD API Deposit Identifier
    |--------------------------------------------------------------------------
    |
    | The identifier of the deposit repository that exposes the SWORD API.
    |
    */
    'deposit' => env("SWORD_DEPOSIT", ""),

    /*
    |--------------------------------------------------------------------------
    | SWORD API Deposit Username
    |--------------------------------------------------------------------------
    |
    | The username used for uploading to the deposit repository.
    |
    */
    'username' => env("SWORD_USERNAME", ""),

    /*
    |--------------------------------------------------------------------------
    | SWORD API Deposit Password
    |--------------------------------------------------------------------------
    |
    | The password used for uploading to the deposit repository.
    |
    */
    'password' => env("SWORD_PASSWORD", ""),

];