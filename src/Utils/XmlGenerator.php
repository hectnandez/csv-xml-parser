<?php
/**
 * Created by PhpStorm.
 * User: hectnandez
 * Date: 13/07/2018
 * Time: 14:30
 */

namespace CsvXmlParser\Utils;


class XmlGenerator
{
    /**
     * @param $data
     * @param $filename
     * @return bool
     */
    public static function generate($data, $filename){
        try{
            $xml = new \SimpleXMLElement('<root/>');
            array_walk_recursive($data, array($xml, 'addChild'));
            $xml->saveXML(__DIR__.DIRECTORY_SEPARATOR.$filename.'.xml');
            return true;
        }  catch (\Exception $ex){
            return false;
        }
    }
}