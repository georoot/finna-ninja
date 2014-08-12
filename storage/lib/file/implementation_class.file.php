<?
include(YOUR_CLASS_PATH."class.file.php");
$File = new File("the_file.txt");

//Copy to destination
$File->CopyTo("new_folder/destination.txt");

//Rename
$File->rn("new_file_name.php");

//Delete the current file
$File->Delete();

//Create a folder
$File->makeDir("my_folder");

//Open a file and modify the content
$File->OpenFile("w+");
$File->GetContent();
$File->FileContent = "new content of the file";
$File->WriteFile();
$File->CloseFile();

//get a folder content and display it
$File->GetFolderContent("my_folder");

for ($f=0; $f<count($File->FileList); $f++)
	echo $File->FileList[$f]."\n<br />"

?>