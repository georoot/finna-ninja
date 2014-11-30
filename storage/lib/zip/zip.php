<?php
class zip{
    public function __construct($input,$name){
        include_once("CreateZipFile.inc.php");
        $createZipFile=new CreateZipFile;
        $directoryToZip=$input;
        $outputDir=$GLOBALS['path_uploads'];
        $zipName=$name.".zip";
        $createZipFile->zipDirectory($directoryToZip,$outputDir);
        $fd=fopen($zipName, "wb");
        $out=fwrite($fd,$createZipFile->getZippedfile());
        fclose($fd);
    }
}

?>
