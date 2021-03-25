<?php

namespace App\Command;

use App\Repository\Query\FindAllForPayrollReport;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;

class PayrollReportCommand extends Command
{
    protected static $defaultName = 'payroll:report';
    protected static $defaultDescription = 'Generate a payroll';

    private FindAllForPayrollReport $query;

    public function __construct(FindAllForPayrollReport $query)
    {
        $this->query = $query;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setDescription(self::$defaultDescription)
            ->addOption('sort', 's', InputOption::VALUE_REQUIRED, 'Field to sort by')
            ->addOption('desc', 'd', InputOption::VALUE_NONE, 'Desc sorting order ASC by default')
            ->addOption('filter-dept', null, InputOption::VALUE_REQUIRED)
            ->addOption('filter-first-name', null, InputOption::VALUE_REQUIRED)
            ->addOption('filter-last-name', null, InputOption::VALUE_REQUIRED)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $query = $this->query;
        $query->setFilterDepartment($input->getOption('filter-dept'));
        $query->setFilterFirstName($input->getOption('filter-first-name'));
        $query->setFilterLastName($input->getOption('filter-last-name'));

        $query->setSortColumn($input->getOption('sort'));
        $query->setSortOrder($input->getOption('desc') ? 'DESC' : 'ASC');

        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $normalizer = new ObjectNormalizer($classMetadataFactory);
        $serializer = new Serializer([$normalizer]);

        $table = new Table($output);
        $table
            ->setHeaders(['Name', 'Surname', 'Salary (base)', 'With bonus', 'Department', 'Bonus', 'Bonus type'])
        ;

        foreach ($query() as $result) {
            $normalized = $serializer->normalize($result, null, ['groups' => 'report']);
            $table->addRow(array_values($this->flatten($normalized)));
        }

        $table->render();

        return Command::SUCCESS;
    }

    private function flatten(array $array) {
        $return = [];
        array_walk_recursive($array, function($a) use (&$return) { $return[] = $a; });
        return $return;
    }
}
