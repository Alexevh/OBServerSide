use observerside;
create table pelicula ( id int not null auto_increment primary key, titulo  varchar(400) not null, descripcion varchar (400) not null,
anio int not null,  categoria int not null, created datetime, updated datetime, foreign key fk_cat(categoria) REFERENCES categoria(id));
