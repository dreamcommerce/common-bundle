<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    /**
     * @param Event $event
     */
    public static function copyTemplateDir(Event $event)
    {
        $config = $event->getComposer()->getConfig();
        $templateSourceDir = $config->get('vendor-dir').'/dreamcommerce/common-bundle/template';
        $templateDestinationDir = './';

        static::copyDirectory($templateSourceDir, $templateDestinationDir);
    }

    /**
     * @param string $source
     * @param string $destination
     */
    private static function copyDirectory(string $source, string $destination)
    {
        foreach (
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($source, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST) as $item
        ) {
            if ($item->isDir()) {
                $dirPath = $destination.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
                if (!file_exists($dirPath)) {
                    @mkdir($dirPath);
                }
            } else {
                $filePath = $destination.DIRECTORY_SEPARATOR.$iterator->getSubPathName();
                if (!file_exists($filePath)) {
                    @copy($item, $filePath);
                }
            }
        }
    }
}
