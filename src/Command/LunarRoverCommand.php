<?php

namespace App\Command;

use App\Service\RoverMovement;
use App\Factory\MoonFactory;
use App\Factory\RoverFactory;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class LunarRoverCommand extends Command
{
    protected static $defaultName = 'cmd:lunar-rover';
    protected static $defaultDescription = 'Add a short description for your command';

    public function __construct(
        protected MoonFactory $moonFactory,
        protected RoverFactory $roverFactory,
        protected RoverMovement $roverMovement
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription(self::$defaultDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $io = new SymfonyStyle($input, $output);

            $helper = $this->getHelper('question');
            $question = new Question("Enter world size on first line\nThen add as many rover start positions"
                . ", directions (N, E, S or W) and commands (L, R or F) as you'd like, each on their own line\n"
                . "Example:\n5 8\n[3, 4, S] RRFFLRFFF\n[1, 8, N] FRFFLLFF\n[0, 0, E] LFRFLFRF\n"
                . "Finish with CTRL+Z (Windows) or Ctrl+D (other systems)\n"
            );
            $question->setMultiline(true);
            $answers = $helper->ask($input, $output, $question);
            if ($answers === null) {
                throw new Exception('No data entered. Please see example');
            }

            $lines = explode("\n", $answers);
            $worldCoordinates = $lines[0];
            $world = $this->moonFactory->createFromCoordinates($worldCoordinates);

            $rovers = array_slice($lines, 1);
            if (count($rovers) === 0) {
                throw new Exception('No rovers added. Please see example');
            }

            $io->writeln("\nFinal positions:");

            foreach ($rovers as $roverPositionAndCommands) {
                $rover = $this->roverFactory->createFromData($world, $roverPositionAndCommands);
                $this->roverMovement->executeVehicleCommands($rover);
                $io->writeln($rover->getPosition()->getCurrentPosition());
            }

            return Command::SUCCESS;
        } catch (Exception $e) {
            $io->error($e->getMessage());

            return Command::FAILURE;
        }
    }
}
