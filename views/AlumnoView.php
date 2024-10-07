<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perfil de Alumno</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .perfil {
            border: 1px solid #ccc;
            padding: 20px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Perfil de Alumno</h1>
        <div id="perfil-alumno"></div> 
    </div>

    <script>
        $(document).ready(function () {
            
            function getParameterByName(name) {
                const urlParams = new URLSearchParams(window.location.search);
                return urlParams.get(name);
            }

           
            const alumnoId = getParameterByName('alumno_id');

            
            function obtenerPerfil() {
                $.ajax({
                    url: '../controllers/AlumnoController.php?action=buscar&id=' + alumnoId,
                    type: 'GET',
                    dataType: 'json',
                    success: function (data) {
                        $('#perfil-alumno').empty(); 
                        console.log(data); 

                        
                        if (data && data.id) {
                            $('#perfil-alumno').append(
                                '<div class="perfil">' +
                                '<h3>Nombre: ' + data.nombre + '</h3>' +
                                '<p>ID: ' + data.id + '</p>' +
                                '<p>Email: ' + data.email + '</p>' +
                               
                                '</div>'
                            );
                        } else {
                           
                            $('#perfil-alumno').append('<p>No hay datos disponibles para este alumno.</p>');
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la solicitud AJAX:', error);
                        $('#perfil-alumno').append('<p>Error al cargar los datos del alumno.</p>');
                    }
                });
            }


            obtenerPerfil();
        });
    </script>

    <!-- Bootstrap JS (opcional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
