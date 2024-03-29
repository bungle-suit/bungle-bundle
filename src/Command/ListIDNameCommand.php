<?php
declare(strict_types=1);

namespace Bungle\FrameworkBundle\Command;

use Bungle\Framework\Ent\IDName\HighIDNameTranslatorChain;
use Bungle\Framework\Ent\IDName\HighIDNameTranslatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand('bungle:id-name')]
class ListIDNameCommand extends Command
{
    /** @var HighIDNameTranslatorInterface[]  */
    private array $translators;

    public function __construct(HighIDNameTranslatorChain $chain)
    {
        parent::__construct();

        $this->translators =  $chain->getTranslators();
    }

    protected function configure(): void
    {
        $this->setDescription('List id name translators');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $items = array_map(fn (HighIDNameTranslatorInterface $o) => get_class($o), $this->translators);
        $io->listing($items);

        return 0;
    }
}
