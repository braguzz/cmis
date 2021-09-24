<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CategorieLibro[]|\Cake\Collection\CollectionInterface $categorieLibri
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"libro_id"' .';';
    $output .= '"categoria_id"' .';';
 $output.="\n";
 ?>
  <?php foreach ($categorieLibri as $categorieLibro) : ?>
             <?php $output.=$this->Number->format($categorieLibro->id).';';?>
        <?php $categorieLibro->has('libro') ? $output.= '"' .$categorieLibro->libro->id .'";' : $output.=';' ?>
        <?php $categorieLibro->has('categoria') ? $output.= '"' .$categorieLibro->categoria->title .'";' : $output.=';' ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=categorieLibri.csv");
echo $output; 
exit;