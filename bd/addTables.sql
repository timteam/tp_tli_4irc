USE acu;
DROP TABLE IF EXISTS User CASCADE; 
CREATE TABLE User(
    idU INT NOT NULL auto_increment,
    name VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(50) NOT NULL,
    lastSignIn DATE,
    primary key (idU),
    UNIQUE(idU),
    UNIQUE(name)
);