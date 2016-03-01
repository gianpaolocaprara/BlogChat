-module(funzioni).
-compile(export_all).
%include la libreria per poter effettuare le query
-include_lib("stdlib/include/qlc.hrl").
%include il file blogchat_DB.hrl
-include("blogchat_DB.hrl").
%include il file sessione.hrl
-include("sessione.hrl").
%include il file yaws_api.hrl
-include("C:/Program Files (x86)/Yaws-1.98/include/yaws_api.hrl").

%funzioni.erl:file contenente le funzioni utilizzate all'interno di BlogChat


%funzione che esegue una query	
do(Q) ->
    F = fun() -> qlc:e(Q) end,
    {atomic, Val} = mnesia:transaction(F),
    Val.
	
%funzione che controlla se un utente è già stato inserito all'interno del DB
controlla_utente(Nome_utente) ->
	 do(qlc:q([X#utenti.nome_utente || X <- mnesia:table(utenti),
			     X#utenti.nome_utente =:= Nome_utente
				])).
				
%funziona che registra un nuovo utente all'interno del DB
registra_utente(Nome,Cognome,Nascita,Nome_utente,Email,Pass) -> 
	mnesia:dirty_update_counter(appoggio,numUtenti,+1),
	ListaId=leggi_id(numUtenti),
	[Id | Lista ] = ListaId,
	Row = #utenti{id=Id, nome=Nome, cognome=Cognome, nascita=Nascita, nome_utente=Nome_utente, email=Email, pass=Pass},
    F = fun() ->
		mnesia:write(Row)
	end,
    mnesia:transaction(F).


%legge l'id corrente dalla tabella appoggio del label Target per salvare utenti, post o commenti
leggi_id(Target)->
	do(qlc:q([X#appoggio.numero || X <- mnesia:table(appoggio),
			     X#appoggio.label =:= Target
				])).

%recupera la password dell'utente che sta effettuando il login
recupera_password(Nome_Utente) ->
	do(qlc:q([X#utenti.pass || X <- mnesia:table(utenti),
			     X#utenti.nome_utente =:= Nome_Utente
				])).

