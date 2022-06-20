## Backend OR Api Project setup

Clone the ```[API Project ]```

```bash
  git clone https://github.com/tarikulIslamNahid/laravel-9-blog-api.git $PROJECT_NAME
```
Go to the project directory

```bash
  cd $PROJECT_NAME
```
 Install Composer Dependencies
 
```bash
composer install
```

Create a copy of your .env file
```bash
cp .env.example .env
```
```In the .env file, add database information to allow Laravel to connect to the database```

terminal run:

```bash
php artisan key:generate
php artisan config:clear
php artisan optimize:clear
``` 
Migrate & Seed the database. | ```seed is important to create user```

```bash
php artisan migrate:fresh --seed
``` 

Start the server

```bash
  php artisan serve
```

Check Api Documentation 

```bash
App\api-docs
``` 


## Frontend Project setup

Clone the ```[Frontend Project ]```

```bash
  git clone https://github.com/tarikulIslamNahid/nuxt-3-blog.git $PROJECT_NAME
```
Go to the project directory

```bash
  cd $PROJECT_NAME
```
 install dependencies
 
```bash
yarn install
```
 
```Set Backend API URL```

```bash
   got to -> [nuxt.config.js] file then scroll down and  update API_URL:  '$BACKEND_URL/api/'
``` 

serve with hot reload at localhost:3000
 
```bash
yarn dev
```

admin panel
 
```bash
$WEB_URL/admin
```
