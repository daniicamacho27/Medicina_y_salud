USE medsalud;
INSERT INTO roles (nombre, descripcion)
VALUES ('usuario', 'Usuario registrado sin permisos de administración')
ON DUPLICATE KEY UPDATE descripcion = VALUES(descripcion);
