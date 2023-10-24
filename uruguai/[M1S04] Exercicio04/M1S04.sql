/* -------- M1S04 -------- */

/* -------- Ex 1 - BANCO DE DADOS COM DOCKER -------- */

docker run 
	--name places
	-e POSTGRESQL_USERNAME=docker
	-e POSTGRESQL_PASSWORD=docker
        -e POSTGRESQL_DATABASE=api_places_database
        -p 5432:5432
        bitnami/postgresql

/* -------- Ex 2 - TABELA PLACES -------- */

CREATE TABLE "places" (
  "id" serial PRIMARY KEY,
  "name" varchar(200) NOT NULL,
  "contact" varchar(20),
  "opening_hours" varchar(100),
  "description" text,
  "latitude" float UNIQUE NOT NULL,
  "longitude" float UNIQUE NOT NULL,
  "created_at" timestamp with time zone default now()
);

/* -------- Ex 3 - TABELA REVIEWS -------- */

CREATE TYPE status_reviews AS enum('PENDENTE', 'APROVADO', 'REJEITADO');

CREATE TABLE "reviews" (
  "id" serial PRIMARY KEY,
  "name" text NOT NULL,
  "email" varchar(150),
  "stars" decimal(2,1),
  "date" timestamp,
  "status" status_reviews DEFAULT 'PENDENTE',
  "place_id" integer,
  "created_at" timestamp with time zone default now(),
  FOREIGN KEY ("place_id") REFERENCES "places" ("id")
);

/* -------- Ex 4 - INSERT e SELECT - PLACES -------- */

INSERT INTO places 
  	(name, contact, opening_hours, description, latitude, longitude)
	VALUES 
	('Teatro Solis', '5981950332', '11:00-16:00', 'O Teatro Solis da cidade de Montevidéu foi inaugurado no ano de 1856.', -34.9076336, -56.2011228);

SELECT * FROM places p

SELECT * FROM places
	WHERE id = 1

/* -------- Ex 5 - UPDATE E DELETE - PLACES -------- */

UPDATE places
	SET opening_hours = '10:00-22:30'
	WHERE id = 1
	
DELETE FROM places 
	WHERE id = 3

/* -------- Ex 6 - INSERT, SELECT - REVIEWS -------- */

INSERT INTO reviews
  	(name, email, stars, date, place_id)
	VALUES 
	('Verônica', 'veu@gmail.com', '4', now(), 1);

SELECT r.*
FROM reviews r
JOIN places p 
ON r.place_id = p.id;