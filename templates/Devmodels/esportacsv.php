<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Devmodel[]|\Cake\Collection\CollectionInterface $devmodels
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"title"' .';';
    $output .= '"brand"' .';';
    $output .= '"tipo"' .';';
    $output .= '"costo"' .';';
 $output.="\n";
 ?>
  <?php foreach ($devmodels as $devmodel) : ?>
             <?php $output.=$this->Number->format($devmodel->id).';';?>
            <?php $output.='"' . h($devmodel->title).'";'; ?>
            <?php $output.='"' . h($devmodel->brand).'";'; ?>
            <?php $output.='"' . h($devmodel->tipo).'";'; ?>
            <?php $output.=$this->Number->format($devmodel->costo).';';?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=devmodels.csv");
echo $output; 
exit;