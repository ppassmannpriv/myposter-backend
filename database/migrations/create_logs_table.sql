CREATE TABLE "logs"
(
    json json not null,
    created_at datetime,
    log_level varchar(15),
    channel var_char(255)
)