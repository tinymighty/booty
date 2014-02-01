        <li class="page-menu dropdown">
          <a href="" data-toggle="dropdown" class="dropdown-toggle">
            <i class="glyphicon glyphicon-file"></i> <span class="title"><?php echo $title ?></span> <b class="caret"></b>
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

foreach($sections as $i => $items):
  if(!empty($items)):
    foreach($items as $key => $item):
      if(isset($item['redundant'])){ 
        continue;
      }
?>
  <?php /*<li><a href="<?php echo $item['href'] ?>" class="<?php echo str_replace('selected', 'active', $item['class']);?>" id="contentaction-<?php echo $key?>">
    <i class="glyphicon glyphicon-<?php echo $this->key_to_icon[$key]?>"></i> <?php 
    if(isset($item['text'])){
      echo $item['text'];
    }else{
      $this->msg($key);
    }
    ?>
  </a></li>*/
      $options = array();
      if( isset($this->key_to_icon[$key]) ){
        $options += array('icon-class' => 'glyphicon glyphicon-'.$this->key_to_icon[$key]);
      }
      echo $this->makeListItem($key, $item, $options );  
    endforeach; ?>
    <?php if($i < count($sections)-2): ?>
<li class="divider"></li>
<?php endif; ?>
<?php 
  endif;
endforeach;?>

          </ul>
        </li>