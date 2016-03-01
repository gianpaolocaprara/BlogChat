-record(utenti,{id,
				nome,
				cognome,
				nascita,
				nome_utente,
				email,
				pass}).

-record(post,{id_post,
				id_utente,
				nome_post,
				contenuto_post,
				data}).
				
-record(commenti,{id_commento,
					id_post,
					id_utente,
					commento,
					data_commento}).
				
-record(chat,{id_messaggio_chat,
				id_utente,
				messaggio,
				data_commento}).
				
-record(avatar,{id_utente,
				nome_immagine}).

-record(appoggio,{label,
					numero}).				