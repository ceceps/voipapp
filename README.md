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
```
docker-compose up -d --build
```

### Install Backend
```
cd /var/www/html
php artisan key:generate
php artisan migrate --seed
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

Fiil this values
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
