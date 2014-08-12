<?
/*
@ Clase class.file.php
@ Autor: Jorge Silveira - jdsilveira@gmail.com - http://aboyon.com.ar
@ Clase generica que permite manejar archivos
@ ----------------------------------------------------------------------------------------
@ Upgrades:
@ NO TUVO HASTA EL MOMENTO
@
@ Se agrego el metodo $this->WriteFPuts($handler) => para escribir linea por linea en archivo
*/

class file
	{
	var $filename;
	var $size;
	var $type;
	
	/*
	@ Constructor / Constructor
	@ NOTA: solo se usa si el archivo viene definido no se invocan metodos (excepto Info) desde el constructor.
	@       this method is used only when the filename come defined (except Info method) from the constructor
	*/
	
	public function file($file="")
		{
		if ($file&&$this->isFile($file)) $this->Info($file);	
		else return;	
		}
	
	
	/*
	@ Devuelve si un archivo existe
	@ return true/false if a file exist
	*/
	
	public function isFile($file)
		{
		if (!@is_file($file))
			$this->SetError($file." is not a file or not exist",__LINE__,__FILE__);
		else
			return true;
		}
	
	/*
	@ Devuelve informacion del archivo pasado por $file
	@ NOTA: esta funcion puede ampliarse solo puse algunas caracteristicas
	@       this method return information about a file
	*/
	
	public function Info($file)
		{
		$this->OriginalName = $file;
		$this->filename = basename($file);
		$this->size = filesize($file);
		$infoPath = pathinfo($file);
		$this->type = $infoPath["extension"];
		}
	
	
	/*
	@ Copia $this->OriginalName a $dest
	@ Copy $this->OriginalName to destination
	*/
	
	public function CopyTo($dest)
		{
		if (!@copy($this->OriginalName,$dest))
			$this->SetError("Cant Copy the file",__LINE__,__FILE__);
		}
	
	/*
	@ Elimina $this->OriginalName
	@ delete $this->OriginalName file
	*/
	
	public function Delete()
		{
		if (!@unlink($this->OriginalName))
			$this->SetError("Cant Delete the file",__LINE__,__FILE__);
		}
	
	/*
	@ modifica el chmod de $this->OriginalName
	@ modify $this->OriginalName chmod of a file
	*/
	
	public function chmod($mode=0750)
		{
		if (!@chmod($this->OriginalName,$mode))
			$this->SetError("Cant Change the perms",__LINE__,__FILE__);
		}
	
	/*
	@ renombra $this->OriginalName a $newName
	@ rename $this->OriginalName to new filename 
	*/
	
	public function rn($newName)
		{
		if (!@rename($this->OriginalName,$newName))
			$this->SetError("Cant Rename the file ".$this->OriginalName." to ".$newName,__LINE__,__FILE__);
		}
		
	/*
	@ Crea una carpeta $folder
	*/
	
	public function makeDir($folder,$perms=0777)
		{
		if (!@is_dir($folder))
			@mkdir($folder,$perms);
		else
			$this->SetError("The Folder ".$folder." already exist.",__LINE__,__FILE__);
		}
	
	/*
	@ Check Dir
	*/
	
	public function isDir($folder)
		{
		if (!@is_dir($folder))
			return false;
		else
			return true;
		}
	
	
	/*
	@ Crea una carpeta $folder
	*/
	
	public function DeleteDir($folder)
		{
		if (@is_dir($folder))
			@rmdir($folder);
		else
			$this->SetError("Can't delete the folder ".$folder." this folder do not exist.",__LINE__,__FILE__);
		}
	
	
	/*
	@ Abre un enlace a un archivo con "fopen" o si no lo abre lo crea
	*/
	
	public function OpenFile($mode="w+")
		{
		$return = @fopen($this->OriginalName,$mode);
		if (!$return)
			$this->SetError("Cant open the file ".$this->OriginalName,__LINE__,__FILE__);
		else
			{
			$this->Handler = $return;
			
			return $return;
			}
		}
	
	/*
	@ Devuelve el contenido de un fichero, notar que si no le pasamos un #resourceID (producto del fopen)
	@ Tampoco aborta o cuelga todo, lo que haces es ver si esta ya definido en el objeto.
	@ setea el objeto FileContent y devuelve el contenido en caso que que quiera darle otro uso 
	*/
	public function GetContent($handler="")
		{
		$this->FileContent = (!$handler)?fread($this->Handler,$this->size):fread($handler,$this->size); 
		return $this->FileContent;
		}
	
	/*
	@ Cierra el enlace a un archivo, si le pasas el #resourceID cierra ese identificador
	@ sino cierra el instanciado en el objeto
	*/
	public function CloseFile($handler="")
		{
		return (!$handler)?fclose($this->Handler):fclose($handler); 
		}
	
	/*
	@ Escribe dentro de un fichero un contenido que le pasamos por $Content
	*/
	public function WriteFile($handler="")
		{
		$handler = (!$handler)?$this->Handler:$handler;
		if (!@fwrite($handler,$this->NewFileContent))
			$this->SetError("Can't write in file ".$this->OriginalName." the content\n\n".$Content,__LINE__,__FILE__);
		}
	
	/*
	@ Escribe dentro de un fichero un contenido que le pasamos por $Content usando FPuts (osea linea por linea)
	*/
	public function WriteFPuts($handler="")
		{
		$handler = (!$handler)?$this->Handler:$handler;
		if (!@fputs($handler,$this->NewFileContent))
			$this->SetError("Can't write in file ".$this->OriginalName." the content\n\n".$Content,__LINE__,__FILE__);
		}
	
	/*
	@ Obtiene  el contenido de una carpeta
	*/
	
	public function GetFolderContent($fName)
		{
		if (!$this->isDir($fName))
			{
			$this->SetError("Sorry but ".$fName." is not a valid folder",__FILE__,__LINE__);
			return false;
			}
		else
			{
			$handle=opendir($fName);
			while ($file = readdir($handle))
				if ($file!="."&&$file!="..")
					$this->FileList[] = $file;
			closedir($handle); 
			}
		}
		
	/*
	@ Setea el mensaje de error de cualqueir metodo
	*/
	
	public function SetError($error,$linea="not specified",$archivo="undefined")
		{
		if (!$error) $this->error = "Unknow error";
		else $this->error = $error."<br><li> Line: ".$linea."</li><li> File:".$archivo;
		}
	
	}
?>