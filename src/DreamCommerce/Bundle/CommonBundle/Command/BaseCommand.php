<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @link https://www.dreamcommerce.com
 */

declare(strict_types=1);

namespace DreamCommerce\Bundle\CommonBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Output\OutputInterface;

abstract class BaseCommand extends ContainerAwareCommand
{
    /**
     * @param OutputInterface $output
     * @param string          $message
     * @param string          $type
     */
    protected function printMessageBox(OutputInterface $output, $message, $type = 'error'): void
    {
        $formatter = $this->getHelper('formatter');
        $messages = array('', $message, '');

        $formattedBlock = $formatter->formatBlock($messages, $type);
        $output->writeln('');
        $output->writeln($formattedBlock);
        $output->writeln('');
    }
}
