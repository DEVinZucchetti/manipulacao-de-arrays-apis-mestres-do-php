    CREATE TABLE places (
    id serial PRIMARY KEY,
    name varchar(150) not null,
    contact varchar(150) not null,
    opening_hours varchar(150) not null,
    description varchar(150) not null,
    latitude NUMERIC not null,
    longitude NUMERIC not null
);

CREATE TYPE status AS ENUM ('PENDENTE', 'APROVADO', 'REJEITADO');

CREATE TABLE reviews (
    id serial PRIMARY KEY,
    name varchar(50) not null,
    email varchar(100) not null,
    stars NUMERIC CHECK (stars >= 1 AND stars <= 5),
    date TIMESTAMP,
    status status,
    place_id INT REFERENCES places(id)
);