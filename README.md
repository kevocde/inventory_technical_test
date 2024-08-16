# Inventory Rest API
Esta es la solucion para la prueba tecnica plantenada para el cargo de Symfony Developer en Hiberus.

## Instalacion
### Requerimientos
- docker
- docker compose

### Pasos
- Clonar el repositorio completo en la maquina local (windows o linux): `git clone https://github.com/kevocde/inventory_technical_test.git`
- Moverse al repositorio: `cd inventory_technical_test`
- Levantar los servicios: `docker compose up -d`
- Instalar las depedencias del proyecto: `docker compose exec php /bin/bash -c 'composer install && composer update -o'`
- Ejecutar las migraciones necesarias de la base de datos: `docker compose php bin/console doctrine:migrations:migrate`
- Abrir la app en el navegador [Inventory](https://inventory.local)
- Adicional se requiere registar un host personalizado (linux: `sudo echo >>> '127.0.0.1 inventory.local'`, windows: )

### Testeo
Para realizar el testeo de las funcionalides deberan de importar la coleccion de Postman: Inventory.postman_collection.json (esta en el repo)
y tambien importar el archivo de entorno: Inventory Local.postman_environment para probar.

### Tiempo de ejecucion de la prueba
- 4 horas continuas

### Mejoras posibles
- Interfaz grafica desacoplada con Vite y vuejs
- Autenticacion Auth0 para la comunicacion entre back y front
- Validacion de datos en las solicitudes.
- Migracion a una arquitectura hexagonal.
- Autoempaquetado de la imagen docker de la app.

### Agradecimientos
Agradezco el tiempo y la oportunidad de hacer esta prueba, espero sea de su agrado y cualquier pregunta o inquietud estare atento.