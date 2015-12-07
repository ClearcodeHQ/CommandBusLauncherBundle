<?php

namespace Clearcode\CommandBusConsole\Bundle\Command;

use Matthias\SymfonyConsoleForm\Console\Command\InteractiveFormContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CommandBusHandleCommand extends InteractiveFormContainerAwareCommand
{
    const SUCCESS_CODE = 0;
    const ERROR_CODE = 1;

    /** @var string */
    private $alias;

    /** @var string */
    private $formType;

    public function __construct($alias, $formType)
    {
        $this->alias = $alias;
        $this->formType = $formType;

        parent::__construct();
    }

    /** {@inheritdoc} */
    public function formType()
    {
        return $this->formType;
    }

    /** {@inheritdoc} */
    protected function configure()
    {
        $this
            ->setName(sprintf('command-bus:%s', $this->alias))
        ;
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->getContainer()->get('command_bus')->handle($this->formData());
        } catch (\Exception $e) {
            return $this->handleException($output, $e);
        }

        return $this->handleSuccess($output, get_class($this->formData()));
    }

    private function handleException(OutputInterface $output, \Exception $exception)
    {
        $output->writeln(sprintf('<error>%s</error>', $exception->getMessage()));

        return self::ERROR_CODE;
    }

    private function handleSuccess(OutputInterface $output, $commandToLunch)
    {
        $output->writeln(sprintf('The <info>%s</info> executed with success.', $commandToLunch));

        return self::SUCCESS_CODE;
    }
}
