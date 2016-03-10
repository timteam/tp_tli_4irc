USE acu;
DROP TABLE IF EXISTS User CASCADE; 
CREATE TABLE User(
    idU NUMERIC(6) NOT NULL auto_increment,
    name VARCHAR(20) NOT NULL,
    password VARCHAR(20) NOT NULL,
    lastSignIn DATE,
    primary key (idU)
);