<?php


namespace Adipsys\testBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;


class AddContactsCommand extends ContainerAwareCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this
            ->setDescription('Populates configured entities with random data')
            ->setHelp(<<<HELP
The <info>faker:populate</info> command populates configured entities with random data.

  <info>php app/console faker:populate</info>

HELP
            )
            ->setName('contact:populate')
            ->addArgument(
                'int',
                InputArgument::OPTIONAL,
                'How many contacts?'
            )
        	;
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    	
    	
    	if ($input->getArgument('int')) {
    		$text = 'Hello '.$input->getArgument('int');
    		$populator = $this->getContainer()->get('faker.populator');
    		$populator->addEntity('Adipsys\testBundle\Entity\Contact', $input->getArgument('int'));
    		$insertedPks = $populator->execute();
    		$output->writeln($text);
    		 
    		if (0 === count($insertedPks)) {
    			$output->writeln('<error>No entities populated.</error>');
    		} else {
    			foreach ($insertedPks as $class => $pks) {
    				$reflClass = new \ReflectionClass($class);
    				$shortClassName = $reflClass->getShortName();
    				$output->writeln(sprintf('Inserted <info>%s</info> new <info>%s</info> objects', count($pks), $shortClassName));
    			}
    		}
    	} else {
    		
    		$text = 'Hello';
    		$populator = $this->getContainer()->get('faker.populator');
    		//$populator->addEntity('Adipsys\testBundle\Entity\Contact', $input->getArgument('int'));
    		$insertedPks = $populator->execute();
    		$output->writeln($text);
    		 
    		if (0 === count($insertedPks)) {
    			$output->writeln('<error>No entities populated.</error>');
    		} else {
    			foreach ($insertedPks as $class => $pks) {
    				$reflClass = new \ReflectionClass($class);
    				$shortClassName = $reflClass->getShortName();
    				$output->writeln(sprintf('Inserted <info>%s</info> new <info>%s</info> objects', count($pks), $shortClassName));
    			}
    		}
    	}
    	
    	 
         
    }
}
