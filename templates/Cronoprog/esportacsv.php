<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cronoprogramma[]|\Cake\Collection\CollectionInterface $cronoprog
 */
?>
<?php
$output='';
    $output .= '"VERSIONE"' .';';
    $output .= '"IDINT"' .';';
    $output .= '"CODATTIV"' .';';
    $output .= '"DESATTIV"' .';';
    $output .= '"PESOATTIV"' .';';
    $output .= '"FSP"' .';';
    $output .= '"FSI"' .';';
    $output .= '"FSL"' .';';
    $output .= '"RESTATTIV"' .';';
    $output .= '"DATAINIPREV"' .';';
    $output .= '"DATAFINEPREV"' .';';
    $output .= '"DATAINIEFF"' .';';
    $output .= '"DATAFINEFF"' .';';
    $output .= '"STATOATTUAZ"' .';';
    $output .= '"PERCATTUAZ"' .';';
 $output.="\n";
 ?>
  <?php foreach ($cronoprog as $cronoprogramma) : ?>
             <?php $output.='"' . h($cronoprogramma->VERSIONE).'";'; ?>
            <?php $output.=$this->Number->format($cronoprogramma->IDINT).';';?>
            <?php $output.='"' . h($cronoprogramma->CODATTIV).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->DESATTIV).'";'; ?>
            <?php $output.=$this->Number->format($cronoprogramma->PESOATTIV).';';?>
            <?php $output.=$this->Number->format($cronoprogramma->FSP).';';?>
            <?php $output.=$this->Number->format($cronoprogramma->FSI).';';?>
            <?php $output.=$this->Number->format($cronoprogramma->FSL).';';?>
            <?php $output.='"' . h($cronoprogramma->RESTATTIV).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->DATAINIPREV).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->DATAFINEPREV).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->DATAINIEFF).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->DATAFINEFF).'";'; ?>
            <?php $output.='"' . h($cronoprogramma->STATOATTUAZ).'";'; ?>
            <?php $output.=$this->Number->format($cronoprogramma->PERCATTUAZ).';';?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=cronoprog.csv");
echo $output; 
exit;