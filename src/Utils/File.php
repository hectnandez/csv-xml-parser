<?php
/**
 * Created by PhpStorm.
 * User: hectnandez
 * Date: 13/07/2018
 * Time: 12:32
 */

namespace CsvXmlParser\Utils;

use Box\Spout\Common\Type;
use Box\Spout\Reader\CSV\Reader;
use Box\Spout\Reader\ReaderFactory;
use Symfony\Component\Console\Output\OutputInterface;

class File
{
    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * File constructor.
     * @param OutputInterface $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @param $filename
     * @return array|bool
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    public function getContent($filename){
        $file = self::get($filename);
        if(!self::validateFile($file)){
            $this->output->writeln('<error>The file is not a valid .csv extension</error>');
            return false;
        }
        $data = $this->getData($file);
        if(empty($data)){
            $this->output->writeln('<error>The file is empty</error>');
            return false;
        }
        return $data;
    }

    /**
     * @param $filename
     * @return array|bool
     */
    private static function get($filename){
        $filename = realpath($filename);
        if(!file_exists(realpath($filename))){
            return false;
        }
        return $filename;
    }

    /**
     * @param $filename
     * @return bool
     */
    private function validateFile($filename){
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        if(strtolower($extension) !== 'csv'){
            return false;
        }
        return true;
    }

    /**
     * @param $filename
     * @return array
     * @throws \Box\Spout\Common\Exception\IOException
     * @throws \Box\Spout\Reader\Exception\ReaderNotOpenedException
     */
    private function getData($filename){
        $data = array();
        $reader = new Reader();
        $reader->setFieldDelimiter($this->detectDelimiter($filename));
        $reader->open($filename);
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $data[] = $row;
                break;
            }
        }
        $reader->close();
        return $data;
    }

    /**
     * @param string $csvFile
     * @return false|int|string
     */
    private function detectDelimiter($csvFile)
    {
        $delimiters = array(
            ';' => 0,
            ',' => 0,
            "\t" => 0,
            '|' => 0,
        );
        $handle = fopen($csvFile, "r");
        $firstLine = fgets($handle);
        fclose($handle);
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }
        return array_search(max($delimiters), $delimiters);
    }
}