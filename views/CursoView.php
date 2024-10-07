<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cursos Matriculados</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
       
        #menu {
            height: 100vh;
            background-color: #f8f9fa;
            padding: 15px;
            position: fixed;
            width: 200px;
        }

        #inscripciones {
            margin-top: 20px;
            margin-left: 220px;
           
        }

        .curso {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f1f1f1;
            transition: transform 0.2s;
            
        }

        .curso:hover {
            transform: scale(1.05);
           
        }

        
        .row {
            display: flex;
            flex-wrap: wrap;
        }

        .col-md-4 {
            flex: 1 1 30%;
           
            margin-bottom: 20px;
           
        }

        .perfil {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px 0;
            border-radius: 5px;
            color: white;
        }

        .id {
            background-color: #007bff;
           
        }

        .nombre {
            background-color: #28a745;
            
        }

        .email {
            background-color: #dc3545;
            
        }
    </style>
</head>

<body>
    <div id="menu">
        <h2>Menú</h2>
        <ul class="list-unstyled">
            <li><a href="#" id="perfil-alumno-link">Perfil de Alumno</a></li>
            <li><a href="#" id="perfil-inscripciones-link">Cursos Matriculados</a></li>
            
        </ul>
    </div>

    <div id="inscripciones">
        <h1>Cursos Disponibles</h1>
        <div id="perfil-alumno"></div> 
        <div id="cursos-matriculados" class="row"></div>
    </div>


    <div class="modal fade" id="modalPago" tabindex="-1" role="dialog" aria-labelledby="modalPagoLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalPagoLabel">Pasarela de Pago</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>¿Deseas inscribirte en <span id="curso-modal-nombre"></span> por <span id="curso-modal-costo"></span>?</p>

                    <div class="form-group">
                        <label for="tipoTarjeta">Tipo de Tarjeta:</label>
                        <select id="tipoTarjeta" class="form-control">
                            <option value="credito">Tarjeta de Crédito</option>
                            <option value="debito">Tarjeta de Débito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="numeroTarjeta">Número de Tarjeta:</label>
                        <input type="text" class="form-control" id="numeroTarjeta" placeholder="Número de tarjeta" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fechaExpiracion">Fecha de Expiración:</label>
                            <input type="month" class="form-control" id="fechaExpiracion" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cvv">CVV:</label>
                            <input type="text" class="form-control" id="cvv" placeholder="CVV" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" id="btn-pagar">Pagar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            function getParameterByName(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }


            const alumnoId = getParameterByName('alumno_id');


            $('#perfil-alumno-link').attr('href', '../views/AlumnoView.php?alumno_id=' + alumnoId);
            $('#perfil-inscripciones-link').attr('href', '../views/InscripcionView.php?alumno_id=' + alumnoId);

  
            function obtenerCursosMatriculados() {
                $.ajax({
                    url: '../controllers/CursoController.php?action=matriculados', 
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        alumno_id: alumnoId
                    }, 
                    success: function(data) {
                        $('#cursos-matriculados').empty(); 
                        if (data.length > 0) {
                           
                            $.each(data, function(index, curso) {
                                $('#cursos-matriculados').append(
                                    '<div class="col-md-4">' +
                                    '<div class="curso">' +
                                    '<h3>' + curso.curso + '</h3>' +
                                    '<p>Matriculados: ' + curso.matriculados + '</p>' +
                                    '<p>Costo: ' + curso.costo + '</p>' +
                                    '<p>Cupo máximo: ' + curso.cupo_maximo + '</p>' +
                                    '<button class="btn btn-primary inscribirse" data-id="' + curso.id + '">Inscribirse</button>' +
                                    '</div>' +
                                    '</div>'
                                );
                            });
                        } else {
                            $('#cursos-matriculados').append('<p>No hay cursos matriculados.</p>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

           
            function obtenerPerfil() {
                $.ajax({
                    url: '../controllers/AlumnoController.php?action=buscar&id=' + alumnoId, 
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#perfil-alumno').empty(); 
                        console.log(data); 

                        if (Array.isArray(data) && data.length > 0) { 
                            
                            $.each(data, function(index, alumno) {
                                $('#perfil-alumno').append(
                                    '<div class="perfil id">ID: ' + alumno.id + '</div>' +
                                    '<div class="perfil nombre">Nombre: ' + alumno.nombre + '</div>' +
                                    '<div class="perfil email">Email: ' + alumno.email + '</div>'
                                ); 
                            });
                        } else {
                            
                            console.log('No hay alumnos disponibles.');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

            
            let cursoId; 

            $(document).on('click', '.inscribirse', function() {
                cursoId = $(this).data('id'); 
                const cursoNombre = $(this).siblings('h3').text();
                const cursoCosto = $(this).siblings('p').eq(1).text(); 

                $('#curso-modal-nombre').text(cursoNombre);
                $('#curso-modal-costo').text(cursoCosto);
                $('#modalPago').modal('show'); 
            });

  
            $('#btn-pagar').on('click', function() {
                const numeroTarjeta = $('#numeroTarjeta').val();
                const fechaExpiracion = $('#fechaExpiracion').val();
                const cvv = $('#cvv').val();

               

                
                $.ajax({
                    url: '../controllers/InscripcionController.php', 
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        alumno_id: alumnoId, 
                        curso_id: cursoId, 

                    },
                    success: function(response) {
                       
                        alert('Inscripción realizada con éxito!');
                        $('#modalPago').modal('hide');
                        obtenerCursosMatriculados();

                    },
                    error: function(xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);

                       
                        try {
                            const jsonResponse = JSON.parse(xhr.responseText);
                            alert(jsonResponse.error || 'Ha ocurrido un error.');
                        } catch (e) {
                            alert('Ha ocurrido un error desconocido.');
                        }
                    }
                });
            });


            obtenerPerfil();
            obtenerCursosMatriculados();
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>