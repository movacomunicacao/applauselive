<?php
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*                                   ----------- CORE FUNCTIONS -----------
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/

function load($url,$options=array()) {
//This code is from Paul Brighton, with some changes on it. https://github.com/berighton

    $default_options = array(
        'method'        => 'get',
        'post_data'        => true,
        'return_info'    => false,
        'return_body'    => true,
        'cache'            => false,
        'referer'        => '',
        'headers'        => array(),
        'session'        => false,
        'session_close'    => false,
    );

    // Sets the default options.
    $options = (array) $default_options;
    foreach($default_options as $opt=>$value) {
        if(!isset($options["$opt"])) $options["$opt"] = $value;
    }

    $url_parts = parse_url($url);
    $ch = false;
    $info = array(//Currently only supported by curl.
        'http_code'    => 200
    );
    $response = '';

    $send_header = array(
        'Accept' => 'text/*',
        'User-Agent' => 'BinGet/1.00.A (http://www.bin-co.com/php/scripts/load/)'
    ) + $options['headers']; // Add custom headers provided by the user.

    if($options['cache']) {
        $cache_folder = joinPath(sys_get_temp_dir(), 'php-load-function');
        if(isset($options['cache_folder'])) $cache_folder = $options['cache_folder'];
        if(!file_exists($cache_folder)) {
            $old_umask = umask(0); // Or the folder will not get write permission for everybody.
            mkdir($cache_folder, 0777);
            umask($old_umask);
        }

        $cache_file_name = md5($url) . '.cache';
        $cache_file = joinPath($cache_folder, $cache_file_name); //Don't change the variable name - used at the end of the function.

        if(file_exists($cache_file)) { // Cached file exists - return that.
            $response = file_get_contents($cache_file);

            //Seperate header and content
            $separator_position = strpos($response,"\r\n\r\n");
            $header_text = substr($response,0,$separator_position);
            $body = substr($response,$separator_position+4);

            foreach(explode("\n",$header_text) as $line) {
                $parts = explode(": ",$line);
                if(count($parts) == 2) $headers["$parts[0]"] = chop($parts[1]);
            }
            $headers['cached'] = true;

            if(!$options['return_info']) return $body;
            else return array('headers' => $headers, 'body' => $body, 'info' => array('cached'=>true));
        }
    }

    if(isset($options['post_data'])) { //There is an option to specify some data to be posted.
        $options['method'] = 'post';

        if(is_array($options['post_data'])) { //The data is in array format.
            $post_data = array();
            foreach($options['post_data'] as $key=>$value) {
                $post_data[] = "$key=" . urlencode($value);
            }
            $url_parts['query'] = implode('&', $post_data);
        } else { //Its a string
            $url_parts['query'] = $options['post_data'];
        }
    } elseif(isset($options['multipart_data'])) { //There is an option to specify some data to be posted.
        $options['method'] = 'post';
        $url_parts['query'] = $options['multipart_data'];
    }
    ///////////////////////////// Curl /////////////////////////////////////
        if(isset($options['post_data'])) { //There is an option to specify some data to be posted.
            $page = $url;
            $options['method'] = 'post';

            if(is_array($options['post_data'])) { //The data is in array format.
                $post_data = array();
                foreach($options['post_data'] as $key=>$value) {
                    $post_data[] = "$key=" . urlencode($value);
                }
                $url_parts['query'] = implode('&', $post_data);

            } else { //Its a string
                $url_parts['query'] = '';
            }
        } else {
            if(isset($options['method']) and $options['method'] == 'post') {
                $page = $url_parts['scheme'] . '://' . 'localhost' . $url_parts['path'];
            } else {
                $page = $url;
            }
        }

        if($options['session'] and isset($GLOBALS['_binget_curl_session']))  {
          $ch = $GLOBALS['_binget_curl_session']; //Session is stored in a global variable
        } else {
          $ch = curl_init('localhost');
        }

        curl_setopt($ch, CURLOPT_URL, $page) or die("Invalid cURL Handle Resouce");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); //Just return the data - not print the whole thing.

        curl_setopt($ch, CURLOPT_NOBODY, !($options['return_body'])); //The content - if true, will not download the contents. There is a ! operation - don't remove it.
        $tmpdir = NULL; //This acts as a flag for us to clean up temp files
        if(isset($options['method']) and $options['method'] == 'post' and isset($url_parts['query'])) {
            curl_setopt($ch, CURLOPT_POST, true);
            if(is_array($url_parts['query'])) {
                //multipart form data (eg. file upload)
                $postdata = array();
                foreach ($url_parts['query'] as $name => $data) {
                    if (isset($data['contents']) && isset($data['filename'])) {
                        if (!isset($tmpdir)) { //If the temporary folder is not specifed - and we want to upload a file, create a temp folder.
                            //  :TODO:
                            $dir = sys_get_temp_dir();
                            $prefix = 'load';

                            if (substr($dir, -1) != '/') $dir .= '/';
                            do {
                                $path = $dir . $prefix . mt_rand(0, 9999999);
                            } while (!mkdir($path, $mode));

                            $tmpdir = $path;
                        }
                        $tmpfile = $tmpdir.'/'.$data['filename'];
                        file_put_contents($tmpfile, $data['contents']);
                        $data['fromfile'] = $tmpfile;
                    }
                    if (isset($data['fromfile'])) {
                        // Not sure how to pass mime type and/or the 'use binary' flag
                        $postdata["$name"] = '@'.$data['fromfile'];
                    } elseif (isset($data['contents'])) {
                        $postdata["$name"] = $data['contents'];
                    } else {
                        $postdata["$name"] = '';
                    }
                }
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            } else {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $url_parts['query']);
            }
        }

        curl_setopt($ch, CURLOPT_COOKIEJAR, "/tmp/binget-cookie.txt");
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        global $response;
        $response = curl_exec($ch);

        if(isset($tmpdir)) {
            //rmdirr($tmpdir); //Cleanup any temporary files
        }

        $info = curl_getinfo($ch); //Some information on the fetch

        if($options['session'] and !$options['session_close']){
          $GLOBALS['_binget_curl_session'] = $ch;
        } else {
          curl_close($ch);
        }

} //endfunction


