CREATE TABLE addresses
(
    id            int unsigned auto_increment primary key,
    address_line1 varchar(1024) null,
    address_line2 varchar(1024) null,
    city          varchar(1024) null,
    state         varchar(10)   null,
    zip           varchar(10)   null
);