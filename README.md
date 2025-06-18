# CRM VOIP

Mini CRM App that emulated VOIP State
Create with Laravel 12 as API Server,and Vue 2 as Frontend also using MySQL  


## Clone this Repo
```
git clone https://github.com/ceceps/voipapp
```    

## Instalation

## Docker
Make sure your docker machine is running then Open your terminal console, and run command
it will build and running with docker container in background
```
docker-compose up -d --build
```
The result above command show like this
```
✔ php_laravel                           Built                                                                   0.0s 
 ✔ mysql_laravel                         Built                                                                   0.0s 
 ✔ npm                                   Built                                                                   0.0s 
 ✔ Network salespond_dev_laravelnetwork  Created                                                                 1.3s 
 ✔ Volume "salespond_dev_mysql-logs"     Created                                                                 0.0s 
 ✔ Container npm_dev                     Started                                                                 6.1s 
 ✔ Container mysql_laravel               Started                                                                 6.5s 
 ✔ Container php_laravel                 Started                                                                 8.1s 
 ```

### Setup Backend
```
$ docker compose exec -t php_laravel bash
$ cd /var/www/html
$ cp .env-example .env
```
Edit .env if need adjustment to your system but for default it's fine to keep default, then runn command below
```
$ php artisan key:generate
$ php artisan migrate --seed
```

### Setup Host on Local Browser

Edit Host file

## Windows 
```
C:\Windows\System32\driver\hosts
```

## Linux 
```
/etc/hosts
```

Fill this string
```
127.0.0.1 crm.test
127.0.0.1 crmapi.test
```

Run Web Application in Browser

```
http://crm.test
http://crm.test/contacts
http://crm.test/call-logs

```
## API URL Feature
```
GET /api/v1/contacts
GET /api/v1/contacts?company=?&role=?
```
API Toggle Favorite
```
POST /api/v1/favorite
    {
        contact_id: String, 
        favorite: Boolean
    }
```    
GET /api/v1/call-logs
GET /api/v1/call-logs?start_date=?&end_date
```

## TODO 

1. Upgrade Frontend Vue 2 to Vue 3 for security get latest support at community Vue.js
2. Implement SSL Certificate for Virtual Host with LetsEncripts
3. Implement Security Api with Sanctum
5. Add feature:
    a. Create UI Login, Logout and Forget Password
    b. Add/Update/ Delete contacts
    c. Export Call Logs list to PDF files
