-module(blogchat_DB).
-compile(export_all).
%include la libreria per poter effettuare le query
-include_lib("stdlib/include/qlc.hrl").
%include il file blogchat_DB.hrl
-include("blogchat_DB.hrl").

%fa partire il DB per la prima volta per poter creare le tabelle
startDB() ->
	application:set_env(mnesia,dir,"BlogChat.Mnesia"),
	mnesia:create_schema([node()]),
	mnesia:start(),
	inizializzaDB().
	
%funzione che crea il database a partire dal file blogchat.hrl
inizializzaDB() ->
	mnesia:create_table(utenti,[{attributes, record_info(fields, utenti)},{disc_copies,[nonode@nohost]}]),
	mnesia:create_table(post,[{attributes, record_info(fields, post)},{disc_copies,[nonode@nohost]},{index, [#post.id_post]}]),
	mnesia:create_table(commenti,[{attributes, record_info(fields, commenti)},{disc_copies,[nonode@nohost]},{index, [#commenti.id_utente]}]),
	mnesia:create_table(chat,[{attributes, record_info(fields, chat)},{disc_copies,[nonode@nohost]}]),
	mnesia:create_table(avatar,[{attributes, record_info(fields, avatar)},{disc_copies,[nonode@nohost]}]),
	mnesia:create_table(appoggio,[{attributes, record_info(fields, appoggio)},{disc_copies,[nonode@nohost]},{index, [#appoggio.numero]}]).

do(Q) ->
    F = fun() -> qlc:e(Q) end,
    {atomic, Val} = mnesia:transaction(F),
    Val.
	
provaQuery() -> 
	do(qlc:q([X || X <- mnesia:table(utenti)])).

tabellaPost() ->
	mnesia:create_table(post,[{attributes, record_info(fields, post)},{disc_copies,[nonode@nohost]},{index, [#post.id_utente]}]).