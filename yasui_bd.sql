CREATE DATABASE yasui;
use yasui;

CREATE TABLE marca(
	cve_marca INT auto_increment,
	nom_marca CHAR(25),
	PRIMARY KEY(cve_marca),
	UNIQUE INDEX(nom_marca)
);

CREATE TABLE tipo(
	cve_tipo INT auto_increment,
	nom_tipo CHAR(25),
	PRIMARY KEY(cve_tipo),
	UNIQUE INDEX(nom_tipo)
);

CREATE TABLE prenda(
	id_pren INT auto_increment,
	cve_marca INT,
	cve_tipo INT,
	nom_pren CHAR(50),
	tall_pren ENUM('XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'),
	prec_pren DEC(6,2),
	cto_pren DEC(6,2),
	desc_pren VARCHAR(700),
	status_pren BOOLEAN,
	img_pren VARCHAR(50),
	PRIMARY KEY(id_pren),
	FOREIGN KEY(cve_marca) REFERENCES marca(cve_marca),
	FOREIGN KEY(cve_tipo) REFERENCES tipo(cve_tipo)
);

CREATE TABLE usuario(
	nom_us CHAR(20),
	pass_us BLOB,
	tipo_us BOOLEAN,
	status_us BOOLEAN,
	PRIMARY KEY(nom_us)
);

CREATE TABLE estado(
	cve_est INT auto_increment,
	nom_est CHAR(50),
	PRIMARY KEY(cve_est)
);

CREATE TABLE municipio(
	cve_mun INT auto_increment,
	cve_est INT,
	nom_mun CHAR(50),
	PRIMARY KEY(cve_mun),
	FOREIGN KEY(cve_est) REFERENCES estado(cve_est)
);

CREATE TABLE cliente(
    no_clie INT auto_increment,
    nom_us CHAR(20),
    cve_mun INT,
    n1_clie CHAR(25),
    ap_clie CHAR(25),
    am_clie CHAR(25),
    tel_clie VARCHAR(13),
    email_clie CHAR(50),
    col_clie CHAR(50),
    call_clie CHAR(50),
    ne_clie VARCHAR(5),
    ni_clie VARCHAR(5),
    cp_clie VARCHAR(5),
    rfc_clie CHAR(13),
	razs_clie CHAR(50), 
	regf_clie CHAR(50),
	cfdi_clie CHAR(50),
    tar_clie char(25),
    PRIMARY KEY(no_clie),
    FOREIGN KEY(nom_us) REFERENCES usuario(nom_us) ON DELETE RESTRICT ON UPDATE CASCADE,
    FOREIGN KEY(cve_mun) REFERENCES municipio(cve_mun),
	UNIQUE INDEX(email_clie),
	UNIQUE INDEX(nom_us)
);

CREATE TABLE venta(
	no_vta INT auto_increment,
	no_clie INT NOT NULL,
	fec_vta DATE,
	PRIMARY KEY(no_vta),
	FOREIGN key(no_clie) REFERENCES cliente(no_clie)
);

CREATE TABLE pago(
    id_pago INT auto_increment,
	no_vta INT,
	imp_pago DEC(10,2),
    fec_pago DATE, 
    tipo_pago ENUM('debito', 'credito', 'paypal'),
    PRIMARY KEY (id_pago),
    FOREIGN KEY(no_vta) REFERENCES venta(no_vta)
);

