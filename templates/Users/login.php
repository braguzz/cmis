<?php $this->extend('/layout/TwitterBootstrap/signin'); ?>

<div class="container">
    <div class="row">
        <div class="col text-center">  
            <?= $this->Flash->render() ?>
            <div class="mb-3">
                <?= $this->Html->image('logo_regione_toscana.jpg'); ?>
              
            </div>
        </div>
    </div>
     <div class="row">
        <div class="col text-center">  
            <h5>
               <?php echo $regtoscConf['pagetitle']; ?>
            </h5>
        </div>
    </div>
    
    
    
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div>

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="nav-smartcard-tab" data-toggle="tab" href="#nav-smartcard" role="tab" aria-controls="nav-smartcard" aria-selected="true">SmartCard & Arpa</a>
                        <a class="nav-link" id="nav-username-tab" data-toggle="tab" href="#nav-username" role="tab" aria-controls="nav-username" aria-selected="false">Username & Password</a>
                        <a class="nav-link d-none" id="nav-spid-tab" data-toggle="tab" href="#nav-spid" role="tab" aria-controls="nav-spid" aria-selected="false">Spid</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-smartcard" role="tabpanel" aria-labelledby="nav-smartcard-tab">
                        <div class="users form">

                            <?= $this->Form->create() ?>
                            <fieldset>
                                <legend><?= __('Login via smartcard o credenziali SPID') ?></legend>
                                
                            </fieldset>
                            <?= $this->Form->submit(__('Login')); ?>
                            <?= $this->Form->end() ?>
                            <!-- <?= $this->Html->link("Registrati", ['action' => 'register', 'smartcard']) ?> -->       
                            <?= $this->Form->create(null, ['url' => ['action' => 'register']]) ?>
                            <?= $this->Form->button(__('Register'),['class'=>'btn btn-link btn-sm']); ?>
                            <?= $this->Form->end() ?>
                        </div>   
                    </div>
                    <div class="tab-pane fade" id="nav-username" role="tabpanel" aria-labelledby="nav-username-tab">
                        <div class="users form">

                            <?= $this->Form->create() ?>
                            <fieldset>
                                <legend><?= __('Inserisci il tuo username e password') ?></legend>
                                <?= $this->Form->control('username', ['required' => true]) ?>
                                <?= $this->Form->control('password', ['required' => true]) ?>
                            </fieldset>
                            <?= $this->Form->submit(__('Login')); ?>
                            <?= $this->Form->end() ?>

                            <?= $this->Html->link("Registrati", ['action' => 'register', 'userpass']) ?>
                        </div>   
                    </div>
                    <div class="tab-pane fade " id="nav-spid" role="tabpanel" aria-labelledby="nav-spid-tab">
                        <fieldset>
                            <legend><?= __('Funzione disabilitata') ?></legend>
                        </fieldset>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>




