CREATE TABLE order_items
(
    id integer
        constraint order_items_pk
            primary key autoincrement,
    item_category varchar(50) default 'production' not null,
    item_type varchar(50) not null,
    amount integer default 1 not null,
    image varchar(255) null,
    size_height integer null,
    size_width integer null,
    order_id integer not null
        constraint order_items_orders_null_fk
            references orders (id),
    article_id integer not null
        constraint order_items_articles_null_fk
            references articles (id)
);