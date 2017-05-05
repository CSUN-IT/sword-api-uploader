# :package: SWORD API Uploader :package:

:no_entry_sign: *This is a WIP (Work in Progress). Please do not attempt to install this package until this notice is removed.* :no_entry_sign:

Allows for the uploading of documents in a Laravel project to a repository that uses the SWORD API.

This package is built for version 5.0 of Laravel and above.

## :closed_book: Table of Contents

* [Installation](#wrench-installation)
* [Global Environment Variables](#notebook-global-environment-variables)
* [Thesis File Path Environment Variables](#mortar_board-thesis-file-path-environment-variables)
* [Regular File Path Environment Variables](#page_facing_up-regular-file-path-environment-variables)
* [Usage](#computer-usage)
* [Underlying SWORD API Functionality](#electric_plug-underlying-sword-api-functionality)

## :wrench: Installation

To install from Composer, use the following command:

```
composer require csun-metalab/sword-api-uploader
```

Now, add the following lines to your `.env` file to configure your connection to the repository:

```
SWORD_SERVICE_DOC=
SWORD_DEPOSIT=
SWORD_USERNAME=
SWORD_PASSWORD=
```

You'll also need to add other lines further down as defined in either the [Thesis File Path Environment Variables](#thesis-file-path-environment-variables) or [Regular File Path Environment Variables](#regular-file-path-environment-variables) section based on the type of deposit you're performing.

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

The configuration file will be in `config/sword.php` and you can modify those values further with the `config()` helper function before the deposit takes place.

The packaging and deposit functionality use those configuration values in order to figure out the service document, credentials, repository identifier, and the relevant directories on the filesystem.

## :notebook: Global Environment Variables

The environment variables you added to your `.env` file are the following:

### SWORD_SERVICE_DOC

This is the identifier for the service document the repository uses for SWORD uploads/deposits.

### SWORD_DEPOSIT

This is the identifer for the repository where SWORD uploads/deposits will be performed.

### SWORD_USERNAME

This is the username that will be used for authentication during SWORD operations.

### SWORD_PASSWORD

This is the password that will be used for authentication during SWORD operations.

## :mortar_board: Thesis File Path Environment Variables

You need to add these environment variables if you are performing deposits for theses or academic dissertations.

Add the following values to your `.env` file and then configure them appropriately based on their descriptions:

```
# Root directories where final thesis drafts and supplemental files are located
# These directories will be used when packaging files to send to the repository
SWORD_THESIS_DOCUMENT_ROOT_IN=
SWORD_THESIS_SUPPLEMENTAL_ROOT_IN=

# Root directories where the packaged archive and the METS file will be written
# out to on the filesystem after being packaged (before sending to the repo)
SWORD_THESIS_PACKAGE_ROOT_OUT=
SWORD_THESIS_METS_ROOT_OUT=
```

### SWORD_THESIS_DOCUMENT_ROOT_IN

This is the directory on the filesystem that holds the single thesis document file (PDF, DOCX, etc) that will be packaged.

### SWORD_THESIS_SUPPLEMENTAL_ROOT_IN

This is the directory on the filesystem that holds any supplemental files associated with the theses.

### SWORD_THESIS_PACKAGE_ROOT_OUT

This is the directory on the filesystem to where the package (ZIP file containing a thesis plus any of its supplemental files) will be written.

### SWORD_THESIS_METS_ROOT_OUT

This is the directory on the filesystem to where the metadata (mets.xml) file that describes properties associated with the thesis will be written.

## :page_facing_up: Regular File Path Environment Variables

You need to add these environment variables if you are performing non-thesis deposits for regular files (such as class syllabi).

Add the following values to your `.env` file and then configure them appropriately based on their descriptions:

```
# Root directory and subdirectory where the files to deposit are located. The
# subdirectory must be within the root directory.
SWORD_FILE_ROOT_IN=
SWORD_FILE_SUBDIR_IN=

# Root directory where the packaged archive will be written out on the filesystem
# before depositing in the repository
SWORD_PACKAGE_ROOT_OUT=
```

### SWORD_FILE_ROOT_IN

This is the directory on the filesystem where the subdirectory is located

### SWORD_FILE_SUBDIR_IN

This is the directory on the filesystem containing the files that will be deposited

### SWORD_PACKAGE_ROOT_OUT

This is the directory on the filesystem where the package (ZIP file containing the file to deposit) will be written.

## :computer: Usage

Coming Soon!

## :electric_plug: Underlying SWORD API Functionality

The underlying SWORD API functionality for packaging and depositing documents originally comes from `swordapp-php-library` created by Stuart Lewis.

You can find the code specific to the library here: https://github.com/swordapp/swordapp-php-library