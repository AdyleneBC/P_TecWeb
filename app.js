// ruta base del backend
const API = "./backend";

$(document).ready(function () {
    let edit = false;

    $('#recurso-result').hide();
    listarRecursos();

    function safeParse(resp) {
        if (typeof resp === "string") {
            try { return JSON.parse(resp); }
            catch (e) { return {}; }
        }
        return resp;
    }

    function listarRecursos() {
        $.ajax({
            url: API + '/products',
            type: 'GET',
            success: function (response) {
                const recursos = safeParse(response) || [];

                if (recursos.length > 0) {
                    let templateAdmin = '';
                    let templateCatalogo = '';

                    recursos.forEach(r => {
                        let descripcionAdmin = '';
                        descripcionAdmin += '<li>autor: ' + (r.autor || 'NA') + '</li>';
                        descripcionAdmin += '<li>depto: ' + (r.departamento || 'NA') + '</li>';
                        descripcionAdmin += '<li>empresa: ' + (r.empresa || 'NA') + '</li>';
                        descripcionAdmin += '<li>tipo: ' + (r.tipo || 'NA') + '</li>';
                        descripcionAdmin += '<li>lenguaje: ' + (r.lenguaje || 'NA') + '</li>';
                        descripcionAdmin += '<li>archivo: ' + (r.archivo || 'NA') + '</li>';

                        templateAdmin += `
                            <tr recursoId="${r.id_recurso || r.id}">
                                <td>${r.id_recurso || r.id}</td>
                                <td><a href="#" class="recurso-item">${r.nombre}</a></td>
                                <td><ul>${descripcionAdmin}</ul></td>
                                <td>
                                  <button class="recurso-delete btn btn-danger">Eliminar</button>
                                </td>
                            </tr>
                        `;

                        let icono = iconoPorTipo(r.tipo);
                        templateCatalogo += `
                            <tr>
                                <td>${r.id_recurso || r.id}</td>
                                <td>${r.nombre}</td>
                                <td>${r.tipo || ''}</td>
                                <td>${r.lenguaje || ''}</td>
                                <td>${r.descripcion || ''}</td>
                                <td>
                                  <a href="${API}/download/${r.id_recurso || r.id}" target="_blank">
                                    <img src="${icono}" width="30">
                                  </a>
                                </td>
                            </tr>
                        `;
                    });

                    $('#recursos-admin').html(templateAdmin);
                    $('#recursos-catalogo').html(templateCatalogo);
                } else {
                    $('#recursos-admin').html('');
                    $('#recursos-catalogo').html('');
                }
            }
        });
    }

    function iconoPorTipo(tipo) {
        tipo = (tipo || '').toLowerCase();
        if (tipo === 'pdf') return './assets/icons/pdf.png';
        if (tipo === 'zip') return './assets/icons/zip.png';
        if (tipo === 'jar') return './assets/icons/jar.png';
        if (tipo === 'exe') return './assets/icons/exe.png';
        if (tipo === 'json') return './assets/icons/json.png';
        if (tipo === 'xml') return './assets/icons/xml.png';
        return './assets/icons/default.png';
    }

    // BUSCADOR
    $('#search').keyup(function () {
        if ($('#search').val()) {
            let search = $('#search').val();

            $.ajax({
                url: API + '/products/' + search,
                type: 'GET',
                success: function (response) {
                    const recursos = safeParse(response) || [];

                    if (recursos.length > 0) {
                        let templateAdmin = '';
                        let templateCatalogo = '';
                        let template_bar = '';

                        recursos.forEach(r => {
                            let descripcionAdmin = '';
                            descripcionAdmin += '<li>autor: ' + (r.autor || 'NA') + '</li>';
                            descripcionAdmin += '<li>depto: ' + (r.departamento || 'NA') + '</li>';
                            descripcionAdmin += '<li>empresa: ' + (r.empresa || 'NA') + '</li>';
                            descripcionAdmin += '<li>tipo: ' + (r.tipo || 'NA') + '</li>';
                            descripcionAdmin += '<li>lenguaje: ' + (r.lenguaje || 'NA') + '</li>';
                            descripcionAdmin += '<li>archivo: ' + (r.archivo || 'NA') + '</li>';

                            templateAdmin += `
                                <tr recursoId="${r.id_recurso || r.id}">
                                    <td>${r.id_recurso || r.id}</td>
                                    <td><a href="#" class="recurso-item">${r.nombre}</a></td>
                                    <td><ul>${descripcionAdmin}</ul></td>
                                    <td>
                                        <button class="recurso-delete btn btn-danger">Eliminar</button>
                                    </td>
                                </tr>
                            `;

                            let icono = iconoPorTipo(r.tipo);
                            templateCatalogo += `
                                <tr>
                                    <td>${r.id_recurso || r.id}</td>
                                    <td>${r.nombre}</td>
                                    <td>${r.tipo || ''}</td>
                                    <td>${r.lenguaje || ''}</td>
                                    <td>${r.descripcion || ''}</td>
                                    <td>
                                      <a href="${API}/download/${r.id_recurso || r.id}" target="_blank">
                                        <img src="${icono}" width="30">
                                      </a>
                                    </td>
                                </tr>
                            `;

                            template_bar += `<li>${r.nombre}</li>`;
                        });

                        $('#recurso-result').show();
                        $('#container').html(template_bar);
                        $('#recursos-admin').html(templateAdmin);
                        $('#recursos-catalogo').html(templateCatalogo);
                    }
                }
            });

        } else {
            $('#recurso-result').hide();
            listarRecursos();
        }
    });

    //////////////////////////VALIDACIÓN
    function setError($el, msg) {
        $el.addClass('is-invalid');
        $el.next('.invalid-feedback').text(msg).show();
    }

    function clearError($el) {
        $el.removeClass('is-invalid');
        $el.next('.invalid-feedback').text('').hide();
    }

    // -------- VALIDACIONES BLUR --------

    $('#nombre').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 100) {
            setError($(this), 'Nombre obligatorio (máx 100).');
        } else {
            clearError($(this));
        }
    });

    $('#autor').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 150) {
            setError($(this), 'Autor obligatorio (máx 150).');
        } else {
            clearError($(this));
        }
    });

    $('#departamento').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 150) {
            setError($(this), 'Departamento obligatorio (máx 150).');
        } else {
            clearError($(this));
        }
    });

    $('#empresa').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 150) {
            setError($(this), 'Empresa obligatoria (máx 150).');
        } else {
            clearError($(this));
        }
    });

    $('#descripcion').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 250) {
            setError($(this), 'Descripción obligatoria (máx 250).');
        } else {
            clearError($(this));
        }
    });

    $('#tipo').blur(function () {
        const v = $(this).val().trim();
        if (v === '') {
            setError($(this), 'Tipo obligatorio.');
        } else {
            clearError($(this));
        }
    });

    $('#lenguaje').blur(function () {
        const v = $(this).val().trim();
        if (v === '' || v.length > 50) {
            setError($(this), 'Lenguaje obligatorio (máx 50).');
        } else {
            clearError($(this));
        }
    });

    $('#fecha_creacion').blur(function () {
        const v = $(this).val().trim();
        if (v === '') {
            setError($(this), 'Fecha obligatoria.');
        } else {
            clearError($(this));
        }
    });

    $('#archivo').blur(function () {
        const f = $(this)[0].files[0];
        if (!edit && !f) {
            setError($(this), 'Documento obligatorio.');
        } else {
            clearError($(this));
        }
    });

    // -------- FIN VALIDACIONES BLUR --------


    //////////////////////////VALIDACIÓN

    // SUBMIT FORM (tu misma lógica)
    $('#recurso-form').submit(e => {
        e.preventDefault();

        let errores = [];
        const nombre = $('#nombre').val().trim();
        const descripcion = $('#descripcion').val().trim();
        const archivoFile = $('#archivo')[0].files[0];

        if (nombre === '' || nombre.length > 100)
            errores.push('->El nombre es obligatorio');

        if (descripcion.length > 250)
            errores.push('->Descripción menor a 250 caracteres.');

        if (!edit && !archivoFile)
            errores.push('->Selecciona un archivo.');

        if (errores.length > 0) {
            // solo marcamos inputs en rojo, sin barra
            $('#nombre').blur();
            $('#autor').blur();
            $('#departamento').blur();
            $('#empresa').blur();
            $('#fecha_creacion').blur();
            $('#descripcion').blur();
            $('#tipo').blur();
            $('#lenguaje').blur();
            $('#archivo').blur();
            return;
        }


        let formData = new FormData();
        formData.append('nombre', $('#nombre').val());
        formData.append('autor', $('#autor').val());
        formData.append('departamento', $('#departamento').val());
        formData.append('empresa', $('#empresa').val());
        formData.append('fecha_creacion', $('#fecha_creacion').val());
        formData.append('descripcion', $('#descripcion').val());
        formData.append('tipo', $('#tipo').val());
        formData.append('lenguaje', $('#lenguaje').val());

        if (archivoFile) formData.append('archivo', archivoFile);
        formData.append('id', $('#recursoId').val());

        const url = API + '/product';

        if (!edit) {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let respuesta = safeParse(response);

                    $('#nombre, #autor, #departamento, #empresa, #fecha_creacion, #descripcion, #tipo, #lenguaje').val('');
                    $('#archivo').val('');
                    $('#recursoId').val('');

                    $('#recurso-result').show();
                    $('#container').html(`
                      <li style="list-style:none;">status: ${respuesta.status}</li>
                      <li style="list-style:none;">message: ${respuesta.message}</li>
                    `);

                    listarRecursos();
                    edit = false;
                    $('button.btn-primary').text('Agregar Recurso');
                }
            });
        } else {
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: { "X-HTTP-Method-Override": "PUT" },
                success: function (response) {
                    let respuesta = safeParse(response);

                    $('#nombre, #autor, #departamento, #empresa, #fecha_creacion, #descripcion, #tipo, #lenguaje').val('');
                    $('#archivo').val('');
                    $('#recursoId').val('');

                    $('#recurso-result').show();
                    $('#container').html(`
                      <li style="list-style:none;">status: ${respuesta.status}</li>
                      <li style="list-style:none;">message: ${respuesta.message}</li>
                    `);

                    listarRecursos();
                    edit = false;
                    $('button.btn-primary').text('Agregar Recurso');
                }
            });
        }
    });

    // ELIMINAR (ya adentro del ready)
    $(document).on('click', '.recurso-delete', function () {
        if (confirm('¿Realmente deseas eliminar el recurso?')) {
            const $row = $(this).closest('tr');
            const id = $row.attr('recursoId');

            $.ajax({
                url: API + '/product',
                type: 'DELETE',
                data: { id },
                success: function () {
                    $('#recurso-result').hide();
                    listarRecursos();
                }
            });
        }
    });

    // EDITAR (ya adentro del ready)
    $(document).on('click', '.recurso-item', function (e) {
        e.preventDefault();

        const $row = $(e.target).closest('tr');
        const id = $row.attr('recursoId');

        $.ajax({
            url: API + '/product/' + id,
            type: 'GET',
            success: function (response) {
                let data = safeParse(response);
                const r = Array.isArray(data) ? (data[0] || {}) : data;

                $('#nombre').val(r.nombre || '');
                $('#recursoId').val(r.id_recurso || r.id || '');
                $('#autor').val(r.autor || '');
                $('#departamento').val(r.departamento || '');
                $('#empresa').val(r.empresa || '');
                $('#fecha_creacion').val(r.fecha_creacion || '');
                $('#descripcion').val(r.descripcion || '');
                $('#tipo').val(r.tipo || '');
                $('#lenguaje').val(r.lenguaje || '');

                edit = true;
                $('button.btn-primary').text('Modificar Recurso');
            }
        });
    });

});

