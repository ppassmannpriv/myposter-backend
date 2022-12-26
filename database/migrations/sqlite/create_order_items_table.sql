CREATE TABLE order_items
(
    id integer
        constraint order_items_pk
            primary key autoincrement,
    item_type varchar(50),
    amount integer default 1 not null,
    image varchar(255) not null,
    size_height integer not null,
    size_width integer not null,
    order_id integer not null
        constraint order_items_orders_null_fk
            references orders (id)
)