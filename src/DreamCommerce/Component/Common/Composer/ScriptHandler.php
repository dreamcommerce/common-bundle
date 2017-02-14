<?php

namespace DreamCommerce\Component\Common\Composer;

use Composer\Script\Event;

class ScriptHandler
{
    /**
     * @param Event $event
     */
    public static function copyPhpCodeSnifferFiles(Event $event)
    {
        $bundleDir = static::getBundleDirectory($event);
        $sourceDir = $bundleDir . '/.php_cs';
        $destinationDir = './';

        if(!file_exists($destinationDir)) {
            @copy($sourceDir, $destinationDir);
        }
    }

    /**
     * @param Event $event
     */
    public static function copyDockerFiles(Event $event)
    {
        $bundleDir = static::getBundleDirectory($event);
        $buildSourceDir = $bundleDir . '/tools/docker/build';
        $buildDestinationDir = './build';

        if(!file_exists($buildDestinationDir)) {
            static::copyDirectory($buildSourceDir, $buildDestinationDir);
        }

        $configSourceFile = $bundleDir . '/tools/docker/etc/docker-compose.yml.dist';
        $configDestinationFile = './etc/docker-compose.yml';

        if(!file_exists($configDestinationFile)) {
            @copy($configSourceFile, $configDestinationFile);
        }

        $configDestinationFile .= '.dist';

        if(!file_exists($configDestinationFile)) {
            @copy($configSourceFile, $configDestinationFile);
        }
    }

    /**
     * @param Event $event
     * @return string
     */
    private static function getBundleDirectory(Event $event): string
    {
        $config = $event->getComposer()->getConfig();

        return $config->get('vendor-dir') . '/dreamcommerce/common-bundle';
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
                @mkdir($destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            } else {
                @copy($item, $destination . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
            }
        }
    }
}