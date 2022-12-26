CREATE TABLE customers
(
    id integer
        constraint customers_pk
            primary key autoincrement,
    firstname varchar(255) not null,
    lastname  varchar(255) not null,
    invoice_address_id integer
        constraint customers_invoice_address_id_fk
            references addresses (id),
    delivery_address_id integer
        constraint customers_delivery_address_id_fk
            references addresses (id)
)