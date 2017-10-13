<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Component\Common\Model;

use SimpleXMLElement;

class ExtendedXMLElement extends SimpleXMLElement
{
    /**
     * Add SimpleXMLElement code into a SimpleXMLElement
     *
     * @param SimpleXMLElement $append
     */
    public function appendXML(SimpleXMLElement $append): void
    {
        if (strlen(trim((string)$append)) == 0) {
            $xml = $this->addChild($append->getName());
        } else {
            $xml = $this->addChild($append->getName(), (string)$append);
        }

        foreach ($append->children() as $child) {
            if ($xml instanceof ExtendedXMLElement) {
                $xml->appendXML($child);
            }
        }

        foreach ($append->attributes() as $n => $v) {
            $xml->addAttribute($n, $v);
        }
    }
}
