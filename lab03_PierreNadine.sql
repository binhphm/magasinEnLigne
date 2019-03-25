-- Labo 3
-- Fait par : Nadine Pierre
-- Date de remise : 2019/03/22

-- Question #1

DROP DATABASE IF EXISTS magasin_en_ligne;

CREATE DATABASE magasin_en_ligne;

USE magasin_en_ligne;

DROP TABLE IF EXISTS client;
CREATE TABLE client(
    no_client INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_client VARCHAR(50) NOT NULL,
	prenom_client VARCHAR(50) NOT NULL,
	adresse VARCHAR(50) NOT NULL,
    ville VARCHAR(50) NOT NULL,
	province VARCHAR(50) NOT NULL,
	pays VARCHAR(50) NOT NULL,
	code_postal VARCHAR(10) NOT NULL,
    no_tel VARCHAR(25) NOT NULL,
	pseudo VARCHAR(25),
    mot_de_passe VARCHAR(25),
	courriel VARCHAR(255) NOT NULL,
    PRIMARY KEY(no_client)
);

DROP TABLE IF EXISTS commande;
CREATE TABLE commande(
    no_commande INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
    date_commande DATETIME NOT NULL,
    no_client INT(10) UNSIGNED NOT NULL,
    PRIMARY KEY (no_commande),
    CONSTRAINT client_commande_fk FOREIGN KEY (no_client) REFERENCES client (no_client)
);

DROP TABLE IF EXISTS article;
CREATE TABLE article(
	no_article INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	description VARCHAR(255) NOT NULL,
	chemin_image VARCHAR(255),
	prix_unitaire DECIMAL(10,2),
	quantite_en_stock INT(10) NOT NULL,
	quantite_dans_panier INT(10) NOT NULL,
	PRIMARY KEY (no_article)
);

DROP TABLE IF EXISTS article_en_commande;
CREATE TABLE article_en_commande(
	no_article_en_commande INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	no_commande INT(10) UNSIGNED NOT NULL,
	no_article INT(10) UNSIGNED NOT NULL,
	quantite INT(10) UNSIGNED NOT NULL,
	PRIMARY KEY (no_article_en_commande),
	CONSTRAINT commande_fk FOREIGN KEY (no_commande) REFERENCES commande (no_commande),
	CONSTRAINT article_fk FOREIGN KEY (no_article) REFERENCES article (no_article)
);


-- Question #2

INSERT INTO client (nom_client, prenom_client, adresse, ville, province, pays, code_postal, no_tel, courriel) 
	VALUES ('Collins', 'Renee B', '2394 St Jean Baptiste St', 'Montreal', 'Quebec', 'Canada', 'G0M 1W0', '819-548-2143', 'w8drqcfwb2o@payspun.com');

INSERT INTO client (nom_client, prenom_client, adresse, ville, province, pays, code_postal, no_tel, courriel) 
	VALUES ('Kirk', 'Oscar M', '4277 40th Street', 'Calgary', 'Alberta', 'Canada', 'T2C 2P3', '403-236-7859', 'xt4v02xxx0g@thrubay.com');
	
INSERT INTO client (nom_client, prenom_client, adresse, ville, province, pays, code_postal, no_tel, courriel) 
	VALUES ('Delossantos', 'Julia', '4603 Yonge Street', 'Toronto', 'Ontario', 'Canada', 'M4W 1J7', '416-301-6292', 'sowl5hn2y9k@thrubay.com');
	
INSERT INTO client (nom_client, prenom_client, adresse, ville, province, pays, code_postal, no_tel, courriel) 
	VALUES ('Desantiago', 'Ruben J', '1097 Mountain Rd', 'Moncton', 'Nouveau-Brunswick', 'Canada', 'E1C 1H6', '506-961-5510', 'e02n5x6ptto@payspun.com');
	
INSERT INTO client (nom_client, prenom_client, adresse, ville, province, pays, code_postal, no_tel, courriel) 
	VALUES ('Rivera', 'Linda M', '496 2nd Street', 'Oakbank', 'Oakbank', 'Canada', 'R0E 1J0', '204-444-1472', 'os8l3vscf7r@fakemailgenerator.net');
	
INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Alikay Naturals Lemongrass Leave In Conditioner', 28.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('ApHogee Curlific! Texture Treatment', 13.99, 15, 0);
	
INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('As I Am Coconut Cowash Cleansing Conditioner', 15.99, 20, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Ardell Magnetic Lashes Double Wispies', 21.99, 20, 0);
	
INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Ardell Natural Lashes - Wispies Brown', 6.99, 50, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('BaByliss Pro Nano Titanium OPTIMA 3100 Straightening Iron 1" w/ Free Styling Kit', 271.99, 5, 0);
		
INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Beard Guyz Beard Care & Grooming Kit', 29.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Camille Rose Naturals Curl Maker', 41.99, 5, 0);
	
INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Cantu Shea Butter For Natural Hair Coconut Curling Cream', 31.99, 15, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Carol\'s daughter Black Vanilla Moisture & Shine Hydrating Conditioner', 29.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Carol\'s daughter Hair Milk Curl Defining Moisture Mask', 34.99, 5, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Curls Blueberry Bliss Curl Control Paste', 15.99, 20, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('DevaCurl Supercream Coconut Curl Styler', 55.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Dudu-Osum Black Soap', 5.99, 50, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('DUO Strip Lash Adhesive Tube Dark Tone', 8.99, 50, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Eco Styler Olive Oil Styling Gel 32oz', 9.99, 50, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('EDEN BodyWorks Coconut Shea Cleansing CoWash', 17.99, 20, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Shea Moisture Jamaican Black Castor Oil Strengthen & Grow Thermal Protectant', 19.99, 15, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Kera Care Edge Tamer 2.3oz', 11.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Kinky Curly Come Clean Shampoo', 21.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Maui Moisture Curl Quench+ Coconut Oil Curl Milk', 10.99, 5, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Mielle Organics Babassu Mint Deep Conditioner', 22.99, 15, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Moroccanoil Oil Treatment 3.4oz', 59.99, 5, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('TGIN Argan Replenishing Hair & Body Serum', 24.99, 10, 0);

INSERT INTO article (description, prix_unitaire, quantite_en_stock, quantite_dans_panier)
	VALUES ('Denman Brush D4 Black', 34.99, 25, 0);
	

-- Question #3

/* Le client #1 commande 1 article (3) */
INSERT INTO commande (date_commande, no_client) 
	VALUES (NOW(), 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (1, 3, 1);
UPDATE article 
	SET quantite_en_stock = quantite_en_stock - 1 
		WHERE no_article = 3 
		AND quantite_en_stock > 0;

/* Le client #2 commande 2 articles (11 et 17) */
INSERT INTO commande (date_commande, no_client) 
	VALUES (NOW(), 2);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (2, 11, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (2, 17, 1);
UPDATE article 
	SET quantite_en_stock = quantite_en_stock - 1 
		WHERE (no_article = 11 OR no_article = 17) 
		AND quantite_en_stock > 0;


/* Le client #3 commande 3 articles (2, 5 et 8) */
INSERT INTO commande (date_commande, no_client) 
	VALUES (NOW(), 3);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (3, 2, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (3, 5, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (3, 8, 1);
UPDATE article 
	SET quantite_en_stock = quantite_en_stock - 1 
		WHERE (no_article = 2 OR no_article = 5 OR no_article = 8) 
		AND quantite_en_stock > 0;

/* Le client #4 commande 4 articles (1, 4, 6, 7) */
INSERT INTO commande (date_commande, no_client) 
	VALUES (NOW(), 4);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (4, 1, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (4, 4, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (4, 6, 1);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (4, 7, 1);
UPDATE article 
	SET quantite_en_stock = quantite_en_stock - 1 
		WHERE (no_article = 1 OR no_article = 4 OR no_article = 6 OR no_article = 7) 
		AND quantite_en_stock > 0;
		
/* Le client #4 commande 1 article (20) */
INSERT INTO commande (date_commande, no_client) 
	VALUES (NOW(), 4);
INSERT INTO article_en_commande (no_commande, no_article, quantite) 
	VALUES (5, 20, 1);
UPDATE article 
	SET quantite_en_stock = quantite_en_stock - 1 
		WHERE no_article = 20
		AND quantite_en_stock > 0
		
-- Question #4
DROP USER IF EXISTS 'webdev'@'localhost';
CREATE USER 'webdev'@'localhost'
	IDENTIFIED BY 'toto99';
	
GRANT SELECT, INSERT, UPDATE 
	ON magasin_en_ligne.* 
	TO 'webdev'@'localhost';
GRANT DELETE ON magasin_en_ligne.commande TO 'webdev'@'localhost';
GRANT DELETE ON magasin_en_ligne.article_en_commande TO 'webdev'@'localhost';


-- Question #5

/* Vue article */
DROP VIEW IF EXISTS vue_article;
CREATE VIEW vue_article AS
	SELECT * 
		FROM article
		ORDER BY quantite_en_stock;
		
/* Vue commande */
DROP VIEW IF EXISTS vue_commande;
CREATE VIEW vue_commande AS	
	SELECT client.nom_client, client.prenom_client, client.ville, commande.no_commande, commande.date_commande
		FROM client
		JOIN commande ON client.no_client = commande.no_client;
		
/* Vue commande full */
DROP VIEW IF EXISTS vue_commande_full;
CREATE VIEW vue_commande_full AS
	SELECT
		CONCAT(client.prenom_client, " ", client.nom_client) as "Nom complet",
		client.ville, 
		commande.no_commande, 
		commande.date_commande,
		SUM(article_en_commande.quantite * article.prix_unitaire) AS "Prix total"
		FROM client
		JOIN commande ON client.no_client = commande.no_client
		JOIN article_en_commande ON commande.no_commande = article_en_commande.no_commande
		JOIN article ON article_en_commande.no_article = article.no_article
		GROUP BY commande.no_commande;

-- Question #6
ALTER TABLE client DROP INDEX IF EXISTS index_name;
CREATE INDEX index_no_client ON client(no_client);