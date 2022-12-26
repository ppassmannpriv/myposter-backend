INSERT INTO `orders`
VALUES (
        1000001,
        (SELECT `id`, `delivery_address_id`, `invoice_address_id` FROM `customers` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne'),
        'ordered',
        '2021-01-01 00:00:00'
    )

VALUES (1000001, 'Bruce Wayne', 'Bruce Wayne, 1007 Mountain Drive, Gotham', 'Bruce Wayne, 1007 Mountain Drive, Gotham',
        '{\"items\":[{\"item_type\":\"poster\",\"size_height\":80,\"size_width\":60,\"amount\":2,\"image\":\"/files/poster_1.jpg\"},{\"item_type\":\"poster\",\"size_height\":80,\"size_width\":60,\"amount\":1,\"image\":\"/files/poster_2.jpg\"}]}',
        '2021-01-01 00:00:00', 'ordered'),
       (1000001, 'Bruce Wayne', 'Bruce Wayne, 1007 Mountain Drive, Gotham', 'Bruce Wayne, 1007 Mountain Drive, Gotham',
        '{\"items\":[{\"item_type\":\"canvas\",\"size_height\":80,\"size_width\":80,\"amount\":1,\"image\":\"/files/canvas_1.jpg\"}]}',
        '2021-01-01 00:00:00', 'shipped'),
       (1000002, 'Peter Parker', 'Maybelle Parker, 15th Street, Queens, New York City, New York',
        'Peter Parker, 20 Ingram Street, Forest Hills, Queens, New York City, New York',
        '{\"items\":[{\"item_type\":\"canvas\",\"size_height\":80,\"size_width\":80,\"amount\":1,\"image\":\"/files/canvas_1.jpg\"},{\"item_type\":\"poster\",\"size_height\":20,\"size_width\":20,\"amount\":2,\"image\":\"/files/poster_123.jpg\"},{\"item_type\":\"canvas\",\"size_height\":80,\"size_width\":80,\"amount\":3,\"image\":\"/files/canvas_2.jpg\"},{\"item_category\":\"accessory\",\"item_type\":\"tape\",\"amount\":4},{\"item_category\":\"frame\",\"item_type\":\"wooden-frame-1\",\"size_height\":80,\"size_width\":80,\"amount\":3},{\"item_category\":\"frame\",\"item_type\":\"wooden-frame-2\",\"size_height\":20,\"size_width\":20,\"amount\":2}]}',
        '2021-01-01 00:00:00', 'slicing');

INSERT INTO `customers` ('firstname', 'lastname')
VALUES ('Bruce', 'Wayne'), ('Peter', 'Parker');

INSERT INTO `addresses` ('firstname', 'lastname', 'street', 'house_number', 'zipcode', 'city', 'customer_id')
VALUES ('Bruce', 'Wayne', 'Mountain Drive', '1007', null, 'Gotham', (
        SELECT `id` FROM `customers` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne'
    )
), ('Maybelle', 'Parker', '15th Street', null, null, 'Queens, New York City, New York', (
        SELECT `id` FROM `customers` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'
    )
), ('Peter', 'Parker', 'Ingram Street', '20', null, 'Forest Hills, Queens, New York City, New York', (
    SELECT `id` FROM `customers` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'
)
)

UPDATE `customers` SET
    `invoice_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne'),
    `delivery_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne')
WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne';

UPDATE `customers` SET
    `invoice_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'),
    `delivery_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Maybelle' AND `lastname` = 'Parker')
WHERE `firstname` = 'Peter' AND `lastname` = 'Parker';