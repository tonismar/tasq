PRAGMA foreign_keys=OFF;
BEGIN TRANSACTION;
CREATE TABLE owner (
    id integer not null primary key autoincrement,
    nome varchar(50) not null,
    senha varchar(15) not null,
    usuario varchar(20) not null
);
CREATE TABLE tasq (
    id integer not null primary key autoincrement,
    descricao varchar(100),
    prioridade integer not null default 1,
    id_owner integer not null,
    dt_previsao varchar(8),
    dt_termino varchar(8),
    titulo varchar(25),
    foreign key(id_owner) references owner(id)
);
CREATE TABLE stepping (
    id integer not null primary key autoincrement,
    id_tasq integer not null,
    descricao varchar(100),
    dt_step varchar(8),
    foreign key(id_tasq) references tasq(id)
);
CREATE UNIQUE INDEX usuario_idx on owner (usuario);
COMMIT;