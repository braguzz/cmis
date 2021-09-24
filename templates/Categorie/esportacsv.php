<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Categoria[]|\Cake\Collection\CollectionInterface $categorie
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"title"' .';';
 $output.="\n";
 ?>
  <?php foreach ($categorie as $categoria) : ?>
             <?php $output.=$this->Number->format($categoria->id).';';?>
            <?php $output.='"' . h($categoria->title).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=categorie.csv");
echo $output; 
exit;