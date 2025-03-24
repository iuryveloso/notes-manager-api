# CoreNote

O Core note é um app para gerenciar notas de maneira simples e intuitíva. É construído usando o [Next.js](https://nextjs.org/) para o APP de frontend , e [Laravel](https://laravel.com/) + [MySQL](https://www.mysql.com/) para a API REST de backend.

## Instalação: 

É necessário ter o [Docker](https://www.docker.com/) instalado no seu sistema.

Clone os repositórios do [APP](https://github.com/iuryveloso/corelab-challenge-web-app-php) e da [API](https://github.com/iuryveloso/corelab-api-challenge-php). Coloque-os de preferencia no mesmo diretório.

Crie uma cópia do arquivo ".env.example" na pasta raiz do app.Renomeie-o para ".env" e complete as informações restantes.

Crie uma cópia do arquivo ".env.example" na pasta raiz da api.Renomeie-o para ".env" e complete as informações restantes.

Crie uma cópia do arquivo ".env.example" na pasta "/docker", dentro da api.Renomeie-o para ".env" e complete as informações restantes, atentando-se aos diretórios do app (APP_DIRECTORY) e da api (API_DIRECTORY).

Acesse a pasta "/docker", dentro da api pelo terminal e execute o comando os comados ```docker compose build api``` e ```docker compose build web_app```. Em seguida, execute o comando ```docker compose up -d```.

Depois de subir os containers docker, rode ```docker exec -it corenote_api  bash```, e execute os comandos a seguir: 
  1. ```composer install```
  2. ```php artisan migrate```
  3. ```php artisan key:generate```
  4. ```php artisan optimize```
  5. ```php artisan storage:link```

Por fim, abra o navegador e acesse [http://localhost:3000](http://localhost:3000). Aproveite!
