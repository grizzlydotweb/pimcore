<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Commercial License (PCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 *  @license    http://www.pimcore.org/license     GPLv3 and PCL
 */

namespace Pimcore\HttpKernel\CacheWarmer;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpKernel\CacheWarmer\CacheWarmerInterface;

/**
 * Creates needed pimcore directories when warming up the cache
 *
 * @internal
 */
class MkdirCacheWarmer implements CacheWarmerInterface
{
    /**
     * @var int
     */
    private $mode;

    /**
     * @param int $mode
     */
    public function __construct($mode = 0775)
    {
        $this->mode = $mode;
    }

    /**
     * {@inheritdoc}
     */
    public function isOptional()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function warmUp($cacheDir)
    {
        $directories = [
            // var
            PIMCORE_CLASS_DIRECTORY,
            PIMCORE_CLASS_DEFINITION_DIRECTORY,
            PIMCORE_CONFIGURATION_DIRECTORY,
            PIMCORE_CUSTOMLAYOUT_DIRECTORY,
            PIMCORE_LOG_DIRECTORY,
            PIMCORE_LOG_FILEOBJECT_DIRECTORY,
            PIMCORE_LOG_MAIL_PERMANENT,
            PIMCORE_SYSTEM_TEMP_DIRECTORY,
        ];

        $fs = new Filesystem();
        foreach ($directories as $directory) {
            if (!$fs->exists($directory)) {
                $fs->mkdir($directory, $this->mode);
            }
        }

        return [];
    }
}
