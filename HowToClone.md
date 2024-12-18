<h2 align="center">HOW TO: Clone This Project</h2>

## Deskripsi Singkat
Project ini menggunakan beberapa library, yaitu [Myth:Auth](https://github.com/lonnieezell/myth-auth) untuk fitur autentikasi, dan [Midtrans-PHP](https://github.com/Midtrans/midtrans-php) untuk Payment Gateway. Dibawah ini adalah cara yang bisa dilakukan agar project ini bisa kalian coba.

## Konfigurasi
Berikut adalah beberapa konfigurasi yang harus dilakukan.

- **Clone repository ini**

    Clone repository ini terlebih dahulu, dengan cara:
    ```
    git clone https://github.com/praktikum-tiunpad-2023/project-pemrograman-web-b-to-the-moon-1.git
    ```

    setelah itu, jalankan 
    ```
    composer update
    ```

    agar library Myth:Auth dan Midtrans-PHP terinstall di local kalian.

- **Buat database**

    Setelah project berhasil di-clone, selanjutnya kalian harus membuat database kalian sendiri. Kalian bisa membuatnya di MySQL atau DBMS lainnya. Untuk nama database dibebaskan.

- **Konfigurasi file .env**

    Agar data yang diolah dalam project ini bisa masuk ke database, kita perlu membuat sebuah file `.env` agar project ini bisa tersambung dengan database yang sudah dibuat. Caranya adalah:

    - Copy file `env` yang ada di project ini, lalu paste dan rename file menjadi `.env`.

    - Set beberapa variabel berikut:
    
        ```
        CI_ENVIRONMENT = development
        ```
        ```
        database.default.hostname = localhost
        database.default.database = // nama database
        database.default.username = // username DBMS
        database.default.password = // password DBMS
        database.default.DBDriver = MySQLi
        database.default.DBPrefix =
        database.default.port = 3306
        ```

    Dengan konfigurasi ini, database kalian sudah terhubung dengan project kalian.

- **Jalankan migration**

    Jalankan file migration yang sudah disediakan dengan cara:
    ```
    php spark migrate
    ```
    Dengan ini, table-table yang dibutuhkan pada project ini akan otomatis dibuat di database kalian.

- **Jalankan query penting**

    Agar project bisa berjalan dengan baik, ada beberapa record yang harus ada di dalam database kalian, query nya bisa kalian copy [dari sini](rodaza_coffee.sql).
    
    Jalankan query-nya di MySQL atau DBMS yang kalian gunakan.

## Tambahan
Ada sedikit konfigurasi tambahan yang harus kalian lakukan agar bisa mencoba project ini, terutama di bagian autentikasi.

- Konfigurasi file `ValidatorInterface.php`

    Pada file `vendor\myth\auth\src\Authentication\Passwords\ValidatorInterface.php`, ada 1 line yang harus kalian ubah agar autentikasi bisa bekerja, yaitu:
    ```
    use CodeIgniter\Entity\Entity;
    ```
    kalian hanya perlu menambahkan `\Entity` disini.

- Konfigurasi file `Auth.php`

    Kalian bisa langsung copy saja isi [file ini](custom-config/Auth.php), dan paste ke file `vendor\myth\auth\src\Config\Auth.php`.

- Konfigurasi file `AuthController.php`

    Sama seperti sebelumnya, kalian langsung saja copy isi [file ini](custom-config/AuthController.php), dan paste ke file `vendor\myth\auth\src\Controllers\AuthController.php`.

## Penutup
Setelah kalian melakukan semua langkah-langkah yang diberikan, maka kalian bisa menjalankan project ini dengan baik.