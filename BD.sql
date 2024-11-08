-- Created by Vertabelo (http://vertabelo.com)
-- Last modification date: 2024-11-08 14:11:42.987

-- tables
-- Table: Categoria
CREATE TABLE Categoria (
    idCategoria int  NOT NULL,
    Categoria char(100)  NOT NULL,
    CONSTRAINT Categoria_pk PRIMARY KEY (idCategoria)
);

-- Table: Cliente
CREATE TABLE Cliente (
    IdPersona int  NOT NULL,
    Nombre char(100)  NOT NULL,
    Telefono int  NOT NULL,
    Mail varchar(100)  NOT NULL,
    Trabajador boolean  NOT NULL,
    Administrador boolean  NOT NULL,
    Pass varchar(100)  NOT NULL,
    CONSTRAINT Cliente_pk PRIMARY KEY (IdPersona)
);

-- Table: Descuentos
CREATE TABLE Descuentos (
    IdDescuentos int  NOT NULL,
    Descuento char(100)  NOT NULL,
    Porcentaje int  NOT NULL,
    FechaInicio date  NOT NULL,
    FechaFin date  NOT NULL,
    CONSTRAINT Descuentos_pk PRIMARY KEY (IdDescuentos)
);

-- Table: Pedido
CREATE TABLE Pedido (
    IdPedido int  NOT NULL,
    FechaPedido date  NOT NULL,
    FechaEntrega date  NOT NULL,
    PrecioTotal int  NOT NULL,
    HoraPedido time  NOT NULL,
    HoraEntrega time  NOT NULL,
    Cliente_IdPersona int  NOT NULL,
    Descuentos_IdDescuentos int  NOT NULL,
    Reporte_idReporte int  NOT NULL,
    CONSTRAINT Pedido_pk PRIMARY KEY (IdPedido)
);

-- Table: PedidoProducto
CREATE TABLE PedidoProducto (
    idPedidoProducto int  NOT NULL,
    Cantidad int  NOT NULL,
    PrecioPP int  NOT NULL,
    Pedido_IdPedido int  NOT NULL,
    Producto_idProducto int  NOT NULL,
    CONSTRAINT PedidoProducto_pk PRIMARY KEY (idPedidoProducto)
);

-- Table: Producto
CREATE TABLE Producto (
    idProducto int  NOT NULL,
    Producto char(100)  NOT NULL,
    Precio int  NOT NULL,
    Descripcion varchar(1000)  NOT NULL,
    Disponibilidad int  NOT NULL,
    Categoria_idCategoria int  NOT NULL,
    CONSTRAINT Producto_pk PRIMARY KEY (idProducto)
);

-- Table: Reporte
CREATE TABLE Reporte (
    idReporte int  NOT NULL,
    Fecha date  NOT NULL,
    Descripcion varchar(100)  NOT NULL,
    VentaTotal int  NOT NULL,
    GananciaTotal float NOT NULL,
    CONSTRAINT Reporte_pk PRIMARY KEY (idReporte)
);

ALTER TABLE Pedido
ADD CONSTRAINT fk_Pedido_Cliente FOREIGN KEY (Cliente_IdPersona) REFERENCES Cliente(IdPersona),
ADD CONSTRAINT fk_Pedido_Descuentos FOREIGN KEY (Descuentos_IdDescuentos) REFERENCES Descuentos(IdDescuentos),
ADD CONSTRAINT fk_Pedido_Reporte FOREIGN KEY (Reporte_idReporte) REFERENCES Reporte(idReporte);

ALTER TABLE PedidoProducto
ADD CONSTRAINT fk_PedidoProducto_Pedido FOREIGN KEY (Pedido_IdPedido) REFERENCES Pedido(IdPedido),
ADD CONSTRAINT fk_PedidoProducto_Producto FOREIGN KEY (Producto_idProducto) REFERENCES Producto(idProducto);

ALTER TABLE Producto
ADD CONSTRAINT fk_Producto_Categoria FOREIGN KEY (Categoria_idCategoria) REFERENCES Categoria(idCategoria);

-- End of file.
