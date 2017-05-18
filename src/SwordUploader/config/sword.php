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

    /*
    |--------------------------------------------------------------------------
    | SWORD API File Deposit Behavior
    |--------------------------------------------------------------------------
    |
    | The configuration parameters that modify the behavior of the deposit
    | operation.
    |
    */
    'behavior' => [

        'contentType' => env("SWORD_CONTENT_TYPE", "application/zip"),

        'packaging' => env("SWORD_PACKAGING", "http://purl.org/net/sword-types/METSDSpaceSIP"),

        'onBehalfOf' => env("SWORD_ON_BEHALF_OF", ""),

        'noOp' => env("SWORD_NO_OP", false),

        'verbose' => env("SWORD_VERBOSE", false),

    ],

    /*
    |--------------------------------------------------------------------------
    | SWORD API File Location Configuration
    |--------------------------------------------------------------------------
    |
    | The configuration parameters for file-based operations.
    |
    */
    'files' => [

        'roots' => [

            /*
            |--------------------------------------------------------------------------
            | SWORD API Input Directories
            |--------------------------------------------------------------------------
            |
            | The configuration parameters for input directories.
            |
            */
            'input' => [

                'root' => env("SWORD_FILE_ROOT_IN", ""),

                'subdir' => env("SWORD_FILE_SUBDIR_IN", ""),

                'theses' => [

                    'document' => env("SWORD_THESIS_DOCUMENT_ROOT_IN", ""),

                    'supplemental' => env("SWORD_THESIS_SUPPLEMENTAL_ROOT_IN", ""),

                ],

            ],

            /*
            |--------------------------------------------------------------------------
            | SWORD API Output Directories
            |--------------------------------------------------------------------------
            |
            | The configuration parameters for output directories.
            |
            */
            'output' => [

                'package' => env("SWORD_PACKAGE_ROOT_OUT", ""),

                'theses' => [

                    'package' => env("SWORD_THESIS_PACKAGE_ROOT_OUT", ""),

                    'mets' => env("SWORD_THESIS_METS_ROOT_OUT", ""),

                ],

            ],

        ],

    ],

];