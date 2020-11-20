

create database registro_cursos;
use registro_cursos;

drop table if exists ASPIRANTES;

 

drop table if exists ASPIRANTES_CURSOS;

 

drop table if exists CATALOGO_CURSO;

 

/*==============================================================*/
/* Table: ASPIRANTES                                            */
/*==============================================================*/
create table ASPIRANTES
(
   RFC                  char(13) not null,
   NOMBRE               varchar(30),
   PATERNO              varchar(30),
   MATERNO              varchar(30),
   EMPRESA              varchar(30),
   TELEFONO             bigint,
   EMAIL                varchar(60),
   FECHA_REGISTRO       datetime,
   primary key (RFC)
)
engine = InnoDB;

 

/*==============================================================*/
/* Table: ASPIRANTES_CURSOS                                     */
/*==============================================================*/
create table ASPIRANTES_CURSOS
(
   ID_CURSO             int not null,
   RFC                  char(13) not null,
   FECHA		datetime not null,
   primary key (ID_CURSO, RFC)
)
engine = InnoDB;

 

/*==============================================================*/
/* Table: CATALOGO_CURSO                                        */
/*==============================================================*/
create table CATALOGO_CURSO
(
   ID_CURSO             int not null,
   NOMBRE_CURSO         varchar(30),
   FECHA_ALTA           datetime,
   primary key (ID_CURSO)
)
engine = InnoDB;

 

alter table ASPIRANTES_CURSOS add constraint FK_ASPIRANTES_CURSOS foreign key (ID_CURSO)
      references CATALOGO_CURSO (ID_CURSO) on delete restrict on update restrict;

 

alter table ASPIRANTES_CURSOS add constraint FK_ASPIRANTES_CURSOS2 foreign key (RFC)
      references ASPIRANTES (RFC) on delete restrict on update restrict;

INSERT INTO `catalogo_curso`(`ID_CURSO`, `NOMBRE_CURSO`, `FECHA_ALTA`) VALUES (1,'INTRODUCCION A LA ECOLOGIA','2020-01-02 19:00:00');
INSERT INTO `catalogo_curso`(`ID_CURSO`, `NOMBRE_CURSO`, `FECHA_ALTA`) VALUES (2,'RECURSOS RENOVABLES','2020-01-02 19:00:00');
INSERT INTO `catalogo_curso`(`ID_CURSO`, `NOMBRE_CURSO`, `FECHA_ALTA`) VALUES (3,'CONTAMINACION DEL MEDIO AMBIENTE','2020-01-02 19:00:00');
INSERT INTO `catalogo_curso`(`ID_CURSO`, `NOMBRE_CURSO`, `FECHA_ALTA`) VALUES (4,'CULTURA ECOLOGICA','2020-01-02 19:00:00');
INSERT INTO `catalogo_curso`(`ID_CURSO`, `NOMBRE_CURSO`, `FECHA_ALTA`) VALUES (5,'PROGRAMACION ORIENTADA A OBJETOS','2020-01-02 19:00:00');

use registro_cursos;
select * from catalogo_curso;
select * from aspirantes;
select * from aspirantes_cursos;

/*==============================================================*/
/* QUERY PARA INSERTAR ASPIRANTES REFERENCIANDO A ASPIRANTES_CURSO*/
/*==============================================================*/
insert into aspirantes_cursos (RFC,ID_CURSO,FECHA) values('AALL950401','2','2020-11-08 08:01:02');
insert into aspirantes_cursos (RFC,ID_CURSO,FECHA) values('PTLL950412','4','2020-11-08 08:05:38');

select * from aspirantes_cursos;

insert into aspirantes_cursos (RFC,ID_CURSO,FECHA) values('IRLL951917','3','2020-11-09 09:11:17');
