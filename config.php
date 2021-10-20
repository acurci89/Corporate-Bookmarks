<?php
		
	$linkfile = "C:/inetpub/var/wwwrootCorporateBookmarks/Data/corporatebookmarks.json"; //L'application pool di IIS deve poter modificare il file
	$personalpath = "C:/inetpub/wwwrootCorporateBookmarks/personal/"; //L'application pool di IIS deve poter modificare la cartella
	$GroupPath = "C:/inetpub/wwwrootCorporateBookmarks/Group/"; //L'application pool di IIS deve poter modificare la cartella

	$IconImagePath = "img/icon/";

	$GoogleSearch = true;
	
	$CompanyName = "F.T.P. S.r.l.";

	$UseUserAD = false;
	$Admin = array (); //$Admin = array() //= All user admin //$Admin = ("dominio\utente1","dominio\utente2")

	// 0. Creare un gruppo di AD per gli utenti che devono accedere al sito, dare alla cartella del sito i permessi di Read al gruppo creato
	// 1. Creare un Sito nuovo in IIS con autenticazione integrata
	// 2. Dare alla cartella del sito i permessi di Real Only all'utente IISAPP POOL\[Utente IIS]
	// 3. Aggiungere il permessi di Modify alla cartella \img\icon
	// 4. Dare i permessi di Modify al file corporatebookmarks.json
	// 5. Dare i permessi di Modify alla cartella $personalpath (Possibilmente una cartella dedicata)
	// 6. Aggiungere gli utenti a $Admin se necessario, altrimenti lasciarlo $Admin = array() per fare in modo che tutti gli uenti con accesso ail sito possano Editare i link 
	//
	//
	//
	//
	//
?>