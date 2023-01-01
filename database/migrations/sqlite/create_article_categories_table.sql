CREATE TABLE article_categories
(
    id   integer
        constraint article_categories_pk
            primary key autoincrement,
    name varchar(255) not null
)