// ====== DASHBOARD ======********************************************************************

function cargarDashboard() {
    graficaTipo();
    graficaLenguaje();
    graficaDia();
}

function graficaTipo() {
    $.get(API + "/stats/tipo", function (resp) {
        let labels = [];
        let data = [];

        resp.forEach(x => {
            labels.push(x.tipo || "NA");
            data.push(x.total);
        });

        new Chart(document.getElementById("chartTipo"), {
            type: "bar",
            data: {
                labels: labels,
                datasets: [{
                    label: "Descargas",
                    data: data
                }]
            }
        });
    });
}

function graficaLenguaje() {
    $.get(API + "/stats/lenguaje", function (resp) {
        let labels = [];
        let data = [];

        resp.forEach(x => {
            labels.push(x.lenguaje || "NA");
            data.push(x.total);
        });

        new Chart(document.getElementById("chartLenguaje"), {
            type: "pie",
            data: {
                labels: labels,
                datasets: [{
                    label: "Descargas",
                    data: data
                }]
            }
        });
    });
}

function graficaDia() {
    $.get(API + "/stats/dia", function (resp) {
        let labels = [];
        let data = [];

        resp.forEach(x => {
            labels.push(x.dia);
            data.push(x.total);
        });

        new Chart(document.getElementById("chartDia"), {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: "Descargas",
                    data: data
                }]
            }
        });
    });
}

// cuando abras el tab dashboard, carga gráficas
$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    if ($(e.target).attr("href") === "#dashboard") {
        cargarDashboard();
    }
});
// ====== DASHBOARD ======********************************************************************