/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/

$array_counter 	= 0;
$get_to_replace	= array();
$get_result 	= array();

function construct_page($page, $archive){

	  global $response;
    global $id;
    global $get_to_replace;
    global $get_result;
    global $items2content;

    $site   = explode('/', $_SERVER['PHP_SELF']);
    $path   = SERVER_DIR.PAGES_DIR.$page.DS;
    $complement = '?page=';

    if($archive == 'top.php' || $archive == 'footer.php'){
      $path = SERVER_DIR.ELEMENTS_DIR;
    }

    if($archive == 'item.php'){
        $id = '&id='.$id;
    } else {
        $id = '';
    }

    if($page == ''){
        $page = 'home';
    }

	$file 	= $path.$archive.$complement.$page.$id;


	load($file, '');

  $source = $response;

  $preg   = preg_match_all("'<loop>(.*?)</loop>'si", $source, $match);

	if(!empty($preg)){

    preg_match_all("'<loop>(.*?)</loop>'si", $source, $match);
    $content = $match[0];

    $preg_sql = preg_match_all("'<sql>(.*?)</sql>'si", $source, $match);
    if(!empty($preg_sql)){
      $match_count = preg_match_all("'<sql>(.*?)</sql>'si", $source, $match);
      $sql_options = $match[1];
    } else {
      $sql_options = 'no sql';
    }

        $x = 0;
        foreach ($content as $cont) {

          if($sql_options == 'no sql'){

            $table    = ' '.$page.' ';
            $where    = ' ';
            $extras   = ' ';
            $orderby = ' ';
            $order    = ' ';
            $limit    = ' ';

          } else {

            parse_str(strtr($sql_options[$x], "=;", "=&"), $value);

            if(!isset($value['table'])){ $table = ' '.$page.' '; } else { $table = $value['table']; }
            if(!isset($value['where'])){ $where = ' '; } else { $where = $value['where']; }
            if(!isset($value['extras'])){ $extras = ' '; } else { $extras = $value['extras']; }
            if(!isset($value['orderby'])){ $orderby = ' '; } else { $orderby = $value['orderby']; }
            if(!isset($value['order'])){ $order = ' '; } else { $order = $value['order']; }
            if(!isset($value['limit'])){ $limit = ' '; } else { $limit = $value['limit']; }

          }

          loop_page($table,$cont,$where,$extras,$orderby,$order,$limit);
          $x++;

          $get_to_replace[] = $cont;

        }

		$final = str_replace($get_to_replace, $get_result, $source);


		$show_source = show_source('app/config/directories.php', 'false');
		$show_source = str_replace(array('define</span><span style="color: #007700">(</span><span style="color: #DD0000">', '</span><span style="color: #007700">'), array("<start>", "</start>"), $show_source);
		$show_source = str_replace("'", "", $show_source);
		preg_match_all("'<start>(.*?)</start>'si", $show_source, $match); $dirs = $match[1];

		$dirs_value_array = array();

		foreach ($dirs as $dirs_value) {
			if(strpos($final, $dirs_value) == true){
				$final = str_replace($dirs_value, constant($dirs_value), $final);
			}
		}

    //vCleaning <loop> markers
    $final = str_replace(array("<loop>", "</loop>"), array("", ""), $final);
    preg_match_all("'<sql>(.*?)</sql>'si", $final, $match); $loop_sql = $match[0];
    foreach ($loop_sql as $value) {
      $final = str_replace($value, "", $final);
    }
      echo $final;
		} else {
			include (PAGES_DIR . $page . '/' . 'index.php');
		}

} //endfunction


