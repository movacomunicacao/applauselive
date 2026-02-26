<?php
  $id    = $_GET['id'];
  $action  = $_GET['action'];

  if($action == 'edit'){
    $item = $_GET['item'];
  }
  else{
    $item = '0';
  }

  $conn = db();
  foreach($conn->query("SELECT title FROM cms WHERE id = '".$id."' ") as $row) {
    $title = $row['title'];
  }

  echo '<form action="'.ROOT.ADMIN.'model'.DS.$action.DS.$id.DS.$item.'" method="post" enctype="multipart/form-data">';

  $query = $conn->prepare("DESCRIBE ".$title);
  $query->execute();
  $table_fields = $query->fetchAll(PDO::FETCH_COLUMN);

  foreach($table_fields as $field) {

    $inputs = '';

    if($action == 'edit'){
      foreach($conn->query("SELECT * FROM ".$title." WHERE id = '".$item."' ") as $row_item) {
        $value    = $row_item[$field];
      }
    } else {
      $value  = '';
      if($field == 'data'){  $value = date("Y-m-d");}
    }

    if(in_array($field, $array_fields_hidden, TRUE)){
      $inputs  .= '<input type="hidden" class="form-control" name="'.$field.'" value="'.$value.'" />';
    }

    elseif(in_array($field, $array_fields_text, TRUE)){
      $inputs  .= '<label>'.$field.':</label><input type="text" class="form-control" name="'.$field.'" id="'.$field.'" placeholder="'.$field.'" value="'.$value.'" />';
    }

    elseif(in_array($field, $array_fields_select, TRUE)){

      $inputs  .= '<label>'.$field.':</label><select class="form-control" name="'.$field.'">';

      foreach($conn->query("SELECT * FROM ".$field) as $row) {

        $id_select     = $row['id'];
        $title_select  = $row['title'];

        $query = $conn->prepare("SELECT $field FROM $title WHERE id = :status");
        $query->bindParam(':status', $item);
        $query->execute();
        $id_check = $query->fetchColumn();

        if($id_check == $id_select){ $selected = 'selected="selected"'; } else { $selected = ''; }

        $inputs  .= '<option value="'.$id_select.'" '.$selected.'>'.$title_select.'</option>';
      }

      $inputs  .= '</select>';

    }

    elseif(in_array($field, $array_fields_number, TRUE)){
      $inputs  .= '<label>'.$field.':</label><input type="number" class="form-control" name="'.$field.'" id="'.$field.'" placeholder="'.$field.'" value="'.$value.'" />';
    }

    elseif(in_array($field, $array_fields_price, TRUE)){
      $inputs  .= '<label>'.$field.':</label><input type="number" class="form-control" name="'.$field.'" id="'.$field.'" placeholder="'.$field.'"  step="any" value="'.$value.'" />';
    }

    elseif(in_array($field, $array_fields_img, TRUE)){
      $inputs  .= '<label>'.$field.':</label><input type="file" class="form-control" name="'.$field.'" />';
    }

    elseif(in_array($field, $array_fields_time, TRUE)){
      $inputs  .= '<label>'.$field.':</label><input type="time" class="form-control" name="'.$field.'" />';
    }

    elseif(in_array($field, $array_fields_textarea, TRUE)){
      $inputs  .= '<label>'.$field.':</label><textarea class="form-control" id="editor" name="'.$field.'">'.$value.'</textarea><script> CKEDITOR.replace( "description" );</script><script> CKEDITOR.replace( "address" );</script><script> CKEDITOR.replace( "texto" );</script>';
    }

    elseif($field == "resumo"){
      //$inputs  .= '<input type="hidden" class="form-control" name="'.$field.'" value="'.$value.'" />';
      $inputs  .= '<label>'.$field.':</label><div>'.$value.'</div>';
    }

    elseif(in_array($field, $array_fields_date, TRUE)){

      $inputs  .= '<label>'.$field.':</label><input type="date" class="form-control" name="'.$field.'" value="'.date("Y-m-d", strtotime($value)).'" />';

    }

    elseif($field == "status_pagseguro"){
      $inputs  .= '<label>'.$field.':</label>
      <select name = "status_pagseguro">
        <option value="1">Aguardando Pagto</option>
        <option value="2">Aprovado</option>
        <option value="3">Cancelado</option>
        <option value="4">Concluído</option>
      </select>';
    }

    else {
      $inputs  .= '<label>'.$field.':</label><input type="text" class="form-control" name="'.$field.'"  id="'.$field.'" placeholder="'.$field.'" value="'.$value.'" />';
    }

    echo $inputs;
  }

  if(in_array($title, $array_galleries, TRUE)){

    if($action == 'add'){

      echo '<p><label>Fotos:</label><input type="file" class="form-control" name="filesToUpload[]" id="filesToUpload" multiple></p>';

    } else {

      echo '<p><label>Fotos:</label><input type="file" class="form-control" name="filesToUpload[]" id="filesToUpload" multiple></p>';

      foreach($conn->query("SELECT * FROM ".$title."_gallery WHERE id_".$title." = '".$item."' ") as $row) {
        $img    = $row['img'];
        $id_img    = $row['id'];

				$server = $_SERVER['DOCUMENT_ROOT'];

        echo '
        <div class="row my-auto vertical-align py-3">
          <div class="col-4 my-auto vertical-align">
            <img src="'.IMG_DIR.$title.DS.$img.'" class="col-12">
          </div>
          <div class="col-8 my-auto vertical-align">
            <a href="/'.SITE_NAME.'/admin/model'.DS.'gallery'.DS.$id.DS.$id_img.'" class="my-auto vertical-align">
              <div class="text-danger bt_delete transition my-auto vertical-align">
                <i class="fa fa-times" aria-hidden="true"></i>
              </div>
            </a>
          </div>
        </div>
        ';
      }

    }

  }

  echo '<button type="submit" class="btn btn-primary mb-2 mt-3">Send</button>
  </form>';

  echo '
  <script>$(".bt_add").css("display", "none")</script>
  <script type="text/javascript">$("#preco").maskMoney();</script>
  ';

  echo '
  <script>$("#price").attr("step", "any");</script>
  ';

?>
