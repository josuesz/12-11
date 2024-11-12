create database empresa;
use empresa;

create table tbl_funcionario(
       fun_codigo int primary key auto_increment,
       fun_nome varchar(45),
       fun_cargo varchar(45));
       
create table tbl_registros(
       reg_codigo int primary key auto_increment,
       reg_data date,
       reg_hora varchar(45),
       fun_codigo int);
       
drop table tbl_registros;
       
alter table tbl_registros
add constraint fk_fun_codigo
foreign key (fun_codigo) references tbl_funcionario (fun_codigo)

select*from tbl_funcionario;
select*from tbl_registros;