use  observerside;
create table Pelicula ( id int not null auto_increment primary key, titulo  varchar(400) not null, descripcion varchar (400) not null,
anio int not null,  categoria int not null, foreign key fk_cat(categoria) REFERENCES Categoria(id));
