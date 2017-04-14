<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Doctrine\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use InvalidArgumentException;
use Webmozart\Assert\Assert;

abstract class MapEnumType extends EnumType
{
    const TYPE_UINT8 = 'UINT8';
    const TYPE_UINT16 = 'UINT16';
    const TYPE_UINT32 = 'UINT32';

    protected $enumType;

    /**
     * {@inheritdoc}
     */
    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        $definition = null;
        $platformName = $platform->getName();

        switch ($this->enumType) {
            case static::TYPE_UINT8:
                Assert::oneOf($platformName, array('mysql'));
                $definition = 'TINYINT(1)';

                break;

            case static::TYPE_UINT16:
                $definition = $platform->getSmallIntTypeDeclarationSQL($fieldDeclaration);
                break;

            case static::TYPE_UINT32:
                $definition = $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
                break;

            default:
                throw new InvalidArgumentException('Unsupported enum type "'.$this->enumType.'"');
        }

        switch ($this->enumType) {
            case static::TYPE_UINT8:
            case static::TYPE_UINT16:
            case static::TYPE_UINT32:
                if($platformName == 'postgresql') {
                    $definition .= ' CHECK(' . $fieldDeclaration['name'] . ' > 0)';
                } else {
                    $definition .= ' unsigned';
                }
                break;
        }

        return $definition;
    }

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if($value === null) {
            return $value;
        }

        if ($this->flipValues == null) {
            $this->flipValues = array_flip($this->values);
        }

        Assert::keyExists($this->flipValues, $value);

        return $this->flipValues[$value];
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value === null) {
            return $value;
        }

        Assert::keyExists($this->values, $value);

        return $this->values[$value];
    }

    /**
     * {@inheritdoc}
     */
    public function getBindingType()
    {
        switch ($this->enumType) {
            case static::TYPE_UINT8:
            case static::TYPE_UINT16:
            case static::TYPE_UINT32:
                return \PDO::PARAM_INT;
        }

        return \PDO::PARAM_STR;
    }
}
