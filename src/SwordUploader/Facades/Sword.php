<?php

namespace CSUNMetaLab\SwordUploader\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \CSUNMetaLab\SwordUploader\Uploaders\SwordUploader
 */
class Sword extends Facade
{
	/**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'sword'; }
}