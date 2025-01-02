# ATP

Sistema de torneo de tenis.

## Requisitos Previos

- Tener instalado [Docker](https://www.docker.com/).
- Asegúrate de que `docker-compose` esté configurado correctamente.
- PHP y Composer instalados localmente (si es necesario para comandos específicos).

## Instalación

1. **Clonar el repositorio**  
   Clona el repositorio en tu máquina local:  
   ```bash
   git clone git@github.com:LisandroSeijo/geopagos-challenge.git
   cd geopagos-challenge
2. **Levantar contenedores con Docker**  
   ```bash
   php artisan db:seed
3. **Poblar la base de datos**   
   ```bash 
    php artisan db:seed
4. **Iniciar el servidor**  
   ```bash 
    php artisan serve
3. **Tests**  
   ```bash 
    php artisan test

## Uso

Se puede acceder al swagger de la api desde:
http://127.0.0.1:8000/api/documentation


## Sistema

### Players
El sistema se inicia con 100 players masculinios y 100 femeninos.

Los ids impares son masculinos.
Los ids pares son femeninos. 

### Creación de Torneos
Para crear un torneo específico se debe utilizar (link a swagger):
http://127.0.0.1:8000/api/documentation#/Tournaments/createTournament

Para crear un torneo y se simulen todas las fases:
http://127.0.0.1:8000/api/documentation#/Tournaments/generateTournament

Para actualizar un torneo se debe utilizar el endpoint:
http://127.0.0.1:8000/api/documentation#/Tournaments/updateTournament

Para obtener un torneo específico por id:
http://127.0.0.1:8000/api/documentation#/Tournaments/getTournamentById

Para jugar una fase especìfica de un torneo:
http://127.0.0.1:8000/api/documentation#/Tournaments/playPhase

Para listar y filtrar torneos:
http://127.0.0.1:8000/api/documentation#/Tournaments/listTournaments