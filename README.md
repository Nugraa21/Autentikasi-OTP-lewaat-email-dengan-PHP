# AUTENTIKASI MULTIFAKTOR [By.NUGRA21]()
>Autentikasi menggunaan Phpdengan Librari  [PhpMailer](https://github.com/PHPMailer/PHPMailer) <br/>
>Demnagn menggunakanlbrari ini kita dapat mengirimkan email untuk mengirimkan autentikasi seperti ( otp ,pemberitahuan ,Dll ) dan dengan menggunakan librar [PhpMailer](https://github.com/PHPMailer/PHPMailer)
kita bisa menjalankan aplikasi autentikasi sederhana dengan php di sini saya menggunakan databes [MySql](https://www.mysql.com/) Dengan dengan menggunakan server Apache 
asdache.


##  UI ( Tampilan form styling opsional )

>Form login Btw lagi males ngedit gamar :V

## API / Instal librari [PhpMailer](https://github.com/PHPMailer/PHPMailer)
### Api <br/>
### Api untuk mengirimkan email dan code untuk memproses semua yang akan terjadi misalnya otp itu di buat format pengiriman
```php
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'nugra315@gmail.com'; 
        $mail->Password = '**** **** **** ****'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
```
#
### Librari & Cara install librari 
### Librari kalian bisa mendownloadnya melalui web resmi  [PhpMailer](https://github.com/PHPMailer/PHPMailer)
### Atau kalian bisa mendownloadnya melalui command cli 
```git
install 
```
# Penjelasan bagiabn code 

### code koneksi ke databes menggunakan xampp & mydsql
### code untuk menyambungkan fils libari dan koneksi ke databes
```php
session_start();
include '../API/config.php'; 
require '../API/vendor/autoload.php'; 
```
### Code untuk membuat sebuah variable yang akan menerima inputan dari form 
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];      
    $password = $_POST['password']; 
```
###  Bagian yang sangat penting berguna untuk menyeleksi pengguna dan mencegah adanya sql injeksi
```php
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?"); 
```
###  Code untuk mencocokan variable email yang di simpan dalam databes apakah email itu ada dan mencocokanya pada email yang di kirim melalui form
```php
    $stmt->bind_param("s", $email); 
    $stmt->execute(); 
    $result = $stmt->get_result();
    $user = $result->fetch_assoc(); 
```
###  memastikan apakah password sama dengan yang ada di databes 
```php
    if ($user && password_verify($password, $user['password'])) 
```
###  Menyimpan data ke sesi untuk di keluarkan ke dashboard
> ! Data bersifat opsional tapi untuk di sarankan menambahkanya  
```php
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; 
```
###  Membuat Otp dengan menggeneret code acak 
```php
        $otp = rand(100000, 999999);    
``` 
###  Menyimpan Otp Kedalam sesi sementara 
```php
        $_SESSION['otp'] = $otp;                   
``` 
### Set agar otp mempunyai batas waktu pengisian bila terlambat otp akan di hapus dari sesi
```php
        $_SESSION['otp_expiration'] = time() + 300;  
``` 
###  Api / code untuk email yang mengirimkan otp 
#### Syarat email yang akan kalian jadikan email driver untuk mengirimkan otp harus memenuhi syarat yaitu 

- sudah mempunyai verivikasi 2 langkah 
- terdaftarkan nomor hp/ponsel
- menggunakan dandi aplikasi jadi tidak menggunakan sandi asli tapi harus mencetak sandi aplikasi 

#### Kenapa harus gitu soalnya ini sangat berbahaya karena kalian menggunakan email yang sangat ya tau lah gue males jelasin selanjutnya ini kalian tahu semdiri lah
```php
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true; 
        $mail->Username = 'nugra315@gmail.com'; 
        $mail->Password = '**** **** **** ****'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
```
###  Format pengirim 
#### Isi format sesuwai yang kalian ,au seperti title adress dan yang lain 
```php
        $mail->setFrom('nugra315@gmail.com', 'Nugra21');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Kode OTP N21.WERE';
        $mail->Body = "
```
###  Di sini opsional karena saya uyntuk bentuk pengirimanya 
#### Saya menggunakan format html css agar tampilan emailnya menarik ini opsional saja ( catatan !!!  kalian harus mengaktifkan $mail->isHTML(true); Untuk menambahkan code html ke dalam emal  )
```php
        $mail->isHTML(true);
        $mail->Subject = 'Kode OTP N21.WERE';
        $mail->Body = "
            <html>
            <head>
                <style>
                    .email-container { font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 10px; }
                    .email-header { background-color: #4CAF50; padding: 10px; text-align: center; color: white; font-size: 24px; border-radius: 10px 10px 0 0; }
                    .email-body { margin-top: 20px; font-size: 16px; }
                    .otp-code { font-size: 36px; font-weight: bold; color: #4CAF50; text-align: center; margin: 20px 0; }
                    .email-footer { margin-top: 20px; font-size: 12px; color: #777; text-align: center; }
                    .highlight { color: #4CAF50; font-weight: bold; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='email-header'>Verifikasi Kode OTP</div>
                    <div class='email-body'>
                        <p>Hai <span class='highlight'>{$user['username']}</span>,</p>
                        <p>Terima kasih telah menggunakan layanan kami. Berikut adalah kode verifikasi untuk melanjutkan:</p>
                        <div class='otp-code'>$otp</div>
                        <p>Masukkan kode ini di halaman verifikasi untuk melanjutkan. Jika Anda tidak meminta kode ini, abaikan email ini.</p>
                    </div>
                    <div class='email-footer'>&copy; 2024 N21.WERE. Semua hak cipta dilindungi.</div>
                </div>
            </body>
            </html>
        ";
```
###  Untuk pesan eror opsional 
#### Kalian bisa menambahkan pesan eror di code untuk menampilkan bahwa ada kesalahan di server atau librari ( !! OPSIONAL SAJA ) Bila berhasil maka akan masuk ke menu Untuk verivikasi code yang akan di kirimkan ke email 
```php
        if ($mail->send()) {
            header("Location: verify.php");
            exit();
        } else {
            echo "Pesan tidak dapat dikirim. Mailer Error: " . $mail->ErrorInfo;
        }
```
###  Bila usert salah memasukan emal / paswword
#### Pesan eror bila user salah memasukan data datanya seperti email / password 
```php
    } else {
        $error_message = "Email atau password salah!";
    }
```
# 
## Code verivikasi 

###  Code untuk membuat variable inputan dari form 
```php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $otpInput = $_POST['otp'];
```
###  Mengecek apakah otp ada di dalam sesi dan mencocokanya apakah otp sama seperti yng di kirimkan di email
```php
    if (isset($_SESSION['otp']) && $_POST['otp'] == $_SESSION['otp'] && isset($_SESSION['otp_expiration']) && time() < $_SESSION['otp_expiration']) {
```
###  Meriset ualng atau menghapus otp sementara saat user sukses verivikasi agaar otp sebelumnya tidak bisa di pakai lagi dan meriset menit untuk expayet 
```php
        unset($_SESSION['otp']); 
        unset($_SESSION['otp_expiration']); 
```
###  Bila sokses akan di arahkan ke dalam dashboard 
```php
        header("Location: dashboard.php");
        exit();
```
###  Bila otp yang di masukan salah atau sudah expayet maka akan ada notif 
```php
        header("Location: dashboard.php"); // Redirect ke dashboard
        exit();
    } else {
        $error_message = "OTP tidak valid atau telah kedaluwarsa!";
    }
```

## Okeh sekian ini hanyalah proheck sederhana untuk mendemokan bagaimana si cara otientifikasi multofaktor itu bekerja 

# Thanks bro dan mau membaca sampai akhir 
# Ingat moto kita [! KODING ITU MENYENANGKAN]()