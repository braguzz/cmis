<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Genere[]|\Cake\Collection\CollectionInterface $generi
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"title"' .';';
 $output.="\n";
 ?>
  <?php foreach ($generi as $genere) : ?>
             <?php $output.=$this->Number->format($genere->id).';';?>
            <?php $output.='"' . h($genere->title).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=generi.csv");
echo $output; 
exit;