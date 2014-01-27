        <li class="dropdown">
          <a href="" data-toggle="dropdown" class="dropdown-toggle">
            <i class="glyphicon glyphicon-cog"></i> <span class="title"><?php $this->msg( 'actions' ) ?></span> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu">
<?php 
$sections = array();
if( isset($views) )
  $sections[] = $views;
if( isset($namespaces) )
  $sections[] = $namespaces;
if( isset($actions) )
  $sections[] = $actions;
if( isset($variants) )
  $sections[] = $variants;
if( isset($tools) )
  $sections[] = $tools;
//print_r($tools); exit;
foreach($sections as $items):
  if(!empty($items)):
    foreach($items as $key => $itm):
      if(isset($itm['redundant'])){ 
        continue;
      }
?>
  <li><a href="<?php echo $itm['href'] ?>" class="<?php echo str_replace('selected', 'active', $itm['class']);?>" id="contentaction-<?php echo $key?>">
    <i class="glyphicon glyphicon-<?php echo $this->key_to_icon[$key]?>"></i> <?php 
    if(isset($itm['text'])){
      echo $itm['text'];
    }else{
      $this->msg($key);
    }
    ?>
  </a></li>
<?php 
    endforeach; ?>
<li class="divider"></li>
<?php 
  endif;
endforeach;?>

          </ul>
        </li>