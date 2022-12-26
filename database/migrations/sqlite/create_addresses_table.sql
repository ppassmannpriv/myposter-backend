CREATE TABLE addresses
(
    id           integer
        constraint addresses_pk
            primary key autoincrement,
    firstname    varchar(255) not null,
    lastname     varchar(255),
    street       varchar(255) not null,
    house_number varchar(50),
    zipcode      varchar(20),
    city         varchar(255) not null,
    customer_id integer not null
        constraint addresses_customers_null_fk
            references customers (id)
)