CREATE TABLE factura(
	folio_fac INT auto_increment,
	no_vta INT,
	fec_fac DATE,
	PRIMARY KEY(folio_fac),
	FOREIGN key(no_vta) REFERENCES venta(no_vta) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE sucursal(
	cod_suc INT auto_increment,
	cve_mun INT,
	nom_suc CHAR(50),
	col_suc CHAR(50),
	call_suc CHAR(50),
	ne_suc VARCHAR(5),
	ni_suc VARCHAR(5),
	cp_suc VARCHAR(5),
	status_suc BOOLEAN,
	PRIMARY KEY(cod_suc),
	FOREIGN KEY(cve_mun) REFERENCES municipio(cve_mun)
);

CREATE TABLE inventario(
	cve_inv INT auto_increment,
	cod_suc INT,
	id_pren INT,
	exist_pren INT(5),
	status_inv BOOLEAN,
	PRIMARY KEY(cve_inv),
	FOREIGN KEY(cod_suc) REFERENCES sucursal(cod_suc),
	FOREIGN KEY(id_pren) REFERENCES prenda(id_pren) ON DELETE RESTRICT ON UPDATE CASCADE
);

CREATE TABLE ven_inv(
	no_vta INT,
	cve_inv INT,
	cant_prend INT(5),
	FOREIGN KEY(no_vta) REFERENCES venta(no_vta),
	FOREIGN KEY(cve_inv) REFERENCES inventario(cve_inv)
);




-- TRIGGERS
DELIMITER //
CREATE TRIGGER password_encryption_insert
BEFORE INSERT ON usuario
FOR EACH ROW
BEGIN
SET new.pass_us = aes_encrypt(new.pass_us, "pichula");
END //


CREATE TRIGGER password_encryption_update
BEFORE UPDATE ON usuario
FOR EACH ROW
BEGIN
    IF NEW.pass_us <> OLD.pass_us THEN
        SET NEW.pass_us = AES_ENCRYPT(NEW.pass_us, 'pichula');
    END IF;
END //


CREATE TRIGGER actualiza_existencia
AFTER INSERT ON ven_inv
FOR EACH ROW
BEGIN
update inventario set exist_pren = exist_pren - new.cant_prend WHERE cve_inv=new.cve_inv;
END //


CREATE TRIGGER precio_automatico_insert
BEFORE INSERT ON prenda
FOR EACH ROW
BEGIN
SET NEW.prec_pren = (NEW.cto_pren*1.5)+((NEW.cto_pren*1.5)*0.16);
END //


CREATE TRIGGER precio_automatico_update
BEFORE UPDATE ON prenda
FOR EACH ROW
BEGIN
SET NEW.prec_pren = (NEW.cto_pren*1.5)+((NEW.cto_pren*1.5)*0.16);
END //


CREATE TRIGGER status_inventario_segun_sucursal
AFTER UPDATE ON sucursal
FOR EACH ROW
BEGIN
	IF NEW.status_suc = 0 THEN
	UPDATE inventario SET status_inv = 0 WHERE cod_suc = NEW.cod_suc;
	ELSEIF NEW.status_suc = 1 THEN
	UPDATE inventario SET status_inv = 1 WHERE cod_suc = NEW.cod_suc;
	END IF;
END //


CREATE TRIGGER evita_habilitar_inventario
BEFORE UPDATE ON inventario
FOR EACH ROW
BEGIN
    DECLARE status_sucursal BOOLEAN;

    -- status_suc de la sucursal correspondiente
    SELECT status_suc INTO status_sucursal 
    FROM sucursal 
    WHERE cod_suc = NEW.cod_suc;

    -- si status_suc es 0 y el nuevo valor de status_inv es 1
    IF status_sucursal = 0 AND NEW.status_inv = 1 THEN
        -- Establecer status_inv a 0 en lugar de 1
        SET NEW.status_inv = 0;
    END IF;
END //
DELIMITER ;




-- REGISTROS
INSERT INTO marca (nom_marca) VALUES
("Gap"),
("Urban Outfitters");

INSERT INTO tipo (nom_tipo) VALUES
("camiseta"),
("pantalón"),
("vestido"),
("sudadera"),
("chaqueta");

INSERT INTO prenda (cve_marca, cve_tipo, nom_pren, tall_pren, cto_pren, desc_pren, status_pren, img_pren) VALUES
(1, 1, 'Camiseta Algodón Blanca',   	'M', 		'210.00', 	"Descripción de prenda 1" 	, 1,	'assets/img/prenda1.jpg'),
(1, 2, 'Pantalón Vaquero Azul',     	'XL', 		'315.00', 	"Descripción de prenda 2" 	, 1,	'assets/img/prenda2.jpg'),
(1, 1, 'Camiseta Algodón Negra',    	'S', 		'229.00', 	"Descripción de prenda 3" 	, 1,	'assets/img/prenda3.jpg'),
(1, 4, 'Sudadera con Capucha Gris', 	'L', 		'425.00', 	"Descripción de prenda 4" 	, 1,	'assets/img/prenda4.jpg'),
(1, 3, 'Vestido Floral', 				'M', 		'520.00', 	"Descripción de prenda 5" 	, 1,	'assets/img/prenda5.jpg'),
(2, 5, 'Chaqueta de Cuero Marrón',  	'XXXL',		'340.00', 	"Descripción de prenda 6" 	, 1,	'assets/img/prenda6.jpg'),
(2, 3, 'Vestido Rojo con Lunares',  	'XS', 		'421.00', 	"Descripción de prenda 7" 	, 1,	'assets/img/prenda7.jpg'),
(2, 5, 'Chaqueta de Cuero Negra',   	'XXL',  	'337.00', 	"Descripción de prenda 8" 	, 1,	'assets/img/prenda8.jpg'),
(2, 4, 'Sudadera con Capucha Negra', 	'M', 		'127.00', 	"Descripción de prenda 9" 	, 1,	'assets/img/prenda9.jpg'),
(2, 2, 'Pantalón Vaquero Gris', 		'XS', 		'114.00',	"Descripción de prenda 10" 	, 1,	'assets/img/prenda10.jpg');


INSERT INTO usuario (nom_us, pass_us, tipo_us, status_us) VALUES
("admin_qro",       "Jackerpro11",  0,  1),
("admin_dgl",       "Adm1n_P@ssw0rd_2023", 0,  1),
("admin_mty",       "Secur1ty@Adm!n#23",   0,  1),
("alex_loz11",      "Jackerpro11",         1,  1),
("angel_gabanna23", "chivas14",            1,  1),
("huguin69",        "vivaelamerica",       1,  1),
("brand0n12",       "monaschinasUWU",      1,  1),
("marc0s15",        "vivaAMLO",            1,  1);

INSERT INTO estado (nom_est) VALUES
("Aguascalientes"),
("Baja California"),
("Baja California Sur"),
("Campeche"),
("Chiapas"),
("Chihuahua"),
("Ciudad de México"),
("Coahuila"),
("Colima"),
("Durango"),
("Estado de México"),
("Guanajuato"),
("Guerrero"),
("Hidalgo"),
("Jalisco"),
("Michoacán"),
("Morelos"),
("Nayarit"),
("Nuevo León"),
("Oaxaca"),
("Puebla"),
("Querétaro"),
("Quintana Roo"),
("San Luis Potosí"),
("Sinaloa"),
("Sonora"),
("Tabasco"),
("Tamaulipas"),
("Tlaxcala"),
("Veracruz"),
("Yucatán"),
("Zacatecas");

INSERT INTO municipio (cve_est, nom_mun) VALUES
(22, "Santiago de Querétaro"),
(22, "Corregidora"),
(22, "Tequisquiapan"),
(15, "Guadalajara"),
(15, "Zapopan"),
(15, "Tonalá"),
(19, "Monterrey"),
(19, "Guadalupe"),
(19, "Escobedo");

INSERT INTO cliente (nom_us, cve_mun, n1_clie, ap_clie, am_clie, tel_clie, email_clie, col_clie, call_clie, ne_clie, ni_clie, cp_clie, rfc_clie, tar_clie) VALUES
("alex_loz11",      1, "alexis",  "lozada",  "salinas",   "4425831018", "alexislozadasalinas11@gmail.com",   "lomas de san pedrito peñuelas", "calle de las flores",    "501", "22", "76148", "losa901210129", "4929640800001508"),
("angel_gabanna23", 9, "ángel",   "gabanna", "hernández", "5532178945", "angelgabannahernandez23@gmail.com", "residencial del bosque",        "avenida de los pájaros", "312", "5",  "53100", "aghh951212289", "4929640800001144"),
("huguin69",        7, "hugo",    "garcía",  "lópez",     "6623547890", "hugogarcialopez69@gmail.com",       "villa de las palmas",           "calle de los robles",    "120", "9",  "83200", "hglo700423109", "4929640800001888"),
("brand0n12",       3, "brandon", "gómez",   "sánchez",   "8112345678", "brandongomezsanchez12@gmail.com",   "colinas del sol",               "calle de los pinos",     "450", "15", "64018", "bgos981015216", "4929640800002274"),
("marc0s15",        5, "marcos",  "pérez",   "rodríguez", "4777894563", "marcosperezrodriguez15@gmail.com",  "bosques de la ciudad",          "avenida de los cedros",  "32",  "10", "37000", "mprr880730189", "4929640800001573");

INSERT INTO sucursal (cve_mun, nom_suc, col_suc, call_suc, ne_Suc, ni_suc, cp_suc, status_suc) VALUES
(1, "Yasui Queretaro",   "el vergel", "av. montesacro", 334, 23, 76148, 1),
(4, "Yasui Guadalajara", "1 de mayo", "luis jóse",      543, 54, 34224, 1),
(7, "Yasui Monterrey",   "reforma",   "c. magnolia",    723, 76, 74632, 1);

INSERT INTO venta (no_clie, fec_vta) VALUES
(1,  "2022-02-15"),
(1,  "2022-05-07"),
(2,  "2022-08-23"),
(2,  "2022-11-12"),
(3,  "2023-01-03"),
(3,  "2023-03-18"),
(4,  "2023-06-09"),
(4,  "2023-09-24"),
(5,  "2023-10-01"),
(5,  "2023-10-03");

INSERT INTO pago (no_vta, fec_pago, tipo_pago) VALUES
(1,  '2022-02-15', 'debito'),
(2,  '2022-05-07', 'debito'),
(3,  '2022-08-23', 'credito'),
(4,  '2022-11-12', 'credito'),
(5,  '2023-01-03', 'credito'),
(6,  '2023-03-18', 'credito'),
(7,  '2023-06-09', 'debito'),
(8,  '2023-09-24', 'debito'),
(9,  '2023-10-01', 'debito'),
(10, '2023-10-03', 'credito');

INSERT INTO factura (no_vta, fec_fac) VALUES
(1,  "2022-02-15"),
(2,  "2022-05-07"),
(3,  "2022-08-23"),
(4,  "2022-11-12"),
(5,  "2023-01-03"),
(6,  "2023-03-18"),
(7,  "2023-06-09"),
(8,  "2023-09-24"),
(9,  "2023-10-01"),
(10, "2023-10-03");

INSERT INTO inventario (cod_suc, id_pren, exist_pren, status_inv) VALUES
(1,  1,  23,  1),
(1,  2,  43,  1),
(1,  3,  43,  1),
(1,  4,  22,  1),
(1,  5,  34,  1),
(1,  6,  34,  1),
(1,  7,  54,  1),
(1,  8,  32,  1),
(1,  9,  76,  1),
(1,  10, 44,  1),
(2,  1,  34,  1),
(2,  2,  64,  1),
(2,  3,  34,  1),
(2,  4,  43,  1),
(2,  5,  65,  1),
(2,  6,  34,  1),
(2,  7,  65,  1),
(2,  8,  44,  1),
(2,  9,  65,  1),
(2,  10, 34,  1),
(3,  1,  76,  1),
(3,  2,  43,  1),
(3,  3,  46,  1),
(3,  4,  54,  1),
(3,  5,  43,  1),
(3,  6,  65,  1),
(3,  7,  76,  1),
(3,  8,  86,  1),
(3,  9,  45,  1),
(3,  10, 54,  1);

INSERT INTO ven_inv (no_vta, cve_inv, cant_prend) VALUES
(1,  2,  2),
(1,  4,  4),
(2,  6,  3),
(2,  8,  2),
(3,  9,  4),
(3,  10, 3),
(4,  12, 5),
(4,  14, 2),
(5,  16, 6),
(5,  18, 4),
(6,  20, 3),
(6,  22, 5),
(7,  24, 3),
(7,  26, 1),
(8,  28, 1),
(8,  3,  2),
(9,  5,  5),
(9,  7,  7),
(10, 11, 8),
(10, 13, 1);