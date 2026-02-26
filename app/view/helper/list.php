<?php
  /*
  foreach($conn->query("SELECT title FROM ".$cms." WHERE id ='".$id_item."' ") as $row) {
    $title_table = $row['title'];
  }
  */

  //echo $user; die();

  $actual_link = "http://$_SERVER[HTTP_HOST]";


  foreach($conn->query("SELECT * FROM messages WHERE id = '".$id_item."' ORDER BY submit_date ASC") as $row) {

    $id       = $row['id'];

    if(isset($row['title'])){
      $title = $row['title'];
    }
    elseif(isset($row['nome'])){
      $title = $row['nome'];
    }
    elseif(isset($row['id_pedidos'])){
      $title = $row['id']." | ". $row['cliente'];
    }

    if(isset($row['img'])){
      $img = $row['img'];
      $col1 = '<div class="col-1 my-auto"><img src="'.IMG_DIR.$title_table.'/'.$img.'" class="col-12" /></div>';
      $col2 = 'col-9';
    } else{
      $col1 = '';
      $col2 = 'col-10';
    }

    echo '
    <div class="row justify-content-between text-start px-5 py-4 mt-3 list-item vertical-align">
      '.$col1.'
      <div class="'.$col2.' my-auto">
        '.$title.'
      </div>
      <div class="col-2 text-end my-auto">
        <a href="'.ROOT.ADMIN.'edit'.DS.$id_item.DS.$id.'"><i class="fas fa-pen bt_edit text-warning transition"></i></a>
        <a href="'.DS.ADMIN.'model'.DS.'delete'.DS.$id_item.DS.$id.'"><i class="fa fa-times bt_delete text-danger transition" aria-hidden="true"></i></a>
      </div>
    </div>
    ';
  }


?>
