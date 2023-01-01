CREATE TABLE orders
(
    id                  integer
        constraint orders_pk
            primary key autoincrement,
    customer_id         integer     not null
        constraint orders_customers_null_fk
            references customers (id),
    delivery_address_id integer     not null
        constraint orders_addresses_null_fk
            references addresses (id),
    invoice_address_id  integer     not null
        constraint orders_addresses_null_fk
            references addresses (id),
    status              varchar(30) not null,
    created_at          datetime    not null,
    updated_at          datetime    not null
);