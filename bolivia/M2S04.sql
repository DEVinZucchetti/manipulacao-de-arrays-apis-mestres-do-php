/* Exercicio 1 */

docker run 
	--name places
	-e POSTGRESQL_USERNAME=docker
	-e POSTGRESQL_PASSWORD=docker
        -e POSTGRESQL_DATABASE=api_places_database
        -p 5432:5432
        bitnami/postgresql

/* Exercicio 2 */

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

/* Exercicio 3 */

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

/* Exercicio 4 */

INSERT INTO places 
  	(name, contact, opening_hours, description, latitude, longitude)
	VALUES 
	('Parque Nacional Amborá', '15485875624', '10:00-22:00', 'É uma reserva natural com mais de 912 espécies de aves, mais de 177 espécies de mamíferos, incluindo puma, jaguatirica e o raro urso de óculos.', -17.816227346864807, -63.632262706595206);

SELECT * FROM places p

SELECT * FROM places
	WHERE id = 1

/* Exercicio 5 */

UPDATE places
	SET opening_hours = '10:00-22:30'
	WHERE id = 1

DELETE FROM places 
	WHERE id = 2

/* Exercicio 6 */

INSERT INTO reviews
  	(name, email, stars, date, place_id)
	VALUES 
	('', 'teste@gmail.com', '5', now(), 1);

SELECT r.*
FROM reviews r
JOIN places p 
ON r.place_id = p.id;