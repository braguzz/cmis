<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Intervento[]|\Cake\Collection\CollectionInterface $interventi
 */
?>
<?php
$output='';
    $output .= '"id"' .';';
    $output .= '"VERSIONE"' .';';
    $output .= '"IDINT"' .';';
    $output .= '"DESLDITEMP"' .';';
    $output .= '"TITOLOINT"' .';';
    $output .= '"DESCRINT"' .';';
    $output .= '"ANNODEFR"' .';';
    $output .= '"FLAGPQPO"' .';';
    $output .= '"CODCMU"' .';';
    $output .= '"MATRESPOP"' .';';
    $output .= '"NOTEANAG"' .';';
    $output .= '"NOTECRONOPROG"' .';';
    $output .= '"INTMONITORATO"' .';';
    $output .= '"MONITSTATO"' .';';
    $output .= '"ANNOINIZIOINT"' .';';
    $output .= '"STATOINT"' .';';
    $output .= '"MATRCSG"' .';';
    $output .= '"CODLOCPROG"' .';';
    $output .= '"INSVERS"' .';';
 $output.="\n";
 ?>
  <?php foreach ($interventi as $intervento) : ?>
             <?php $output.=$this->Number->format($intervento->id).';';?>
            <?php $output.='"' . h($intervento->VERSIONE).'";'; ?>
            <?php $output.=$this->Number->format($intervento->IDINT).';';?>
            <?php $output.='"' . h($intervento->DESLDITEMP).'";'; ?>
            <?php $output.='"' . h($intervento->TITOLOINT).'";'; ?>
            <?php $output.='"' . h($intervento->DESCRINT).'";'; ?>
            <?php $output.='"' . h($intervento->ANNODEFR).'";'; ?>
            <?php $output.=$this->Number->format($intervento->FLAGPQPO).';';?>
            <?php $output.='"' . h($intervento->CODCMU).'";'; ?>
            <?php $output.='"' . h($intervento->MATRESPOP).'";'; ?>
            <?php $output.='"' . h($intervento->NOTEANAG).'";'; ?>
            <?php $output.='"' . h($intervento->NOTECRONOPROG).'";'; ?>
            <?php $output.=$this->Number->format($intervento->INTMONITORATO).';';?>
            <?php $output.='"' . h($intervento->MONITSTATO).'";'; ?>
            <?php $output.='"' . h($intervento->ANNOINIZIOINT).'";'; ?>
            <?php $output.='"' . h($intervento->STATOINT).'";'; ?>
            <?php $output.='"' . h($intervento->MATRCSG).'";'; ?>
            <?php $output.='"' . h($intervento->CODLOCPROG).'";'; ?>
            <?php $output.='"' . h($intervento->INSVERS).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=interventi.csv");
echo $output; 
exit;