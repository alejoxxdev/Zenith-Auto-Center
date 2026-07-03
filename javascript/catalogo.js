//FILTRO
//VEHICULOS ARREGLO





vehiculos = []  

vehiculosdom = caja_grande.children;

for (vehiculo of vehiculosdom) {
    id = vehiculo.getAttribute("id");
    titulo = vehiculo.querySelector(".titulo").textContent;
    precio = vehiculo.querySelector(".precio").textContent;
    imagen = vehiculo.querySelector("img").src;
    descripcion = vehiculo.querySelector(".descripcion").textContent;
    vehiculos.push({id, titulo, precio, imagen, descripcion});
}



console.log(vehiculos);

function enviarTodosLosVehiculos() {
    console.log(JSON.stringify(vehiculos))
    fetch('enviarbasededatosTEMP.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(vehiculos)
    })
    .then(response => response.json())
    .then(data => {
        console.log('Respuesta del servidor:', data);
    })
    .catch(error => {
        console.error('Error al enviar datos:', error);
    });
}

//enviarTodosLosVehiculos(); // No descomentar esta linea para evitar enviar múltiples veces los datos a la base de datos

function error() {
    console.log("error");
}


const contenedorProductos = document.querySelector("#caja_grande");
const textoBuscar = document.querySelectorAll(".texto_buscar");





//FIN FILTRO

//CARRITO

let carrito = [];

function actualizarTotales() {
    const total = document.querySelector('.total-precio');
    const totalCantidad = document.querySelector('.total-cantidad');
    const totalPrecio = carrito.reduce((acc, articulo) => acc + articulo.precio, 0);
    const cantidadTotal = carrito.reduce((acc, articulo) => acc + articulo.cantidad, 0);

    total.textContent = '$' + totalPrecio;
    totalCantidad.textContent = cantidadTotal;
}

function Añadiralcarrito(boton) {
    const id = boton.id;
    const vehiculo = boton.closest(".carta");
    const titulo = vehiculo.querySelector(".titulo").textContent;
    const precio = parseFloat(vehiculo.querySelector(".precio").textContent.replace(/\./g, '').replace('$', ''));
    const precioUnitario = precio;
    const imagen = vehiculo.querySelector("img").src;

    const articuloExistente = carrito.find(articulo => articulo.id === id);

    if (articuloExistente) {
        articuloExistente.cantidad++;
        articuloExistente.precio = articuloExistente.precioUnitario * articuloExistente.cantidad;
        
        const fila = document.getElementById(id);
        fila.querySelector('.cantidad input').value = articuloExistente.cantidad;
        fila.querySelector('.precio').textContent = `$${articuloExistente.precio}`;
    } else {
        carrito.push({ id, titulo, precioUnitario, precio: precioUnitario, imagen, cantidad: 1});
        const vehiculosañadidos = document.querySelector('.vehiculosañadidos');
        const fila = document.createElement('tr');
        fila.id = id;
        fila.innerHTML = `
            <td>${id}</td>
            <td>${titulo}</td>
            <td><img src="${imagen}" alt="${titulo}" style="width: 200px;"></td>
            <td class="precio_unitario">$${precioUnitario}</td>
            <td class="precio">$${precioUnitario}</td>
            <td class="cantidad"><input type="number" value="1" min="1" onchange="actualizarCantidad(this)"></td>
            <td><button class="eliminar" id="eliminar-${id}" onclick="eliminar(this)"><i class="fas fa-trash"></i></button></td>
        `;
        vehiculosañadidos.appendChild(fila);
    }

    actualizarTotales();
    guardarCarrito();
}

function eliminar(boton) {
    const row = boton.closest('tr');
    const id = row.id;
    carrito = carrito.filter(articulo => articulo.id !== id);
    row.remove();
    
    actualizarTotales();
    guardarCarrito();
}

function actualizarCantidad(input) {
    const fila = input.closest('tr');
    const id = fila.id;
    const articulo = carrito.find(articulo => articulo.id === id);

    if (articulo) {
        const nuevaCantidad = parseInt(input.value);
        articulo.cantidad = nuevaCantidad;
        articulo.precio = articulo.precioUnitario * nuevaCantidad;

        fila.querySelector('.precio').textContent = "$" + articulo.precio;
        
        actualizarTotales();
        guardarCarrito();
    }
}


function vaciarCarrito() {
    carrito = [];
    const vehiculosañadidos = document.querySelector('.vehiculosañadidos');
    vehiculosañadidos.innerHTML = '';
    const total = document.querySelector('.total-precio');
    const totalCantidad = document.querySelector('.total-cantidad');
    total.textContent = '0';
    totalCantidad.textContent = '0';
    guardarCarrito();
}

//vaciarCarrito();

function comprar() {
    if (carrito.length === 0) {
        alert("El carrito está vacío. Agrega productos antes de comprar.");
        return;
    }

    form = document.createElement('form');
    form.method = 'POST';
    form.action = 'factura.php';

    const inputData = document.createElement('input');
    inputData.type = 'hidden';
    inputData.name = 'carrito';
    inputData.value = JSON.stringify(carrito);
    form.appendChild(inputData);

    document.body.appendChild(form);
    form.submit();
}

// Guardar el carrito en localStorage cada vez que se modifica
function guardarCarrito() {
    console.log("Guardando carrito:", carrito);
    localStorage.setItem('carrito', JSON.stringify(carrito));
}


// Recuperar el carrito al cargar la página
function cargarCarrito() {
    const carritoGuardado = localStorage.getItem('carrito');
    if (carritoGuardado) {
        carrito = JSON.parse(carritoGuardado);
        const vehiculosañadidos = document.querySelector('.vehiculosañadidos');
        vehiculosañadidos.innerHTML = '';
        carrito.forEach(articulo => {
            const fila = document.createElement('tr');
            fila.id = articulo.id;
            fila.innerHTML = `
                <td>${articulo.id}</td>
                <td>${articulo.titulo}</td>
                <td><img src="${articulo.imagen}" alt="${articulo.titulo}" style="width: 200px;"></td>
                <td class="precio_unitario">$${articulo.precioUnitario}</td>
                <td class="precio">$${articulo.precio}</td>
                <td class="cantidad"><input type="number" value="${articulo.cantidad}" min="1" onchange="actualizarCantidad(this)"></td>
                <td><button class="eliminar" id="eliminar-${articulo.id}" onclick="eliminar(this)"><i class="fas fa-trash"></i></button></td>
            `;
            vehiculosañadidos.appendChild(fila);
        });
        actualizarTotales();
    }
}

// Llama cargarCarrito al inicio
cargarCarrito();


const botonesEliminar = document.querySelectorAll(".eliminar");



