<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lingua[]|\Cake\Collection\CollectionInterface $lingue
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"title"' .';';
 $output.="\n";
 ?>
  <?php foreach ($lingue as $lingua) : ?>
             <?php $output.=$this->Number->format($lingua->id).';';?>
            <?php $output.='"' . h($lingua->title).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=lingue.csv");
echo $output; 
exit;