/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/

function loop_page($table, $content, $where, $extras, $orderby, $order, $limit){

	global $get_to_replace;
	global $get_result;

	$content = str_replace('.DS.', DS, $content);

	preg_match_all('/{+(.*?)}/', $content, $matches);
	$columns = str_replace(array('{', '}'), array('', ''), implode(',',$matches[0]));


	/*------------------ CLEANING FUNCTIONS ------------------*/
	$columns_functions_clean_exploded = explode(",",$columns);
	$items_functions_clean = array();
	foreach ($columns_functions_clean_exploded as $value_functions_clean) {
		if(strpos($value_functions_clean, "function->") === false){
			$items_functions_clean[] = $value_functions_clean;
		} else {
			$functions_clean_exploded 	= explode("->",$value_functions_clean);
			$items_functions_clean[] 	= $functions_clean_exploded[2];
		}
	}
	$items_functions_clean 		= implode(",", $items_functions_clean);
	$items_functions_clean 		= rtrim($items_functions_clean, ",");
	$items_functions_clean 		= str_replace(",,", ",", $items_functions_clean);
	$columns_functions_clean 	= $items_functions_clean;


	/*--------------------------------------------------------*/

	$conn = db();

  if($orderby != ' '){ $orderby = ' ORDER BY '.$orderby; }
	if($order != ' '){ $order = ' '.$order.' '; }

  if($limit != ' '){


        if(strpos($limit, 'sessionpass') !== false){

          $sessionpass = str_replace("sessionpass", "", $limit);
          $sessionpass_exploded = explode("/",$sessionpass);
          $param1 = $sessionpass_exploded[0];
          $param2 = $sessionpass_exploded[1];

          if(!isset($_COOKIE['session'])){
            setcookie('session', $param1, time() + (21600 * 30), "/"); // 86400 = 1 day
            header('Location:carrinho/item/'.$param2.'/adicionado');
          } else {
            $param1 = $_COOKIE['session'];
          }

          if($param2 == '0'){

          } else {
            cart_add($param1, $param2);
          }

          $limit = ' ';

        } else {

          $limit = ' LIMIT '.$limit;

        }

  }


  if($where != ' '){

    if(strpos($where, 'sessionpass') !== false){
      $session = $_COOKIE['session'];
      $where = " WHERE session = '".$session."' ";
    }
    elseif($where == 'category_search'){

      if(!empty($_GET['search'])){

        if(strpos($_GET['search'], 'category') !== false){
          $search = str_replace("category", "", $_GET['search']);
          $search = " categoria = '".$search."' ";
          $where = " WHERE ".$search;
        } else {
          $where = " WHERE title LIKE '%".$_GET['search']."%' ";
        }

      }
    }
    else {
      $where = ' WHERE '.$where;
    }

  }

	if ($result = $conn->query("SELECT $columns_functions_clean FROM $table $where $extras $orderby $order $limit")) {

	   $columns_exploded = explode(",",$columns);
	   $items = array();

	   foreach ($columns_exploded as $value) {
		    $items[] = "{".$value."}";
		}

		$items2content = '';

	    while ($obj = $result->fetch(PDO::FETCH_OBJ)) {

	    	$items2 = array();

	    	foreach ($columns_exploded as $value) {

	    		if(strpos($value, "function->") === false){
					 $items2[] = $obj->$value;
				}
				else {
					$functions_clean_exploded = explode("->",$value);
          $f1 = $functions_clean_exploded[1];
          $f2 = $functions_clean_exploded[2];
					$functions_cleaning = $f1($obj->$f2);

					$items2[] = $functions_cleaning;
				}

			}

			$items2content .= str_replace($items, $items2, $content);

	    }

	    $get_result[] = $items2content;
	}

	$conn = NULL;
} //endfunction


/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*                                ----------- SMALL FUNCTIONS -----------
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/
/*-----------------------------------------------------------------------------------------------------------*/

