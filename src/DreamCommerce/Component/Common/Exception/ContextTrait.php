<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\BugTracker
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Component\Common\Exception;

use DreamCommerce\Component\Common\Model\ArrayableInterface;

trait ContextTrait
{
    /**
     * @var array|null
     */
    protected $context;

    /**
     * @return array
     */
    public function getExceptionContext(): array
    {
        if($this->context === null) {
            $this->context = array();
            if($this instanceof ArrayableInterface) {
                foreach($this->toArray() as $k => $v) {
                    if($v !== null) {
                        $this->context[$k] = $v;
                    }
                }
            }
        }

        return $this->context;
    }

    /**
     * @param array $context
     *
     * @return $this
     */
    public function setExceptionContext(array $context = array())
    {
        $this->context = $context;

        return $this;
    }
}
