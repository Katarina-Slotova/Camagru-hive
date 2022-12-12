# Camagru-hive 📸
</hr>
<img width="193" alt="camagru-final-grade" src="https://user-images.githubusercontent.com/66918113/196616188-07d80818-53c3-4400-859f-410adb70581a.png">
</br>

## About the project
</hr>

Camagru is the first project of the Web Development branch at Hive Helsinki, which I created from scratch all by myself. It allows user to create an account, which is verified via an email with unique link. After that, user can log in, upload pictures with none, one or more predefined images (stickers), take a picture using their webcam and jazz it up with one or more stickers, like pictures and comment on them, edit their profile, and search for other users and follow them. Every time someone comments on user's picture, user will receive a notification email. User can turn off these notifications in their profile, under notification preferences. 

The gallery with all the pictures is public, so people can see them without creating an account or logging in.

XSS and SQL injction attacks are rather difficult to achieve, since I prevent all kinds of shenanigans 😁 

For more information about the project, check out the [subject](https://github.com/Katarina-Slotova/Camagru-hive/blob/main/subject.pdf).

</br>

## Technologies used in the project
</hr>

✔️ Languages allowed by the project's subject:
  - Server: **PHP**
  - Client: **HTML**, **CSS**, **JavaScript** (only with browser natives API)

✔️  Frameworks allowed by the project's subject:
  - Server: None
  - Client: CSS Frameworks tolerated, unless it adds forbidden JavaScript. My framework of choice was **Bulma**, since it uses only CSS and no JS.

✔️  Database:
  - **MySQL**
</br>

## How to install and run the app
</hr>

First, install [MAMP](https://bitnami.com/stack/mamp) on your device.

Then `cd` into the `htdocs` directory and run `https://github.com/Katarina-Slotova/Camagru-hive.git camagru`. The directory where you clone the project ***must*** be called **camagru**.

Once you have the project cloned, check the `camagru/config/database.php` and `camagru/src/connection.php` files and change the password for `root` to whatever you set it to when you installed MAMP.

Then open your browser and proceed to [localhost:8080/camagru/index.php](http://localhost:8080/camagru/index.php), which will redirect you to the home page and creates the databse at the same time.
</br>

## What are Camagru's awesome features?

### Signup
</hr>
<img width="968" alt="Screen Shot 2022-12-12 at 9 24 38 AM" src="https://user-images.githubusercontent.com/66918113/206990097-877be2d8-b669-41ef-b58f-f744eb66a92c.png">
</br>

### Login
</hr>
<img width="1164" alt="Screen Shot 2022-12-12 at 9 24 26 AM" src="https://user-images.githubusercontent.com/66918113/206990139-ea07bf3b-1cef-43d1-9185-f033b89e08fb.png">
</br>

### Upload pictures and optionally add filters (stickers)
</hr>
<img width="1596" alt="Screen Shot 2022-12-12 at 9 28 57 AM" src="https://user-images.githubusercontent.com/66918113/206990172-60f0f18c-ce8b-47a8-a321-b5d583af23b9.png">
</br>

### Take photos with filters (stickers)
</hr>
<img width="1585" alt="Screen Shot 2022-12-12 at 9 54 22 AM" src="https://user-images.githubusercontent.com/66918113/206992011-db3ff799-7cec-4fed-b928-987481cec34c.png">
</br>

### User's profile with their own photos, where they can see who follows them and who they follow
</hr>
<img width="1820" alt="Screen Shot 2022-12-12 at 9 31 46 AM" src="https://user-images.githubusercontent.com/66918113/206990425-7b3f43b3-415c-4914-8627-9eb59715ddc8.png">
</br>

### Edit information and email notification preferences
</hr>
<img width="1088" alt="Screen Shot 2022-12-12 at 9 27 15 AM" src="https://user-images.githubusercontent.com/66918113/206990474-fe6836fd-290b-415f-b1d6-3348d47d156b.png">
</br>

### Home page
</hr>
<img width="906" alt="Screen Shot 2022-12-12 at 9 32 28 AM" src="https://user-images.githubusercontent.com/66918113/206990516-c2bf9aa6-a40c-4f8d-ba06-0130a7f89ce0.png">
</br>

### Search for other users
</hr>
<img width="2532" alt="Screen Shot 2022-12-12 at 9 35 13 AM" src="https://user-images.githubusercontent.com/66918113/206990539-9281c226-251f-43fb-9c39-422dccae32b6.png">
</br>
  
