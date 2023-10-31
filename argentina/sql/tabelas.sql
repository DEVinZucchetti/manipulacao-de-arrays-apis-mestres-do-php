 
 
 CREATE type "status_enum" as enum (
  'PENDENTE',
   'EM_ANDAMENTO',
   'FINALIZADO'
);
 
  CREATE TABLE "places" (
  id serial PRIMARY KEY,
  name varchar(150) NOT NULL,
  contact varchar(32),
  opening_hours varchar(120),
  description text,
  latitude float UNIQUE NOT NULL,
  longitude float UNIQUE NOT NULL,
  created_at timestamp with time zone DEFAULT now()
)
  
  CREATE TABLE "reviews" (
  id serial PRIMARY KEY,
  place_id integer,
  name text NOT NULL,
  email varchar(150),
  stars decimal(2,1),
  date timestamp,
  status status not null default'PENDENTE',
  created_at timestamp with time zone DEFAULT now(),
  foreign KEY  ("place_id") REFERENCES "places" (id)
);
