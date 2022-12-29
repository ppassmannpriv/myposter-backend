INSERT INTO `customers` (`id`, `firstname`, `lastname`)
VALUES (1000001, 'Bruce', 'Wayne'),
       (1000002, 'Peter', 'Parker');

INSERT INTO `addresses` (`firstname`, `lastname`, `street`, `house_number`, `zipcode`, `city`, `customer_id`)
VALUES ('Bruce', 'Wayne', 'Mountain Drive', '1007', null, 'Gotham', (
        SELECT `id` FROM `customers` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne'
    )),
    ('Maybelle', 'Parker', '15th Street', null, null, 'Queens, New York City, New York', (
        SELECT `id` FROM `customers` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'
    )),
    ('Peter', 'Parker', 'Ingram Street', '20', null, 'Forest Hills, Queens, New York City, New York', (
        SELECT `id` FROM `customers` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'
    ))

UPDATE `customers` SET
    `invoice_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne'),
    `delivery_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne')
WHERE `firstname` = 'Bruce' AND `lastname` = 'Wayne';

UPDATE `customers` SET
    `invoice_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Peter' AND `lastname` = 'Parker'),
    `delivery_address_id` = (SELECT `id` FROM `addresses` WHERE `firstname` = 'Maybelle' AND `lastname` = 'Parker')
WHERE `firstname` = 'Peter' AND `lastname` = 'Parker';

INSERT INTO `orders` (`customer_id`, `delivery_address_id`, `invoice_address_id`, `status`, `created_at`, `updated_at`)
VALUES (1000001,
        (SELECT `delivery_address_id` FROM `customers` WHERE `id` = 1000001),
        (SELECT `invoice_address_id` FROM `customers` WHERE `id` = 1000001),
        'ordered',
        '2021-01-01 00:00:00',
        '2021-01-01 00:00:00'),
        (1000001,
        (SELECT `delivery_address_id` FROM `customers` WHERE `id` = 1000001),
        (SELECT `invoice_address_id` FROM `customers` WHERE `id` = 1000001),
        'shipped',
        '2021-01-01 00:00:00',
        '2021-01-01 00:00:00'),
        (1000002,
        (SELECT `delivery_address_id` FROM `customers` WHERE `id` = 1000002),
        (SELECT `invoice_address_id` FROM `customers` WHERE `id` = 1000002),
        'slicing',
        '2021-01-01 00:00:00',
        '2021-01-01 00:00:00');

INSERT INTO `order_items` (`item_type`, `amount`, `image`, `size_height`, `size_width`, `order_id`)
VALUES  ('poster', 2, '/files/poster_1.jpg', 80, 60, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000001 AND `status` = 'ordered')),
        ('poster', 1, '/files/poster_2.jpg', 80, 60, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000001 AND `status` = 'ordered')),
        ('canvas', 1, '/files/canvas_1.jpg', 80, 80, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000001 AND `status` = 'shipped')),
        ('canvas', 1, '/files/canvas_1.jpg', 80, 80, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing')),
        ('poster', 2, '/files/poster_123.jpg', 20, 20, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing')),
        ('canvas', 3, '/files/canvas_2.jpg', 80, 80, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing'));

INSERT INTO `order_items` (`item_type`, `amount`, `item_category`, `order_id`)
VALUES  ('tape', 4, 'accessory', (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing'));

INSERT INTO `order_items` (`item_type`, `amount`, `item_category`, `size_height`, `size_width`, `order_id`)
VALUES  ('wooden-frame-1', 3, 'frame', 80, 80, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing')),
        ('wooden-frame-2', 2, 'frame', 20, 20, (SELECT `id` FROM `orders` WHERE `customer_id` = 1000002 AND `status` = 'slicing'));