function slug($str){
	$slug = array( ' '=>'-', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b' );
	$slug = strtolower(strtr( $str, $slug ));
	return $slug;
} //endfunction

function whatsappencode($str){
	$slug = array( ' '=>'%20', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b' );
	$slug = strtolower(strtr( $str, $slug ));
  $slug = ucwords($slug);
	return $slug;
} //endfunction


function date_formating($str){
	$date_formating = date("d/m/Y", strtotime($str));
	return $date_formating;
} //endfunction

function date_formating_sem_ano($str){
	$date_formating = date("d/m", strtotime($str));
	return $date_formating;
} //endfunction

function remove_underlines($str){
	$remove_underlines = array( '_'=>' ');
	$remove_underlines = strtolower(strtr( $str, $remove_underlines ));
	return $remove_underlines;
} //endfunction

function limit_chars($str){
  $length = 500;
  if(strlen($str)<=$length){
    return $str;
  }
  else{
    $str=substr($str,0,$length) . '...';
    return $str;
  }
} //endfunction

function limit_chars_200($str){
  $length = 200;
  if(strlen($str)<=$length){
    return $str;
  }
  else{
    $str=substr($str,0,$length) . '...';
    return $str;
  }
} //endfunction

function price_format($str){
  $str = number_format($str,2,",",".");
  return $str;
} //endfunction

function numberformat($str){
  $str = number_format($str,0,",",".");
  return $str;
} //endfunction

function activebanner($str){
    global $i_activebanner;
    if($i_activebanner == 1){
        $str = ' active';
    } else {
    	$str = '';
    }
    $i_activebanner++;
    return $str;
} //endfunction

function activebanner2($str){
    global $i_activebanner2;
    if($i_activebanner2 == 1){
        $str = ' active';
    } else {
    	$str = '';
    }
    $i_activebanner2++;
    return $str;
} //endfunction

function uppercase($str){
    $str = strtoupper($str);
    return $str;

} //endfunction

function lowercase($str){
    $str = strtolower($str);
    return $str;

} //endfunction

$i_animationdelay = 2;
function animationdelay($str){
    global $i_animationdelay;
    $str = 'animation-delay:0.'.$i_animationdelay.'s;';
    $i_animationdelay++;
    $i_animationdelay++;
    return $str;

} //endfunction

function keyword($str){
  $conn   = db();
  $pageget = $_GET['page'];
  $result = $conn->query("SELECT * FROM $pageget WHERE id = '$str' ");
  $str    = '';
  while ($obj_nest = $result->fetch(PDO::FETCH_OBJ)) {
    $title  = $obj_nest->title;
    $description  = $obj_nest->description;
    $client = $obj_nest->client;
    $str = ", $title,  ".clientname($client);
  }
  return $str;
} //endfunction

function clientname($str){
  $conn = db();
  $query = $conn->prepare("SELECT client.title FROM portfolio INNER JOIN client ON $str=client.id");
  $query->execute();
  $str = $query->fetchColumn();
  $str = strtoupper($str);

  return strtoupper($str);
} //endfunction

function webpconvert($str){
  $extension = explode(".",$str);
  $extension = $extension[1];
  if($extension != 'webp'){
    $str = substr($str, 0, -4) . '.webp';
  }
  return $str;
} //endfunction

function webporiginal($str){
  $extension = explode(".",$str);
  $extension = $extension[1];
  $str = substr($str, 0, -4) . '.'.$extension;
  return $str;
} //endfunction



function encrypting($action, $string, $key_sk, $key_siv){
  $cypher_method = "AES-256-CBC";
  $output = false;
  if ($action == "encrypt"){
    $key    = $key_sk;
    $iv     = $key_siv;
    $output = openssl_encrypt($string, $cypher_method, $key, 0, $iv);
    $output = base64_encode($output);
  } else if($action == "decrypt"){
    $key    = $key_sk;
    $iv     = $key_siv;
    $output = base64_decode($string);
    $output = openssl_decrypt($output, $cypher_method, $key, 0, $iv);
  }
  return $output;
} //endfunction


function plans_months($str){
  $limit = $str+4;
  $return = '';
  $monthsarray = array('1' => '1', '2' => '3', '3' => '6', '4' => '12');
  $monthsarray_key = 1;
  $plural_mes = '';

  for($i=$str;$i<$limit;$i++){

    if($monthsarray_key == 1){
      $plural_mes = ' mês';
    } else {
      $plural_mes = ' meses';
    }

    $return .= '<option value="'.$i.'">'.$monthsarray[$monthsarray_key].$plural_mes.'</option>';
    $monthsarray_key++;
  }
  return $return;
} //endfunction

function check_months($str){
  if($str > 1){
    $str = $str.' meses';
  } else {
    $str = $str.' mês';
  }
  return $str;
} //endfunction

function accesscount($str){
  $conn = db();
  $dateone = date("Y-m-d H:i:s");
  $date = date_create($dateone);
  $date_access = date_format($date,"Y-m-d H:i:s");
  $query = $conn->prepare("INSERT INTO analytics (date_access, page) VALUES ('$date_access', '$str')");
  $query->execute();
} //endfunction

?>
