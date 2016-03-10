USE acu;
DROP TABLE IF EXISTS User CASCADE; 
CREATE TABLE User(
    idU NUMERIC(6),
    name VARCHAR(20),
    password VARCHAR(20),
    lastSignIn DATE
);