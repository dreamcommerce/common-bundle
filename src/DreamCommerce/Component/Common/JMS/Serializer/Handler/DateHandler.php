<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\JMS\Serializer\Handler;

use JMS\Serializer\Context;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\JsonDeserializationVisitor;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\XmlDeserializationVisitor;
use JMS\Serializer\XmlSerializationVisitor;

class DateHandler implements SubscribingHandlerInterface
{
    private $defaultFormat;
    private $defaultTimezone;
    private $xmlCData;

    public static function getSubscribingMethods()
    {
        $methods = array();
        $deserialisationTypes = array('Date', 'date');
        $serialisationTypes = array('Date', 'date');

        foreach (array('json', 'xml', 'yml') as $format) {
            foreach ($deserialisationTypes as $type) {
                $methods[] = array(
                    'type'      => $type,
                    'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                    'format'    => $format,
                );
            }

            foreach ($serialisationTypes as $type) {
                $methods[] = array(
                    'type' => $type,
                    'format' => $format,
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'method' => 'serialize'.$type,
                );
            }
        }

        return $methods;
    }

    public function __construct($defaultFormat = 'Y-m-d', $defaultTimezone = 'UTC', $xmlCData = true)
    {
        $this->defaultFormat = $defaultFormat;
        $this->defaultTimezone = new \DateTimeZone($defaultTimezone);
        $this->xmlCData = $xmlCData;
    }

    public function serializeDate(VisitorInterface $visitor, \DateTime $date, array $type, Context $context)
    {
        if ($visitor instanceof XmlSerializationVisitor && false === $this->xmlCData) {
            return $visitor->visitSimpleString($date->format($this->getFormat($type)), $type, $context);
        }

        $format = $this->getFormat($type);
        if ('U' === $format) {
            return $visitor->visitInteger($date->format($format), $type, $context);
        }

        return $visitor->visitString($date->format($this->getFormat($type)), $type, $context);
    }

    private function isDataXmlNull($data)
    {
        $attributes = $data->attributes('xsi', true);
        return isset($attributes['nil'][0]) && (string) $attributes['nil'][0] === 'true';
    }

    public function deserializeDateFromXml(XmlDeserializationVisitor $visitor, $data, array $type)
    {
        if ($this->isDataXmlNull($data)) {
            return null;
        }

        return $this->parseDate($data, $type);
    }

    public function deserializeDateFromJson(JsonDeserializationVisitor $visitor, $data, array $type)
    {
        if (null === $data) {
            return null;
        }

        return $this->parseDate($data, $type);
    }

    private function parseDate($data, array $type, $immutable = false)
    {
        $timezone = isset($type['params'][1]) ? new \DateTimeZone($type['params'][1]) : $this->defaultTimezone;
        $format = $this->getFormat($type);

        if ($immutable) {
            $datetime = \DateTimeImmutable::createFromFormat($format, (string) $data, $timezone);
        } else {
            $datetime = \DateTime::createFromFormat($format, (string) $data, $timezone);
        }

        if (false === $datetime) {
            throw new RuntimeException(sprintf('Invalid datetime "%s", expected format %s.', $data, $format));
        }

        if (PHP_VERSION_ID < 71000) {
            $datetime->setTime(0, 0, 0);
        } else {
            $datetime->setTime(0, 0, 0, 0);
        }

        return $datetime;
    }

    /**
     * @return string
     * @param array $type
     */
    private function getFormat(array $type)
    {
        return isset($type['params'][0]) ? $type['params'][0] : $this->defaultFormat;
    }

    /**
     * @param \DateInterval $dateInterval
     * @return string
     */
    public function format(\DateInterval $dateInterval)
    {
        $format = '';

        if (0 < $dateInterval->y) {
            $format .= $dateInterval->y.'Y';
        }

        if (0 < $dateInterval->m) {
            $format .= $dateInterval->m.'M';
        }

        if (0 < $dateInterval->d) {
            $format .= $dateInterval->d.'D';
        }

        return $format;
    }
}
