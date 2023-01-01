CREATE TABLE articles
(
    id                INTEGER
        constraint articles_pk
            primary key autoincrement,
    type              INTEGER not null,
    name              varchar(255),
    short_description TEXT,
    description       TEXT,
    category_id       INTEGER not null
        constraint articles_article_categories_null_fk
            references article_categories (id),
    active            boolean default true
)