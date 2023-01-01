CREATE INDEX order_items__index
    on order_items (order_id);

CREATE INDEX addresses_customer_id_index
    on addresses (customer_id);

CREATE INDEX orders_customer_id_index
    on orders (customer_id);

CREATE INDEX articles_category_id_index
    on articles (category_id);

CREATE UNIQUE INDEX article_categories_name_uindex
    on article_categories (name);