<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Prova[]|\Cake\Collection\CollectionInterface $prove
 */
?>
<?php
$output='';
    $output .= '"CODPROG"' .';';
    $output .= '"VERSIONE"' .';';
    $output .= '"DATANUCLEO"' .';';
    $output .= '"FLAGB"' .';';
    $output .= '"COD_TIPOCRITICITA_NV"' .';';
    $output .= '"COD_TIPOSOLUZIONE_NV"' .';';
    $output .= '"DATACOMASS"' .';';
    $output .= '"SOL_GR_A"' .';';
    $output .= '"DATA_SOL_GR"' .';';
    $output .= '"CRITICITA_NDV"' .';';
 $output.="\n";
 ?>
  <?php foreach ($prove as $prova) : ?>
             <?php $output.=$this->Number->format($prova->CODPROG).';';?>
            <?php $output.='"' . h($prova->VERSIONE).'";'; ?>
            <?php $output.='"' . h($prova->DATANUCLEO).'";'; ?>
            <?php $output.='"' . h($prova->FLAGB).'";'; ?>
            <?php $output.='"' . h($prova->COD_TIPOCRITICITA_NV).'";'; ?>
            <?php $output.='"' . h($prova->COD_TIPOSOLUZIONE_NV).'";'; ?>
            <?php $output.='"' . h($prova->DATACOMASS).'";'; ?>
            <?php $output.='"' . h($prova->SOL_GR_A).'";'; ?>
            <?php $output.='"' . h($prova->DATA_SOL_GR).'";'; ?>
            <?php $output.='"' . h($prova->CRITICITA_NDV).'";'; ?>
<?php 
 $output.="\n";
endforeach; 
header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=prove.csv");
echo $output; 
exit;