
# Backend App Top Tenis Valencia <img src="./storage/app/public/images/tennis_ball_icon.png" width="50">

<details>
  <summary>Contenido 📝</summary>
  <ol>
    <li><a href="#objetivo">Objetivo</a></li>
    <li><a href="#sobre-el-proyecto">Sobre el proyecto</a></li>
    <li><a href="#stack">Stack</a></li>
    <li><a href="#diagrama-bd">Diagrama</a></li>
    <li><a href="#documentos borrador para estudio del proyecto">Diagrama</a></li>
    <li><a href="#instalación-en-local">Instalación</a></li>
    <li><a href="#endpoints">Endpoints</a></li>
    <li><a href="#futuras-funcionalidades">Futuras funcionalidades</a></li>
    <li><a href="#contribuciones">Contribuciones</a></li>
    <li><a href="#licencia">Licencia</a></li>
    <li><a href="#webgrafia">Webgrafia</a></li>
    <li><a href="#agradecimientos">Agradecimientos</a></li>
    <li><a href="#contacto">Contacto</a></li>
  </ol>
</details>

## Objetivo
Este proyecto requería una API funcional conectada a una base de datos con al menos un CRUD completo, una relación de uno a muchos, una relación de muchos a muchos, registro usuarios, login, token y middleware "isAdmin".

## Sobre el proyecto
La idea principal era crear una aplicación web de gestión de torneos de tenis para jugadores aficionados de una provincia, donde cada participante juega un partido semanal contra un rival asignado en modo liga todos contra todos, en el lugar que los jugadores deciden. 
Aunque la app también podría aplicarse para polideportivos municipales, o clubes de tenis donde se realizan torneos internos para sus socios. 
Las principales caracteristicas de esta aplicación son:
- Usuario administrador, se encargará de crear los torneos y realizar los emparejamientos de los jugadores
- Usuario participante, mediante su registro a la aplicación y posterior login, podrá inscribirse a los torneos disponibles, añadir el resultado de sus partidos, ver los resultados y clasificación del torneo. 

## Stack
Tecnologías utilizadas:
<div align="center">
<a href="https://www.php.net/">
    <img src= "https://img.shields.io/badge/php-7A86B8?style=for-the-badge&logo=php&logoColor=black"/>
</a>
<a href="https://laravel.com/">
    <img src= "https://img.shields.io/badge/laravel-F13C2F?style=for-the-badge&logo=laravel&logoColor=white"/>
</a>
<a href="https://www.postman.com/">
    <img src= "https://img.shields.io/badge/Postman-FF6C37?style=for-the-badge&logo=postman&logoColor=white"/>    
</a>
    <a href="https://railway.app/">
    <img src= "https://img.shields.io/badge/railway-%23000000.svg?style=for-the-badge&logo=railway&logoColor=white"/>
</a>
<a href="https://www.mysql.com/">
    <img src= "https://img.shields.io/badge/mysql-3E6E93?style=for-the-badge&logo=mysql&logoColor=white"/>    
</a>
    <a href="https://www.github.com/">
    <img src= "https://img.shields.io/badge/github-24292F?style=for-the-badge&logo=github&logoColor=white"/>
</a>
    <a href="https://www.docker.com/">
    <img src= "https://img.shields.io/badge/docker-2496ED?style=for-the-badge&logo=docker&logoColor=white"/>
</a>
 </div>


## Diagrama Base Datos
<div align="center">
    <img src="./storage/app/public/images/diagrama_workbench_mysql_2.jpg">
</div>

## Documentos previos de estudio
<div align="center">
    <img src="./storage/app/public/images/Borrador%20endpoints%201.jpg" width="150">
    <img src="./storage/app/public/images/Borrador%20endpoints%202.jpg" width="150">
    <img src="./storage/app/public/images/Esbozo%20base%20datos%201.jpg" width="150">
    <img src="./storage/app/public/images/Esbozo%20base%20datos%202.jpg" width="150">
    <img src="./storage/app/public/images/Esbozo%20vistas%201.jpg" width="150">
    <img src="./storage/app/public/images/Esbozo%20vistas%202.jpg" width="150">
    <img src="./storage/app/public/images/diagrama_database.jpg" width="150">
</div>

## Metodologias ágiles
<div align="center">
    <img src="./storage/app/public/images/Trello_TopTenisValencia.jpg">
</div>

## Instalación en local
1. Clonar el repositorio
2. ` $ composer install `
3. Conectamos nuestro repositorio con la base de datos 
4. ``` $ php artisan serve ``` 
5. ``` $ php artisan migrate ``` 
6. ``` $ php artisan db:seed ``` 
 


## API
<details>
<summary>Endpoints</summary>

- AUTH
    - REGISTER

            POST http://localhost:8000/api/register
        body:
        ``` js
            {
                "name": "Rubén",
                "surname": "Golfe Silvestre",
                "email": "rubengolfesilvestre@gmail.com",
                "password": "111111",
                "city": "Vilamarxant",
                "age": 41,
                "phone": "666111222"
            }
        ```

    - LOGIN

            POST http://localhost:8000/api/login  
        body:
        ``` js
            {
                "email": "rubengolfesilvestre@gmail.com",
                "password": "111111"
            }
        ```
    - LOGOUT

            POST http://localhost:8000/api/logout  