%recupera le informazioni dell'utente per visualizzarle nella "bacheca"
recuperaInformazioni(Nome_Utente) ->
	do(qlc:q([{X#utenti.nome, X#utenti.cognome, X#utenti.nascita, X#utenti.email} || X <- mnesia:table(utenti),
			     X#utenti.nome_utente =:= Nome_Utente
				])).
				
%funzione che restituisce una lista vuota nel caso in cui l'avatar non è associato ancora all'utente, altrimenti restituisce una lista con il nome dell'immagine caricata
caricamentoAvatar(Nome_utente) ->
	 do(qlc:q([X#avatar.nome_immagine || X <- mnesia:table(avatar),
				Y <- mnesia:table(utenti),
				X#avatar.id_utente =:= Y#utenti.id,
			    Y#utenti.nome_utente =:= Nome_utente
				])).
				
%funzione che controlla se il tipo di un file caricato è corretto oppure no
controllaTipo(TipoControllo) ->
	if
		TipoControllo =:= "image/jpeg"; TipoControllo =:= "image/gif" ; TipoControllo =:= "image/png" -> true;
		true -> false
	end.

%funzione che registra all'interno del DB il nome dell'immagine personale dell'utente
registraAvatar(NomeUtente,NomeFile,TemporaryFile) ->
	Val = do(qlc:q([{X#utenti.id} || X <- mnesia:table(utenti),
				X#utenti.nome_utente =:= NomeUtente])),
	[{IdUtente}] = Val,
	Row = #avatar{id_utente=IdUtente, nome_immagine=NomeFile},
	Avatar = caricamentoAvatar(NomeUtente),
			if
				length(Avatar) == 0 -> F = fun() ->
												mnesia:write(Row)
												end,
											    mnesia:transaction(F),
											    ImmagineNuova = string:concat("avatar/",NomeFile),
												file:copy(TemporaryFile,ImmagineNuova);
				length(Avatar) > 0 ->  Val2 = do(qlc:q([{X#avatar.nome_immagine} || X <- mnesia:table(avatar),
											X#avatar.id_utente =:= IdUtente])),
											[ImmagineDaCanc] = Val2,
											ImmagineVecchia = string:concat("avatar/",ImmagineDaCanc),
										   	file:delete(ImmagineVecchia),
									G = fun() ->
												mnesia:delete({avatar,IdUtente})
												end,
										   	 	mnesia:transaction(G),
									H = fun() ->
												mnesia:write(Row)
												end,
												mnesia:transaction(H),
												ImmagineNuova2 = string:concat("avatar/",NomeFile),
												file:copy(TemporaryFile,ImmagineNuova2)
			end.
%funzione registra_post (NomeUtente,Titolo,Contenuto): registra il post il cui titolo e il contenuto sono passati come argomenti, aggiungendo la data corrente e l'identificatore del post
registra_post(NomeUtente,Titolo,Contenuto) ->
			mnesia:dirty_update_counter(appoggio,numPost,+1),
			ListaId=leggi_id(numPost),
			[Id | Lista ] = ListaId,
			Val = do(qlc:q([{X#utenti.id} || X <- mnesia:table(utenti),
				X#utenti.nome_utente =:= NomeUtente])),
			[{IdUtente}] = Val,
			DataPost = erlang:localtime(),
			Row = #post{id_post=Id, id_utente=IdUtente, nome_post=Titolo, contenuto_post=Contenuto, data=DataPost},
   			F = fun() ->
						mnesia:write(Row)
						end,
   			mnesia:transaction(F).

%funzione che legge i post di un singolo utente nella home page
leggi_post_utente(NomeUtente)->
		QH = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
						Y <- mnesia:table(utenti),
						X#post.id_utente =:= Y#utenti.id,
						Y#utenti.nome_utente =:= NomeUtente])),
		QL =qlc:sort(QH,{order,descending}),
		QC = qlc:cursor(QL),
		Post = qlc:next_answers(QC,5),
		qlc:delete_cursor(QC),
		Post.

%funzione che legge i post meno recenti di un singolo utente (per la sezione archivio)
leggi_postVecchi_utente(NomeUtente,NumeroPagina) ->
		if
			NumeroPagina == 1 ->
						QH = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
										Y <- mnesia:table(utenti),
										X#post.id_utente =:= Y#utenti.id,
										Y#utenti.nome_utente =:= NomeUtente])),
						QL =qlc:sort(QH,{order,descending}),
						QC = qlc:cursor(QL),
						PostNuovi = qlc:next_answers(QC,5),
						Post = qlc:next_answers(QC,5),
						qlc:delete_cursor(QC),
						Post;
				true -> 
						QH = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
										Y <- mnesia:table(utenti),
										X#post.id_utente =:= Y#utenti.id,
										Y#utenti.nome_utente =:= NomeUtente])),
						QL =qlc:sort(QH,{order,descending}),
						QC = qlc:cursor(QL),
						PostNuovi = qlc:next_answers(QC,5),
						Numero = (NumeroPagina-1)*5,
						PostNonConsiderati = qlc:next_answers(QC,Numero),
						Post = qlc:next_answers(QC,5),
						qlc:delete_cursor(QC),
						Post
		end.



%funzione che legge i post di tutti gli utenti (per la sezione notizie)
leggi_post_utenti(NumeroPagina) ->
		if
			NumeroPagina == 1 ->QH = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
						Y <- mnesia:table(utenti),
						X#post.id_utente =:= Y#utenti.id])),
						QL =qlc:sort(QH,{order,descending}),
						QC = qlc:cursor(QL),
						Post = qlc:next_answers(QC,20),
						qlc:delete_cursor(QC),
						Post;
			true -> QH = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
						Y <- mnesia:table(utenti),
						X#post.id_utente =:= Y#utenti.id])),
						QL =qlc:sort(QH,{order,descending}),
						QC = qlc:cursor(QL),
						Numero = (NumeroPagina-1)*20,
						PostNonConsiderati = qlc:next_answers(QC,Numero),
						Post = qlc:next_answers(QC,20),
						qlc:delete_cursor(QC),
						Post
		end.
		
		
%funzione che legge un singolo post
leggi_post(NumeroPost) ->
	do(qlc:q([{X#post.nome_post, X#post.contenuto_post, X#post.data, Y#utenti.nome, Y#utenti.cognome} || X <- mnesia:table(post),
					Y <- mnesia:table(utenti),
					X#post.id_utente =:= Y#utenti.id,
				    X#post.id_post =:= NumeroPost
					])).

%funzione che legge i commenti di un post
leggi_commenti(NumeroPost) ->
	QH = do(qlc:q([{X#commenti.id_commento, X#commenti.commento, X#commenti.data_commento, Y#utenti.nome, Y#utenti.cognome} || X <- mnesia:table(commenti),
						Y <- mnesia:table(utenti),
						X#commenti.id_utente =:= Y#utenti.id,
					    X#commenti.id_post =:= NumeroPost
						])),
	QL = qlc:sort(QH,{order,descending}),
	QC = qlc:cursor(QL),
	Commenti = qlc:next_answers(QC,all_remaining),
	qlc:delete_cursor(QC),
	Commenti.

%funzione che registra un commento all'interno del DB
inserisci_commento(NomeUtente,Commento,Post) ->
			mnesia:dirty_update_counter(appoggio,numCommenti,+1),
			ListaId=leggi_id(numCommenti),
			[Id | Lista ] = ListaId,
			Val = do(qlc:q([{X#utenti.id} || X <- mnesia:table(utenti),
				X#utenti.nome_utente =:= NomeUtente])),
			[{IdUtente}] = Val,
			DataCommento = erlang:localtime(),
			Row = #commenti{id_commento=Id, id_post=Post, id_utente=IdUtente, commento=Commento, data_commento=DataCommento},
   			F = fun() ->
						mnesia:write(Row)
						end,
   			mnesia:transaction(F).

%funzione che restituisce il numero di post totali inseriti all'interno dell'applicazione (per la sezione notizie)
numero_post_totali() ->
		Post = do(qlc:q([X || X <- mnesia:table(post)])),
		Num_Post = length(Post),
		Num_Post.

%funzione che restituisce il numero di post totali inseriti all'interno dell'applicazione (per la sezione notizie)
numero_post_totaliUtente(NomeUtente) ->
		Post = do(qlc:q([{X#post.id_post,X#post.data,X#post.nome_post,X#post.contenuto_post,Y#utenti.nome,Y#utenti.cognome} || X <- mnesia:table(post),
						Y <- mnesia:table(utenti),
						X#post.id_utente =:= Y#utenti.id,
						Y#utenti.nome_utente =:= NomeUtente])),		
		Num_Post = length(Post),
		Num_Post.

%funzione che legge il numero di commenti di un certo post (serve per homePage_utente.yaws, per archivio.yaws e per notizie.yaws)
numero_commenti(Id_post) ->
	Commenti = leggi_commenti(Id_post),
	Num_Commenti = length(Commenti),
	Num_Commenti.


provaQuery() -> 
	do(qlc:q([X || X <- mnesia:table(utenti)])).
	
provaQueryUtenti() -> 
	do(qlc:q([X || X <- mnesia:table(appoggio)])).

provaQueryAvatar() -> 
	do(qlc:q([X || X <- mnesia:table(avatar)])).

provaQueryPost() -> 
	do(qlc:q([X || X <- mnesia:table(post)])).		

provaQueryCommenti() -> 
	do(qlc:q([X || X <- mnesia:table(commenti)])).

	provaQueryChat() -> 
	do(qlc:q([X || X <- mnesia:table(chat)])).	