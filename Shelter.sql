CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

/*
DROP TABLE IF EXISTS "Adoption" CASCADE;
DROP TABLE IF EXISTS "Dog" CASCADE;
DROP TABLE IF EXISTS "Owner" CASCADE;
*/

DELETE FROM "Owner"
WHERE "Id" = '4a58e839-2200-dfd7-093b-1a911a64c56c';

SELECT * FROM "Owner"
SELECT * FROM "Dog"
SELECT * FROM "Adoption"

CREATE TABLE "Owner" (
    "Id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "Username" VARCHAR(255) UNIQUE NOT NULL,
    "Password" VARCHAR(255) NOT NULL,
    "Email" VARCHAR(255) UNIQUE NOT NULL,
    "Name" VARCHAR(255) NOT NULL,
    "Created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


CREATE TABLE "Dog" (
    "Id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "Name" VARCHAR(255) NOT NULL,
    "Age" INT NOT NULL,
    "Breed" VARCHAR(255) NOT NULL,
    "FurColor" VARCHAR(255) NOT NULL,
    "IsTrained" BOOLEAN NOT NULL,
    "Image" VARCHAR(255) NOT NULL,
    "Medical_Records" VARCHAR(1000),
    "Created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT unique_dog_entry UNIQUE ("Name", "Age", "FurColor", "Image")
);


CREATE TABLE "Adoption" (
    "Id" UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    "Dog_id" UUID NOT NULL,
    "Owner_id" UUID NOT NULL,
    "Created_at" TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_adoption_dog FOREIGN KEY ("Dog_id") REFERENCES "Dog"("Id") ON DELETE CASCADE,
    CONSTRAINT fk_adoption_owner FOREIGN KEY ("Owner_id") REFERENCES "Owner"("Id") ON DELETE CASCADE
);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('American pitbull', 1, 'American Pitbull', 'Brown', true, '/assets/american-pitbull.png', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Beagle', 2, 'Beagle', 'Tri-color', false, '/assets/beagle.jpg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Bulldog', 3, 'Bulldog', 'Brindle', true, '/assets/bulldog.png', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Collie', 4, 'Border Collie', 'Black and White', false, '/assets/collie.jpg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Brindle french bulldog', 5, 'French Bulldog', 'Brindle', true, '/assets/brindle-french-bulldog.png', 'Owner reports shallow breathing on short walks');

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('German sheperd', 1, 'German Shepherd', 'Black', false, '/assets/German_Shepherd.jpg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Goldie', 2, 'Golden Retriever', 'Golden', true, '/assets/goldie.jpg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Mops', 3, 'Mops', 'Fawn', false, '/assets/Mops.jpeg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Rust', 4, 'Doberman', 'Rust', true, '/assets/Rust.png', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Husky', 5, 'Siberian Husky', 'Gray and White', false, '/assets/husky.png', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Merle', 1, 'Australian Shepherd', 'Merle', true, '/assets/Merle.jpg', NULL);

INSERT INTO "Dog" ("Name", "Age", "Breed", "FurColor", "IsTrained", "Image", "Medical_Records")
VALUES ('Rottweiler', 2, 'Rottweiler', 'Black and Tan', false, '/assets/rottweiler.jpg', NULL);


SELECT 
    d."Id" AS "DogId",
    d."Name",
    d."Age",
    d."Breed",
    d."FurColor",
    d."IsTrained",
    d."Image",
    d."Medical_Records",
    a."Owner_id" AS "OwnerId"
FROM "Adoption" a
JOIN "Dog" d ON a."Dog_id" = d."Id"
WHERE a."Owner_id" = 'bd976be4-c9a1-a3b1-c96b-d3e49a239ebd';