-module(funzioniChat).
-compile(export_all).
%include la libreria per poter effettuare le query
-include_lib("stdlib/include/qlc.hrl").
%include il file blogchat_DB.hrl
-include("../blogchat_DB.hrl").
%include il file sessione.hrl
-include("../sessione.hrl").
%include il file yaws_api.hrl
-include("C:/Program Files (x86)/Yaws-1.98/include/yaws_api.hrl").

%funzioniChat.erl:file contenente le funzioni utilizzate all'interno della chat di BlogChat

%funzione che esegue una query	
do(Q) ->
    F = fun() -> qlc:e(Q) end,
    {atomic, Val} = mnesia:transaction(F),
    Val.

%funzione che legge i la chat di tutti gli utenti
leggiMessaggiChat() ->
		QH = do(qlc:q([{Y#chat.id_messaggio_chat,X#utenti.nome_utente,Y#chat.messaggio,Y#chat.data_commento} || X <- mnesia:table(utenti),
						Y <- mnesia:table(chat),
						X#utenti.id =:= Y#chat.id_utente])),
		QL =qlc:sort(QH,{order,descending}),
		QC = qlc:cursor(QL),
		Chat = qlc:next_answers(QC,all_remaining),
		qlc:delete_cursor(QC),
		Chat.

%legge l'id corrente dalla tabella appoggio del label Target per salvare i messaggi chat
leggi_id(Target)->
	do(qlc:q([X#appoggio.numero || X <- mnesia:table(appoggio),
			     X#appoggio.label =:= Target
				])).

%funzione che salva un messaggio di Chat all'interno del DB
inserisciMessaggioChat(NomeUtente,Messaggio) ->
		mnesia:dirty_update_counter(appoggio,numMessChat,+1),
			ListaId=leggi_id(numMessChat),
			[Id | Lista ] = ListaId,
			Val = do(qlc:q([{X#utenti.id} || X <- mnesia:table(utenti),
				X#utenti.nome_utente =:= NomeUtente])),
			[{IdUtente}] = Val,
			DataMessChat = erlang:localtime(),
			Row = #chat{id_messaggio_chat=Id, id_utente=IdUtente, messaggio=Messaggio, data_commento=DataMessChat},
   			F = fun() ->
						mnesia:write(Row)
						end,
   			mnesia:transaction(F).
