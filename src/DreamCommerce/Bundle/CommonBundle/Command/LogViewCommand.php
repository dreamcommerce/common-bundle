<?php

/*
 * (c) 2017 DreamCommerce
 *
 * @package DreamCommerce\Component\Common
 * @author Michał Korus <michal.korus@dreamcommerce.com>
 * @author Przemysław Pawliczuk
 * @link https://www.dreamcommerce.com
 */

namespace DreamCommerce\Bundle\CommonBundle\Command;

use DirectoryIterator;
use SplFileObject;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class LogViewCommand extends BaseCommand
{
    /**
     * @var OutputInterface
     */
    protected $output;
    /**
     * @var InputInterface
     */
    protected $input;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dream_commerce:log_view')
            ->addOption('type', 't', InputOption::VALUE_OPTIONAL, 'Specify type to show', 'error')
            ->setDescription('Dump desired log file respecting new lines');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $this->input = $input;

        $helper = $this->getHelper('question');
        $logs = $this->getLogsList();
        $question = new ChoiceQuestion(
            'Choose file to view',
            $logs,
            0
        );

        $filename = $helper->ask($input, $output, $question);
        $filePath = sprintf('%s/%s', $this->getContainer()->get('kernel')->getLogDir(), $filename);

        if(file_exists($filePath)) {
            $this->showLog($filePath);
        } else {
            $this->printMessageBox($output, 'File "' . $filePath . '" does not exist');
        }

        $output->writeln('');
    }

    protected function showLog($filePath)
    {
        $log = new SplFileObject($filePath);
        $type = $this->input->getOption('type');

        foreach ($log as $i) {
            if (!preg_match("/\\[[^\\[]+\\] [^\\.]+\\.".preg_quote($type)."/i", $i)) {
                continue;
            }

            $i = $this->formatLine($i);
            $this->output->writeln($i);
        }
    }

    protected function getLogsList()
    {
        $result = array();
        $dir = $this->getContainer()->get('kernel')->getLogDir();
        $iterator = new DirectoryIterator($dir);

        foreach ($iterator as $i) {
            if ($i->isDir() || $i->getBasename()[0]=='.') {
                continue;
            }

            $result[] = $i->getBasename();
        }

        return $result;
    }

    protected function formatLine($i)
    {
        $i = str_replace("\\n", PHP_EOL, $i);
        return $i;
    }
}
