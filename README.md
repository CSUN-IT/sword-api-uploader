# SWORD API Uploader
Allows for the uploading of documents in a Laravel project to a repository that uses the SWORD API.

This package is built for version 5.0 of Laravel and above.

To install from Composer, use the following command:

```
composer require csun-metalab/sword-api-uploader
```

## Installation

First, add the following lines to your `.env` file to configure your connection to the repository:

```
SWORD_SERVICE_DOC=
SWORD_DEPOSIT=
SWORD_USERNAME=
SWORD_PASSWORD=
```

Next, add the service provider to your `providers` array in Laravel as follows:

```
'providers' => [
   //...

   CSUNMetaLab\SwordUploader\Providers\SwordServiceProvider::class,

   // You can also use the following depending on Laravel convention:
   // 'CSUNMetaLab\SwordUploader\Providers\SwordServiceProvider',

   //...
],
```

Add the `Sword` facade to your `aliases` array in Laravel as follows:

```
'aliases' => [
   //...

   'Sword' => CSUNMetaLab\SwordUploader\Facades\Sword::class,

   // You can also use the following depending on Laravel convention:
   // 'Sword' => 'CSUNMetaLab\SwordUploader\Facades\Sword',
],
```

Finally, run the following Artisan command to publish the configuration file:

```
php artisan vendor:publish
```

## Environment Variables

The environment variables you added to your `.env` file are the following:

### SWORD_SERVICE_DOC

This is the identifier for the service document the repository uses for SWORD uploads/deposits.

### SWORD_DEPOSIT

This is the identifer for the repository where SWORD uploads/deposits will be performed.

### SWORD_USERNAME

This is the username that will be used for authentication during SWORD operations.

### SWORD_PASSWORD

This is the password that will be used for authentication during SWORD operations.

## Underlying SWORD API Functionality

The underlying SWORD API functionality for packaging and depositing documents originally comes from `swordapp-php-library` created by Stuart Lewis.

You can find the code specific to the library here: https://github.com/swordapp/swordapp-php-library