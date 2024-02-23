<div align="center">
  <img alt="GemaLoka Logo" src="https://github.com/nazrindaniell/GemaLoka/assets/79645841/d752c8e8-f47e-4b5b-8af5-2059816c6668">
  <h3>An e-commerce website that sells local concert ticket</h3>
  <p>GemaLoka is a concert ticket selling platform inspired by AtasAngin, a Malaysian local music concert organization that is widely regarded as a major contributor to Malaysia's music industry</p>
  <br>
  <img alt="GitHub last commit" src="https://img.shields.io/github/last-commit/nazrindaniell/GemaLoka">
  <img alt="GitHub repo size" src="https://img.shields.io/github/repo-size/nazrindaniell/GemaLoka">
  <img alt="GitHub Repo stars" src="https://img.shields.io/github/stars/nazrindaniell/GemaLoka">
  <img alt="GitHub watchers" src="https://img.shields.io/github/watchers/nazrindaniell/GemaLoka">
  <img alt="X (formerly Twitter) Follow" src="https://img.shields.io/twitter/follow/zinniel_">  
</div>
<br>
<br>

## :scroll: Project Description
This project aims to improve the current UI/UX to make it more user-friendly and entertaining, allowing users to have a better experience when exploring the website by focusing on the Cascade Styling Sheet (CSS), which fully utilizes flexbox and grid layout.
<br>
<br>

### Here are some of the things that I implemented throughout the creation of this project.
:wrench: Utilizing `flexbox and grid` layout to the fullest

:file_folder: Making `variable in the CSS` to make things much more organized

:watch: Designing a `prototype in Figma` first before entering into the coding process will save a lot of time.

:mag: `Properly structure the HTML` layout
<br>
<br>

## 🛠️ Built With
<ul>
  <li><img alt="Static Badge" src="https://img.shields.io/badge/HTML5-%23000?style=for-the-badge&logo=HTML5&logoColor=%23E34F26&labelColor=%23fff&color=%23E34F26"></li>
  <li><img alt="Static Badge" src="https://img.shields.io/badge/CSS-%23000?style=for-the-badge&logo=CSS3&logoColor=%231572B6&labelColor=%23fff&color=%231572B6"></li>
  <li><img alt="Static Badge" src="https://img.shields.io/badge/PHP-%23000?style=for-the-badge&logo=PHP&logoColor=%23777BB4&labelColor=%23fff&color=%23777BB4"></li>
  <li><img alt="Static Badge" src="https://img.shields.io/badge/MySQL-white?style=for-the-badge&logo=MySQL&logoColor=%234479A1&labelColor=%23fff&color=%234479A1">
</ul>
<br>

## :camera: Screenshots
  <img alt="Sign in" src="https://github.com/nazrindaniell/GemaLoka/assets/79645841/402106a9-9561-4027-8c89-8b51ab9e6de8">
  <img alt="Subscription" src="https://github.com/nazrindaniell/GemaLoka/assets/79645841/1e769e6f-8a03-419c-93e8-44b0a18d5cf7">
  <img alt="cart" src="https://github.com/nazrindaniell/GemaLoka/assets/79645841/fdd564c7-2327-47d9-a4a2-9f311e4370fb">

## :cd: Installation
```
git clone https://github.com/nazrindaniell/GemaLoka
```

### Setup
<div>
  <ul>
    <li><a href="https://www.apachefriends.org/download.html">Install XAMPP</a></li>
    <li><a href="https://freemyfonts.com/mont-font-family">Install Mont Font Family</a></li>
  </ul>
</div>

### Run the localhost server
Open XAMPP and START the following:

- `Apache`
- `MySQL`

### Create database
1) Open browser and type `localhost/phpmyadmin`
2) Create a new database and named it `gemaloka`, and then click `CREATE` to create a database.
3) `Navigate to SQL` and paste this [queries](https://github.com/nazrindaniell/GemaLoka/files/14371920/gemaloka.tables.txt) one by one.
4) Click `GO` to create the table.

>[!IMPORTANT]
>When naming the database, make sure it is `gemaloka`, or if you want to use your preferred database name, you need to configure the `dbname` variable in `/php/dbconnect.php` file to your database name in `localhost/phpmyadmin`.
```php
<?php
	$host = "localhost";
	$username = "root";
	$password = "";
	$dbname = "gemaloka";
	$conn = mysqli_connect($host, $username, $password, $dbname);

	if(!$conn){
		die("Connection failed: " . mysqli_connect_error());
	}
?>
```
<br>

## :clipboard: How to Use

### Adding a ticket
1. On browser, navigate to `localhost/GemaLoka/php/admin.php`
2. Fill in all the requirements and click the `Add Ticket` button.
> [!NOTE]
> Ensure the ticket image that you want to insert is square sized to have a consistent layout in the browser.

### Edit/Delete a Ticket
1. Navigate to `localhost/GemaLoka/php/admin_update.php`
2. Select a ticket that you want to edit or delete
3. You can add the price of the ticket in this page
> [!IMPORTANT]
> Keep in mind to insert a ticket image or else, you will not be able to update it.
<br>

## :sunflower: Contribute
If you want to say thank you and/or support the active development of GemaLoka:

1. Add a [GitHub Star](https://github.com/nazrindaniell/GemaLoka) to the project.
2. Support the project by donating a [cup of coffee](https://www.buymeacoffee.com/nazrindaniell).
<br>

## :bust_in_silhouette: Author
If you have any inquires, feel free to leave me a message at nazrindaniel8@gmail.com


