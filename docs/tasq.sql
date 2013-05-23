-- create by Tonismar R. Bernardo
-- date 21/05/2013
-- tonismar.at.gmail.com

BEGIN TRANSACTION;

create table owner (
    id integer not null primary key autoincrement,
    nome varchar(50) not null,
    senha varchar(15) not null,
    usuario varchar(20) not null,
    unique key 'usuario' ('usuario')
);

create table tasq (
    id integer not null primary key autoincrement,
    descricao varchar(100),
    prioridade integer not null default 1,
    id_owner integer not null,
    dt_previsao varchar(8),
    dt_termino varchar(8),
    titulo varchar(25),
    foreign key(id_owner) references owner(id)
);

create table stepping (
    id integer not null primary key autoincrement,
    id_tasq integer not null,
    descricao varchar(100),
    dt_step varchar(8),
    foreign key(id_tasq) references tasq(id)
);