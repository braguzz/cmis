<?php 
    //elimina il messaggio flash "parassita"
   // CakeSession::delete('Message');

?>
<?php $this->extend('/layout/TwitterBootstrap/signin2'); ?>


<h1>Utente registrato ma non attivo</h1>

<p>L'utente e' stato registrato, ma non e' ancora attivo e, al momento, <b><u>non puo' essere ancora usato per accedere</u></b> all'applicazione.</p>
<p>Si prega di attendere che l'amministratore autorizzi l'utente ad accedere all'applicazione.</p>
<br>
<p>Si ricorda che <b><u>la password e' strettamente personale</u></b> e non va comunicata o ceduta ad altri per nessun motivo, 
neppure a colleghi dello stesso ufficio. 
</p>
<br>
    
<h3>Prendere nota delle credenziali di accesso</h3>
<pre>
<table border="0"> 
    <tbody>
        <tr>
            <td>Applicazione</td>
            <td><?php echo env('REGTOSC_PAGETITLE', false); ?></td>
        </tr>
        <tr>
            <td>Utente</td>
            <td><?php echo $info_utente['username']; ?></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><?php echo $password; ?></td>
        </tr>
        <tr>
            <td>Email</td>
            <td><?php echo strtoupper($info_utente['email']); ?></td>
        </tr>
        <tr>
            <td>Codice fiscale</td>
            <td><?php echo strtoupper($info_utente['codice_fiscale']); ?></td>
        </tr>
    </tbody>
</table>
</pre>




