CREATE TABLE orders
(
    id  integer
        constraint orders_pk
            primary key autoincrement,
    customer_id integer not null
        constraint orders_customers_null_fk
            references customers (id),
    delivery_address_id integer not null
        constraint orders_delivery_address_id_fk
            references addresses (id),
    invoice_address_id integer not null
        constraint orders_invoice_address_id_fk
            references addresses (id),
    status varchar(30) not null,
    created_at datetime default CURRENT_TIMESTAMP not null
)