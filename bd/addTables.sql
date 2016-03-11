USE acu;
DROP TABLE IF EXISTS User CASCADE; 
CREATE TABLE User(
    idU NUMERIC(6) NOT NULL auto_increment UNIQUE,
    name VARCHAR(20) NOT NULL UNIQUE,
    password VARCHAR(20) NOT NULL,
    lastSignIn DATE,
    primary key (idU)
);