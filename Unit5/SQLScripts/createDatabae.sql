CREATE DATABASE banking;

Use banking;
CREATE TABLE savings(id char(10) NOT NULL, balance decimal(10,2) NOT NULL default(0));

USe banking;
Insert Into savings(id, balance)
values("1", 0), ('3', 0), ('2', 10)