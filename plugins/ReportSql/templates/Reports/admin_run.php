<?php $this->extend('/layout/TwitterBootstrap/dashboard');
?>
<div class="card">
    <div class="card-header">
        <!-- ========= PB: TITOLO CON RELATIVI BOTTONI ====================== -->
<div class="titolo_pulsanti">
<div class="row align-items-center mb-2">  
<div class="col col-sm-auto">
<h3 class="card-title"> Report <?= $report->name ?></3>
 </div>  
 <div class="col-10 col-sm-auto">
     <div class="btn-group">
 <?= $this->Html->link('', ['action' => 'add', ], ['title' => __('Add'), 'class' => 'btn btn-outline-info bi-plus-lg mr-1']) ?>
 <?= $this->Html->link('', ['action' => 'index', ], ['title' => __('List'), 'class' => 'btn btn-outline-info bi-list mr-1']) ?>

         <div class="btn-group" role="group">
    <button id="btnGroupDrop1" type="button" class="btn btn-outline-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Esporta
    </button>
    <div class="dropdown-menu " aria-labelledby="btnGroupDrop1">
         <?= $this->Html->link('Esporta in csv', ['action' => 'esportacsv', ], ['title' => __('Esporta in csv'), 'class' => 'dropdown-item']) ?>
         <?= $this->Html->link('Esporta in pdf', ['action' => 'esportapdf', ], ['title' => __('Esporta in pdf'), 'class' => 'dropdown-item']) ?>
    </div>
  </div>
 </div>
 </div>
 </div>
</div>
<!-- PB: Fine titolo con bottoni -->
        
        
        
        
        
        
        
          
          <p class="card-text"><?= htmlspecialchars($strsql) ?></p>
   </div>
   <?php if (!empty($parametri[0])) { ?>
    <div class="card-body">
    
    <?= $this->Form->create(NULL, ['type' => 'get']) ?>
        <div class="row">
            <div class="col-1">
               <h6 class="card-title"><?= 'Parametri' ?></h6>
               <?= $this->Form->button('Run', [
                    'class' => 'btn btn-outline-info  mr-1',
                    'div' => false]); ?>
            </div>
            <div class="col-11">
                <?php
                    foreach ($parametri[1] as $str)
                {
               echo '<div class="form-group">';
                $i="";
                if (isset($_GET["$str"])) $i=htmlspecialchars($_GET["$str"]);
                echo $this->Form->control($str,['value' => $i]);
                echo '</div>';
                    }
                ?>
              
                 <?= $this->Form->end() ?>
            </div>         
        </div>
    </div>
      
 <?php  } 
      if ($results)
                  {  
          ?>

     <div class="card-body">
 <div class="table-responsive">
            <table class="table table-striped table-sm" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <?php $fields = array_keys($results[0]);
                foreach ($fields as $field)
				{  ?>
                            <th><?= $field ?></th>
                        <?php   }  ?>
            </tr>
            </thead>
            <tbody>
                <?php foreach ($results as $result) { ?>
                <tr>
                    <?php	foreach ($result as $field => $value) { ?>
                    <td><?php echo $value; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        </div>
         <?php $pagination->render(); 
         }
         ?>
        </div>

