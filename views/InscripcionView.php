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
        <h1>Cursos Matriculados</h1>
        <div id="perfil-alumno"></div>
        <div id="cursos-matriculados" class="row"></div> 
    </div>

    <script>
        $(document).ready(function () {
           
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
                    data: { id: alumnoId }, 
                    success: function (data) {
                        $('#cursos-matriculados').empty(); 
                        if (data.length > 0) {
                            
                            $.each(data, function (index, curso) {
                                $('#cursos-matriculados').append(
                                    '<div class="col-md-4">' +
                                    '<div class="curso">' +
                                    '<h3>' + curso.curso + '</h3>' +
                                    '<p>Matriculados: ' + curso.matriculados + '</p>' +
                                    '<p>Costo: ' + curso.costo + '</p>' +
                                    '<p>Cupo máximo: ' + curso.cupo_maximo + '</p>' +
                                    '</div>' +
                                    '</div>'
                                );
                            });
                        } else {
                            $('#cursos-matriculados').append('<p>No hay cursos matriculados.</p>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

            
            function obtenerPerfil() {
                $.ajax({
                    url: '../controllers/AlumnoController.php?action=buscar&id=' + alumnoId, 
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#perfil-alumno').empty(); 
                        console.log(data); 

                        if (Array.isArray(data) && data.length > 0) { 
                           
                            $.each(data, function (index, alumno) {
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
                    error: function (xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                    }
                });
            }

           
            obtenerPerfil();
            obtenerCursosMatriculados();
        });
    </script>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
