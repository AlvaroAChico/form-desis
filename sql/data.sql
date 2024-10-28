INSERT INTO wineries (winery_name) VALUES 
('Bodega Los Vientos'), 
('Bodega Tierra Fría'), 
('Bodega Sol Naciente'), 
('Bodega Cielo Claro'), 
('Bodega Bosque Verde');

INSERT INTO branches (branch_name, winery_id) VALUES 
('Sucursal Norte', 1), 
('Sucursal Sur', 1), 
('Sucursal Este', 2), 
('Sucursal Oeste', 2), 
('Sucursal Centro', 3),
('Sucursal Playa', 3),
('Sucursal Montaña', 4),
('Sucursal Ciudad', 4),
('Sucursal Valle', 5),
('Sucursal Río', 5);

INSERT INTO currencies (currency_name, currency_symbol) VALUES 
('Peso', '$'), 
('Dólar', 'USD'), 
('Euro', '€'), 
('Yen', '¥'), 
('Lira', '₺');

INSERT INTO materials (material_name) VALUES 
('Plástico'), 
('Metal'), 
('Madera'), 
('Vidrio'), 
('Textil');
