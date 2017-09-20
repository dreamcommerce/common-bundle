<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Doctrine\DBAL\Types;

use DateTime;
use DateTimeZone;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\DateTimeType;
use Webmozart\Assert\Assert;

class UTCDateType extends DateTimeType
{
    const TYPE_NAME = 'dc_utc_date';

    private static $utc = null;

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        /* @var DateTime $value */
        Assert::isInstanceOf($value, DateTime::class);

        if (is_null(self::$utc)) {
            self::$utc = new DateTimeZone('UTC');
        }

        $value->setTimeZone(self::$utc);

        return $value->format($platform->getDateFormatString());
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null) {
            return null;
        }

        if (is_null(self::$utc)) {
            self::$utc = new DateTimeZone('UTC');
        }

        $val = DateTime::createFromFormat($platform->getDateFormatString(), $value, self::$utc);

        if (!$val) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return $val;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
