
-- (docker run --name places -e POSTGRESQL_USERNAME=docker -e POSTGRESQL_PASSWORD=docker -e POSTGRESQL_DATABASE=api_places_database -p 5432:5432 bitnami/postgresql)


create type status_reviews as enum ('PENDENTE', 'APROVADO', 'REJEITADO');

create table places(
"id" serial primary key,
"name" varchar(150),
"contact" varchar(20),
"opening_hours" varchar(200),
"description" text,
"latitude" float unique not null,
"longitude" float unique not null,
created_at timestamp with time zone default now()
);

create table reviews(
id serial primary key,
"place_id" integer,
"name" text not null,
"email" varchar(150),
"stars" decimal(2,1),
"date" timestamp,
"status" status_reviews default 'PENDENTE',
created_at timestamp with time zone default now(),
foreign key("place_id") references places(id));

insert into places
	(
		name,
		contact,
		opening_hours,
		description,
		latitude,
		longitude
	)
	values
	(
		'Praça das primaveras',
		'49918295442',
		'',
		'',
		-8.123654899,
		1.9874633292
	);
	
select * from places p

select * from places where  id=1

select * from places
where  extract (month from created_at) == extract(month from now());

select * from places 
where extract(month from created_at) between 7 and 12


delete from  places where id = 1



update  places 
	set description = 'Aqui nasce flor todos os dias',
		opening_hours = 'Aberta 24 hs'
	where id = 2
	
	
	insert into reviews
	(
		place_id,
		name,
		email,
		stars
	)
	values
	(	
		4,
		'José',
		'josecdia@hotmail.com',
		'5'	
	);

	
	select p.id as id_places,
		   p.name as nome_lugar
	from reviews r
	join places p on p.id  = r.place_id