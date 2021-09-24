<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface[]|\Cake\Collection\CollectionInterface $reports
 */
?>
<?php
$output='';
  if ($results)
      {  
     $fields = array_keys($results[0]);
                foreach ($fields as $field)
				{ 
                            $output .= '"' . $field .'"' .';';                 
                            } 
      
      $output.="\n";
       foreach ($results as $result) :
           foreach ($result as $field => $value) :
           $output.='"' . $value.'";'; 
           endforeach;
            $output.="\n";
      endforeach; 
  } 

header("Content-type: text/csv"); 
header("Content-Disposition: attachment; filename=reports.csv");
echo $output; 
exit;