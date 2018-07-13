<?php
/**
 * Created by PhpStorm.
 * User: hectnandez
 * Date: 13/07/2018
 * Time: 11:52
 */

namespace CsvXmlParser\Command;

use CsvXmlParser\Utils\File;
use CsvXmlParser\Utils\XmlGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class Parser extends Command
{
    protected function configure()
    {
        $this->setName('csv-xml:parse')
            ->setDescription('Parse a CSV document into a XML file')
            ->setHelp('This command allows you to parse CSV file into a XML file with the posibility to declare 
            an anonymous fields')
            ->addOption('filename', 'f', InputOption::VALUE_REQUIRED, 'The complete 
            path of the original file', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $originalFile = $input->getOption('filename');
        if(empty($originalFile)){
            $output->writeln('<comment>You have to specified the complete path of the file to parse</comment>');
            die();
        }
        try{
            $file = new File($output);
            $data = $file->getContent($originalFile);
            if(empty($data)){
                die();
            }
            if(!XmlGenerator::generate($data, pathinfo($originalFile, PATHINFO_FILENAME))){
                $output->writeln('<errror>Error trying to convert data into XML</errror>');
                die();
            }
            echo 'bien';
        } catch (\Exception $ex){
            $output->writeln('<errror>ERROR: '.$ex->getMessage().' | File: '.$ex->getFile().' Line: '.$ex->getLine().'</errror>');
            die();
        }
    }
}