<?php

class UTL {

    public static function _console($log_line){
        if(isset($log_line)){
    	  $log = htmlspecialchars($log_line);
          echo "<script>console.log('$log')</script>";
    	}
    }

    public static function _redirect($url){
		die("<script>self.location.href = '$url'; </script>");
	}

	public static function _dbconnect($host, $dbname, $user, $pss){
		if(isset($host) && isset($dbname) && isset($user) && isset($pss)){
            R::setup('mysql:host='.$host.';dbname='.$dbname, $user, $pss);
            return true;
        }else{
        	return false;
        }
	}

    public static function _signin($user, $login, $pass){
        if($user['pass'] == $pass){

            $role = RBAC::get_role($login);
            $_SESSION['auth'] = true;
            $_SESSION['role'] = $role;
            $_SESSION['login'] = $login;
            $_SESSION[$role] = true;

            UTL::_redirect('http://' . $_SERVER['HTTP_HOST']. '/?view='.RBAC::load_proper_view($role,'page'));

        }else{
            UTL::_console("Пароль введен не верно.");
        }
    }

}

function read_doc($file){
	if(isset($file) && !empty($file)){
	  $fHandle = fopen($file->filename, "r");
	  $line = @fread($fHandle, filesize($file->filename));
	  $lines= explode(chr(0x0D), $line);
	  $outtext = "";

	  foreach ($lines as $thisline) {
		$pos = strpos($thisline, chr(0x00));
		if(!$pos || strlen($thisline) == 0){

		}else{
		  $outtext .= $thisline." ";
		}
	  }
	  $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);

	  return $outtext;
	}else{
	  UTL::_console("Don't read");
	}
}

function read_docx($file){
    if(isset($file)){
        $striped_content = '';
        $content = '';

        $zip = zip_open($file->filename);

        if (!$zip || is_numeric($zip)) return false;

        while ($zip_entry = zip_read($zip)) {

          if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

          if (zip_entry_name($zip_entry) != "word/document.xml") continue;

          $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

          zip_entry_close($zip_entry);
        }// end while

        zip_close($zip);

        $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
        $content = str_replace('</w:r></w:p>', "\r\n", $content);
        $striped_content = strip_tags($content);

        return $striped_content;
    }else{
        UTL::_console("Don't read");
    }
}

function get_extension($filename){
	$inf = new SplFileInfo($filename);
	var_dump($info->getExtension());
}

?>
