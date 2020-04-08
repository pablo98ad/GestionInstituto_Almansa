## Visualizacion de la pantalla principal 
<p align="center"><img src="https://i.gyazo.com/91d9852882d86bf825e164b0ee67b35f.png"></p>

## Sobre Gestion Escultor

GestionEscultor es una aplicacion web pensada para gestionar un Instituto en esta aplicacion podremos:
- Ver los horarios de cada alumno, grupo, aula o profesor.
- Reservar horas de un aula que este vacia y se pueda reservar asignando el profesor y la fecha y hora.
- Ver las reservas realizadas en el horario del profesor y aula que reservan.
- Introducir la falta de un profesor (Dia y fecha) y el profesor que lo va a sustituir
- Ver todas las ausencias de cada dia
- Ver, editar, modificar, eliminar, añadir (CRUD) de Alumnos, Aulas, Profesores, Materias, Grupos.
- Poder importar Alumnos, Aulas, Profesores, Materias, Grupos con un fichero .csv cada uno.

## Idea Principal

Esta aplicacion web funcionaria en la sala de profesores del centro, donde todos los profesores tienen acceso a ella. 
A los 3 minutos de inactividad aparece un panel de anuncios, donde un usuario registrado puede ponerlos en la seccion de modulos para que se visualicen en la pantalla inactiva

## ¿Como lo hago funcionar?

Desarrollado en entorno apache, ejecutar en la carpeta dentro de apache (htdocs)
    git clone https://github.com/pablo98ad/GestionInstituto_Almansa
    cd GestionInstituto_Almansa
    composer install
    php artisan key:generate
Configurar base de datos en el archivo .env
    php artisan migrate
    php artisan db:seed

