use  observerside;
create table log ( id int not null auto_increment primary key,
fecha datetime  not null,  usuario int not null, pelicula int not null,
foreign key fk_usuario(usuario) REFERENCES usuario(id)
, foreign key fk_pelicula(pelicula) REFERENCES Pelicula(id));
