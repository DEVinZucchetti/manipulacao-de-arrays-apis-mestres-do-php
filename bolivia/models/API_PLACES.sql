
/* Cria banco */
docker run 
	--name api_places
	-e POSTGRESQL_USERNAME=docker
	-e POSTGRESQL_PASSWORD=docker
        -e POSTGRESQL_DATABASE=api_places_database
        -p 5432:5432
        bitnami/postgresql

/*Questao 2 */

CREATE TABLE "places" (
  "id" serial PRIMARY KEY,
  "name" varchar(150) NOT NULL,
  "contact" varchar(20),
  "opening_hours" varchar(100),
  "description" text,
  "latitude" float UNIQUE NOT NULL,
  "longitude" float UNIQUE NOT NULL,
  "created_at" timestamp with time zone default now()
);


/*Questao 3 */
CREATE TYPE status_reviews AS enum('PENDENTE', 'APROVADO', 'REJEITADO');

CREATE TABLE "reviews" (
  "id" serial PRIMARY KEY,
  "place_id" integer,
  "name" text NOT NULL,
  "email" varchar(150),
  "stars" decimal(2,1),
  "date" timestamp,
  "status" status_reviews DEFAULT 'PENDENTE',
  "created_at" timestamp with time zone DEFAULT now(),
  FOREIGN KEY ("place_id") REFERENCES "places" ("id")
);

/*Questao 4 */

  insert into places (
  			name, 
  			contact, 
  			opening_hours, 
  			description, 
  			latitude,
  			longitude		
  			)
         values 
            (
             'Praça da paz',
             '85 99181-1111',
             '',
             '',
             -1.22343434,
             2.232323234
            );
           
       select * from places p 
       
       select * from places where id = 1
       
       select * from places 
       where extract (month from created_at) = extract(month from now())
      
       select * from places
       where extract(month from created_at) between 7 and 12
       
 /*Questao 5 */
       
       delete from places where id = 3
       
       update places 
              set description  = 'Aqui há paz',
                 opening_hours = 'Aberto das 09:00 as 12:00'
           where id = 1
           
/*Questao 6 */
    update  places 
        set description = 'Nova description',
            opening_hours = 'Aberta aos finais de semana'
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
            'Fabricio',
            'email@email.com',
            '1'	
        );

	
	select p.id as id_places,
		   p.name as nome_lugar
	from reviews r
	join places p on p.id  = r.place_id