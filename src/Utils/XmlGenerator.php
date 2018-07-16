<?php
/**
 * Created by PhpStorm.
 * User: hectnandez
 * Date: 13/07/2018
 * Time: 14:30
 */

namespace CsvXmlParser\Utils;

use Symfony\Component\Filesystem\Filesystem;

class XmlGenerator
{
    /**
     * @param $data
     * @param $filename
     * @return bool
     */
    public static function generate($data, $filename){
        try{
            $fs = new Filesystem();
            if(!$fs->exists(DIR_XML)){
                $fs->mkdir(DIR_XML);
            }
            $configData = self::getPrivatesFields();
            $privatesFields = $configData->private_fields;
            $xml = new \SimpleXMLElement('<root/>');
            foreach ($data as $rowData){
                $row = $xml->addChild('row');
                foreach ($rowData as $field => $value){
                    if(in_array($field, $privatesFields)){
                        $row->addChild($field, md5($value));
                        continue;
                    }
                    $row->addChild($field, $value);

                }
            }
            $xml->saveXML(DIR_XML.DIRECTORY_SEPARATOR.$filename.'.xml');
            return true;
        }  catch (\Exception $ex){
            return false;
        }
    }

    /**
     * @return array|\stdClass
     */
    private static function getPrivatesFields(){
        return json_decode(file_get_contents(DIR_CONFIG.DIRECTORY_SEPARATOR.'config.json'));
    }
}