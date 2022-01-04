# List Endpoint


## List Endpoint

list endpoint dapat diakses [127.0.0.1:8000/docs](http://127.0.0.1:8000/docs)

jalankan perintah : 
```bash
php artisan scribe:generate --force 
```
untuk generate list endpoint. List endpoint menggunakan extension [Scribe](https://scribe.knuckles.wtf/laravel/)

## Perubahan length password table staff
pada table staff diperlukan perubahan dari yang tadinya password varchar(40) menjadi password varchar(255).

Hal ini dilakukan untuk menghandle method Hash dari laravel yang memerlukan karakter yang panjang

## License
[MIT](https://choosealicense.com/licenses/mit/)
