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