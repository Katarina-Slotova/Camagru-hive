# Camagru-hive
</hr>
<img width="193" alt="camagru-final-grade" src="https://user-images.githubusercontent.com/66918113/196616188-07d80818-53c3-4400-859f-410adb70581a.png">

# About the project
</hr>

Camagru is the first project of the Web Development branch at Hive Helsinki, which I created from scratch all by myself. It allows user to create an account, which is verified via an email with unique link. After that, user can log in, upload pictures with none, one or more predefined images (stickers), take a picture using their webcam and jazz it up with one or more stickers, like pictures and comment on them, edit their profile, and search for other users and follow them. Every time someone comments on user's picture, user will receive a notification email. User can turn off these notifications in their profile, under notification preferences. 

The gallery with all the pictures is public, so people can see them without creating an account or logging in.

XSS and SQL injction attacks are rather difficult to achieve, since I prevent all kinds of shenanigans 😁 

For more information about the project, check out the [subject].

# Technologies used in the project
</hr>

✔️ Languages allowed by the project's subject:
  - Server: **PHP**
  - Client: **HTML**, **CSS**, **JavaScript** (only with browser natives API)

✔️  Frameworks allowed by the project's subject:
  - Server: None
  - Client: CSS Frameworks tolerated, unless it adds forbidden JavaScript. My framework of choice was **Bulma**, since it uses only CSS and no JS.

✔️  Database:
  - **MySQL**

# How to install and run the app
</hr>

First, install [MAMP](https://bitnami.com/stack/mamp) or [XAMPP](https://www.apachefriends.org/download.html) on your device.

Then `cd` into the htdocs directory and run `https://github.com/Katarina-Slotova/Camagru-hive.git camagru`. The directory where you clone the project ***must*** be called **camagru**.

Once you have the project cloned, check the `camagru/config/database.php` and `camagru/src/connection.php` files and change the password for `root` to whatever you set it to when you installed MAMP/XAMPP.

Then open your browser and proceed to [localhost:8080/camagru/index.php](http://localhost:8080/camagru/index.php), which will redirect you to the home page and creates the databse at the same time.



  
