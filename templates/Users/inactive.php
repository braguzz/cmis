<?php 
    //elimina il messaggio flash "parassita"
   // CakeSession::delete('Message');

?>
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
     <div class="row mb-4">
        <div class="col text-center">  
            <h3>
               <?php echo $regtoscConf['pagetitle']; ?>
            </h3>
        </div>
    </div>

       <div class=" text-center alert alert-warning">
<h4>Utente registrato ma non attivo</h4>

<p>L'utente e' stato registrato, ma non e' ancora attivo e, al momento, <b><u>non puo' essere ancora usato per accedere</u></b> all'applicazione.</p>
<p>Si prega di attendere che l'amministratore autorizzi l'utente ad accedere all'applicazione.</p>
</div>

    </div>