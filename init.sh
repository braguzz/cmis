read -p "Questa operazione inizializza gli utenti, i gruppi ed altri parametri dell applicazione. Sei sicuro? (y/n)" -r REPLY

echo    # (optional) move to a new line
#if [[ $REPLY =~ ^[Nn]$ ]] 
 if [[ -z "$REPLY" ]]
then

echo "Non hai inserito nessun parametro. Esecuzione interrotta"
fi

if [[ $REPLY =~ ^[Yy]$ ]] 
then

        # Step1
        # lancia lo script src/Console/installer
        # per cambiare i security salt
        # e inizializzare le cartelle in lettura/scrittura
        # 

        composer run-script post-install-cmd         



        # Step2
        # crea tabelle ROLES e USERS
        # la tabella groups avra 6 gruppi creati
        # ( administrators,managers,executives,accountants,guests,inactive)
        # e deve esserci per lo startup l'utente admin di profilo administrator (password adminadmin)
        # 
  
         bin/cake migrations migrate




        #
        # Step3-crea tabelle per ReportSql
        #

        # ./Console/cake schema create Reportsql -y




      
        
echo "---------- Tutto ok ----------"
echo "Tabelle inizializzate"
echo "Creato utente admin con password adminadmin"
echo "Entra e cambiala subito!!"

fi