- USERS
    - PROFILE  

            GET http://localhost:8000/api/users/profile

    - UPDATE USER

            PUT http://localhost:8000/api/users/{id} 
        body:
        ``` js
            {
                "email": "rubengolfesilvestre@gmail.com",
                "password": "111111"
            }
        ```

    - GET ALL USERS (isAdmin)  

            GET http://localhost:8000/api/users

- TOURNAMENTS
    - GET ALL TOURNAMENTS

            GET http://localhost:8000/api/tournaments

    - CREATE TOURNAMENT (isAdmin)

            POST http://localhost:8000/api/tournaments
        body:
        ``` js
            {
                "name": "Open WinterChallege 2023",
                "start_date": "2023-12-01",
                "end_date": "2024-02-28"
            }
        ```
    - UPDATE TOURNAMENT (isAdmin)
            PUT http://localhost:8000/api/tournaments/{id}
        body:
        ``` js
            {
                "start_date": "2023-12-01",
                "end_date": "2024-02-28"
            }
        ```
    - DELETE TOURNAMENT (isAdmin)  

            GET http://localhost:8000/api/tournaments/{id}

    - ADD USER TO TOURNAMENT
            POST http://localhost:8000/api/tournaments/{id}
        body:
        ``` js
            {
                "user_id": 6
            }
        ```
    - DELETE USER TO TOURNAMENT
            DELETE http://localhost:8000/api/tournaments/{id}
        body:
        ``` js
            {
                "user_id": 5
            }
        ```
    - GET USERS BY TOURNAMENT

            GET http://localhost:8000/api/tournaments/{id}

- TENNIS MATCHES
    - CREATE MATCH BY TOURNAMENT (isAdmin)

            POST http://localhost:8000/api/tennisMatches/{id}
        body:
        ``` js
            {
                "name": "Open WinterChallege 2023",
                "start_date": "2023-12-01",
                "end_date": "2024-02-28"
            }
        ```
    - GET MATCHES BY TOURNAMENT

            GET http://localhost:8000/api/tennisMatches/{id}

    - UPDATE MATCH BY ID (isAdmin)

            PUT http://localhost:8000/api/tennisMatches/{id}
        body:
        ``` js
            {
                "date": "2023-02-13",
                "location": "Polideportivo Mislata",
                "player1_user_id": 2,
                "player2_user_id": 3,
                "winner_user_id": 2
            }
        ```
    - DELETE MATCH BY ID (isAdmin)

            DELETE http://localhost:8000/api/tennisMatches/{id}

- RESULTS
    - UPDATE RESULT BY ID

            PUT http://localhost:8000/api/results/{id}
        body:
        ``` js
            {
                "winner_user_id": 4
            }
        ```
    - GET RESULTS BY TOURNAMENT

            GET http://localhost:8000/api/results/{id}

- CLASSIFICATION
    - GET CLASSIFICATION BY TOURNAMENT

            GET http://localhost:8000/api/classification/{id}


</details>

## Futuras funcionalidades
[ ] Incluir los nombres de los jugadores en la clasificación  
[ ] Incluir los nombres de los jugadores en el listado de partidos de un torneo
[ ] Generar emparejamientos de los partidos de un torneo automáticamente 

## Contribuciones
Las sugerencias y aportaciones son siempre bienvenidas.  

Puedes hacerlo de dos maneras:

1. Abriendo una issue
2. Crea un fork del repositorio
    - Crea una nueva rama  
        ```
        $ git checkout -b feature/nombreUsuario-mejora
        ```
    - Haz un commit con tus cambios 
        ```
        $ git commit -m 'feat: mejora X cosa'
        ```
    - Haz push a la rama 
        ```
        $ git push origin feature/nombreUsuario-mejora
        ```
    - Abre una solicitud de Pull Request

## Licencia
Este proyecto se encuentra bajo licencia MIT

## Webgrafia:
Para conseguir mi objetivo he recopilado información de:
- https://laravel.com
- Documentación aportada en la formación de GeeksHubs Academy


## Agradecimientos:

Agradezco a mis formadores el tiempo dedicado a orientarme en este proyecto:

- **David Ochando**  
<a href="https://www.linkedin.com/in/david-ochando-blasco-90b2ba1a/"><img src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white"></a>

- **Dani Tarazona**  
<a href="https://www.linkedin.com/in/daniel-tarazona-tamarit-05634794/"><img src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white"></a> 

## Contacto

Rubén Golfe Silvestre
<img src="./storage/app/public/images/imagen_perfil_gris.jpg" width="150">
<a href = "mailto:rgolfe81@gmail.com"><img src="https://img.shields.io/badge/Gmail-C6362C?style=for-the-badge&logo=gmail&logoColor=white" target="_blank"></a>
<a href="https://www.linkedin.com/in/ruben-golfe/" target="_blank"><img src="https://img.shields.io/badge/-LinkedIn-%230077B5?style=for-the-badge&logo=linkedin&logoColor=white" target="_blank"></a> 

