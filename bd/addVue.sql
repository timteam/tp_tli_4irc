CREATE VIEW v_search AS
  SELECT
    p.idP,
    p.mer,
    -- Type de pathologie
    p.type REGEXP '^m'         AS m,
    p.type REGEXP '^tf'        AS tf,
    p.type REGEXP '^j'         AS j,
    p.type REGEXP '^mv'        AS mv,
    p.type REGEXP '^l'         AS l,
    -- Caractéristiques de la pathologie
    p.type REGEXP '^(l|tf).*p' AS p,
    p.type REGEXP '^(l|tf).*v' AS v,
    p.type REGEXP '^tf.*c'     AS c,
    p.type REGEXP '^tf.*f'     AS f,
    p.type REGEXP '^mi'        AS i,
    p.type REGEXP '^me'        AS e
  FROM patho p;
 
 
CREATE TABLE pathoType (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  prefix VARCHAR(10) NOT NULL UNIQUE,
  nom VARCHAR(200),
  PRIMARY KEY (id)
);
 
INSERT INTO pathoType (prefix,nom) VALUES
  ("m","méridien"),
  ("tf","organe/viscère"),
  ("l","luo"),
  ("mv","merveilleux vaisseaux"),
  ("j","jing jin");
 
CREATE TABLE pathoCaracteristique (
  id MEDIUMINT NOT NULL AUTO_INCREMENT,
  prefix VARCHAR(10) NOT NULL UNIQUE,
  nom VARCHAR(200),
  PRIMARY KEY (id)
);
 
INSERT INTO pathoCaracteristique (prefix,nom) VALUES
  ("p","plein"),
  ("v","vide"),
  ("f","froid"),
  ("c","chaud"),
  ("e","externe"),
  ("i","interne");
