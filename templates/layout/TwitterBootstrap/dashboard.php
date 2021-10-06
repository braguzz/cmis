<?php
/**
 * @var \Cake\View\View $this
 */
use Cake\Core\Configure;

//$this->Html->css('BootstrapUI.dashboard', ['block' => true]);
 $this->prepend('css', $this->Html->css([

     'bootstrap-icons-1.5.0/bootstrap-icons',
     'select2@4.1.0.min',
     'select2-bootstrap4-theme.min',
    'jquery-ui.min',
     'rt.css',
     'bootstrap-4-navbar.min',
     $regtoscConf['ColourTheme']
     ],
    array(
        'inline' => false
    ))
);
$this->prepend('script', $this->Html->script([
    'jquery.mmenu.min',
    'Moment',
    'bootstrap-datetimepicker.min',
    'jquery-ui.min',
    'dhtmlxcalendar',
    'myJquery',

    'select2@4.1.0.min',
    'select2@4.1.0.it'
    
    ]));

$this->prepend('tb_body_attrs', ' class="' . implode(' ', [$this->request->getParam('controller'), $this->request->getParam('action')]) . ' d-flex flex-column min-vh-100 " ');
$this->start('tb_body_start');
?>
<body <?= $this->fetch('tb_body_attrs') ?>>
 
    <?= $this->element('navbar') ?>
  

    <div class="container-fluid">
           
        
        <div class="row">
    
            <main role="main" class="col-md-12 ml-sm-auto col-lg-12 pt-3 px-4">

                
<?php
/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash)) {
        echo $this->Flash->render();
    }
    $this->end();
}
$this->end();
$this->start('tb_body_end');
echo '</body>';
$this->end();

$this->start('tb_footer');
        echo'<!-- Footer -->    
        <footer class=" mt-auto text-center text-lg-start bg-light text-muted">
         <div class="border-top text-center p-2" style="background-color: rgba(0, 0, 0, 0.05);">'
            .'<small>'
            .'Regione Toscana - '
            .Configure::read('regtoscConf.pagetitle')
            .'</small>'
            .'       
         </div>
       </footer>
       <!-- Footer -->'; 
 $this->end();



$this->append('content', '</main></div></div>');
echo $this->fetch('content');
