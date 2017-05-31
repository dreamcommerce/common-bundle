<?php

namespace DreamCommerce\Component\Common\Model;

use SimpleXMLElement;

class ExtendedXMLElement extends SimpleXMLElement
{
    /**
     * Add SimpleXMLElement code into a SimpleXMLElement
     *
     * @param SimpleXMLElement $append
     */
    public function appendXML(SimpleXMLElement $append)
    {
        if (strlen(trim((string)$append)) == 0) {
            $xml = $this->addChild($append->getName());
        } else {
            $xml = $this->addChild($append->getName(), (string)$append);
        }

        foreach ($append->children() as $child) {
            if($xml instanceof ExtendedXMLElement) {
                $xml->appendXML($child);
            }
        }

        foreach ($append->attributes() as $n => $v) {
            $xml->addAttribute($n, $v);
        }
    }
}