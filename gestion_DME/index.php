<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
$current_page = basename($_SERVER['PHP_SELF']); // Obtient le nom de la page actuelle
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
   
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- the header -->
    <!-- <header id="header">
        <a class="navbar-brand" href="index.php"><img src="imgs/logoAkdital.png" alt="Logo" style="width:130px;height:49px; margin-left: -40px; "></a>
        <h1 class="logo mr-auto"><a href="index.html">system de Gestion DME</a></h1>
        <ul>
            <li><a href="#">Accueil</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">a propos Nous</a></li>
            <li><a href="#">Contact</a></li>
            <li><a href="">Log in <i class='bx bxs-down-arrow'></i> </a>
                <ul>
                    <li><a href="#">Admin</a></li>
                    <li><a href="#">Medcin</a></li>
                    <li><a href="#">Infermier</a></li>
                    <li><a href="#">Secretaire</a></li>
                    <li><a href="#">Patient</a></li>
                </ul>   
            </li>
        </ul>
    </header> -->
    <?php
$current_page = basename($_SERVER['PHP_SELF']); // Obtient le nom de la page actuelle
?>
<header>
    <a href="index.php"><img src="imgs/logoAkdital-removebg.png" alt="Logo" style="width:150px;height:51px; margin-left: -40px;"></a>
    <ul>
        <li class="<?php echo ($current_page == 'index.php') ? 'active' : ''; ?>"><a href="index.php">Accueil</a></li>
        <li class="<?php echo ($current_page == 'services.php') ? 'active' : ''; ?>"><a href="services.php">Services</a></li>
        <li class="<?php echo ($current_page == 'about.php') ? 'active' : ''; ?>"><a href="about.php">À propos de Nous</a></li>
        <li class="<?php echo ($current_page == 'contact.php') ? 'active' : ''; ?>"><a href="contact.php">Contact</a></li>
        <li>
            <a href="#" style="background-color: rgb(70, 137, 170); color: rgb(215, 238, 250);">Se connecter<i class='bx bxs-down-arrow'></i></a>
            <ul>
                <li><a href="Admin/adminLogin.php">Admin</a></li>
                <li><a href="Medcin/medcinLogin.php">Médecin</a></li>
                <li><a href="Infermier/infermierLogin.php">Infirmier</a></li>
                <li><a href="Secretaire/secretaireLogin.php">Secrétaire</a></li>
                <li><a href="Patient/patientLogin.php">Patient</a></li>
            </ul>   
        </li>
    </ul>
    <h1 class="logo mr-auto"><a href="index.php">Système GDME</a></h1>
</header>

    <!-- the imgs akdital section -->
    <main>
        <div class="slidercontainer">
            <div class="slider">
                <img src="imgs/img11.jpg" alt="Image 1">
                <img src="imgs/img2.jpg" alt="Image 2" >
                <img src="imgs/img3.jpg" alt="Image 3">
4                <img src="imgs/img5.jpg" alt="Image 5">
                <img src="imgs/img6.jpg" alt="Image 6">
                <img src="imgs/img7.jpg" alt="Image 1" >
                <img src="imgs/img8.jpg" alt="Image 1" >
                <img src="imgs/img2.jpg" alt="Image 2" >
                <img src="imgs/img9.jpg" alt="Image 4">
                <img src="imgs/img3.jpg" alt="Image 3">
                <img src="imgs/img4.jpg" alt="Image 4">
                <img src="imgs/img9.jpg" alt="Image 4">


            </div>
            <button class="prev" onclick="changeSlide(-1)">&#10094;</button>
            <button class="next" onclick="changeSlide(1)">&#10095;</button>
        </div>
    </main>
        <script src="imgsslider.js"></script>
        <!-- the akdital infos -->
    <section>
      <div class="infoDME">
        <h2>Group Akdital</h2>
        <img src="imgs/iconAkdital.png" alt="Akdital Logo" style="width: 50px; height: 40px;">
        <h3>C'est Quoi GDME ?</h3>
        <p>
            Le système de Gestion des Dossiers Médicaux Électroniques (GDME)
            est une plateforme intégrée conçue pour centraliser et gérer de manière efficace
            et sécurisée les informations médicales des patients. Développé par le Groupe 
            AKDITAL, leader du secteur privé de la santé 
            au Maroc fondé par le Dr Rochdi Talib.
        </p>
    </div>
    </section>
       <!-- the mission section  -->
       <section class="mission">
        <div class="mission-content">
            <img src="imgs/img8.jpg" alt="" style="width: 40%; height: 400px;  border-radius: 50%;">
            <div class="text">
                <h2>Notre Mission</h2>
                <p>
                        Notre mission est d'améliorer la qualité
                        de vie de nos patients en offrant des soins
                                  de santé de haute qualité, .
                        accessibles et personnalisés. Nous nous
                        engageons à intégrer les technologies avancées 
                                pour une gestion efficace des
                         dossiers médicaux, assurant ainsi une prise en
                                charge holistique et sécurisée.
                </p>
            </div>
        </div>
    </section>
    <!-- the vision section  -->
    <section class="vision">
        <div class="vision-content">
            <div class="text">
                <h2>Notre Vision</h2>
                <p>
                    Nous aspirons à être le leader incontesté du secteur privé de la santé au Maroc,
                    reconnu pour notre excellence clinique, notre innovation technologique et notre 
                    engagement envers le bien-être des patients. En développant nos infrastructures et 
                    en étendant notre réseau à travers le Royaume, nous visons à devenir une référence 
                    nationale et régionale en matière de soins de santé intégrés et accessibles.
                </p>
            </div>
            <img src="imgs/visionimg.jpeg" alt="" style="width: 40%; height: 400px;  border-radius: 50%;">
        </div>
    </section>
    <!-- the count section  -->
<section id="counts" class="counts ">
    <div class="rowcounters">
      <div class=" cont ">
        <span class="counter" data-target="2400" style="color: rgb(64, 110, 162);">0</span>
        <p style="font-weight: 600; color: rgb(27, 78, 137);" >lits</p>
      </div>
      <div class="cont " >
        <span class="counter" data-target="4500" style="color: rgb(64, 110, 162);">0</span>
        <p style="font-weight: 600; color: rgb(27, 78, 137);"  >collaborateurs</p>
      </div>
      <div class="cont " >
        <span class="counter" data-target="22" style="color: rgb(64, 110, 162); ">0</span>
        <p style="font-weight: 600; color: rgb(27, 78, 137); "  >Hôpitaux privés | Cliniques | Centres</p>
      </div>
      <div class="cont " >
        <span class="counter" data-target="12" style="color: rgb(64, 110, 162); ">0</span>
        <p style="font-weight: 600; color: rgb(27, 78, 137);" >Ans d'expérience</p>
      </div>
    </div>
  
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.counter');
  
        counters.forEach(counter => {
          const target = +counter.getAttribute('data-target');
          counter.innerText = '0';
  
          const updateCount = () => {
            const count = +counter.innerText;
            const increment = target / 200; // Adjust this value for different speeds
  
            if (count < target) {
              counter.innerText = Math.ceil(count + increment);
              setTimeout(updateCount, 1.5);
            } else {
              counter.innerText = target;
            }
          };
          updateCount();
        });
      });
    </script>
        <!--
        <div class="container">
  
          <div class="row counters">
  
            <div class="col-lg-3 col-6 text-center">
              <span data-toggle="counter-up">725</span>
              <p>Students</p>
            </div>
  
            <div class="col-lg-3 col-6 text-center">
              <span data-toggle="counter-up">4</span>
              <p>Departments</p>
            </div>
  
            <div class="col-lg-3 col-6 text-center">
              <span data-toggle="counter-up">249</span>
              <p>graduates</p>
            </div>
  
            <div class="col-lg-3 col-6 text-center">
              <span data-toggle="counter-up">54</span>
              <p>professors</p>
            </div>
  
          </div>
  
        </div>-->
  
  
  </section>
  <footer>
    <div class="containerr">
        <div class="descreptionn">
            <h2>CLINIQUE PANORAMA SIDI MAAROUF</h2>
            <p>
                La Clinique Panorama Sidi Maarouf est un établissement de santé privé du Groupe
                 AKDITAL qui propose une dizaine de spécialités et est équipé d’un plateau technique
                  comprenant un service de réanimation adulte et néonatale et des blocs opératoires, une
                   unité technique d’accouchement et un service d’unité de soins intensifs.
            </p>
        </div>
        <div class="contactInfos">
            <ul>
                <li><div><img src="icons/locationIcon.png" alt=""> <a>Av. Abou Bakr el Kadiri, Casablanca 20520.</a></div></li>
                <li><div><img src="icons/phoneIcon.png" alt=""> <a>0522589696</a></div></li>
                <li><div><img src="icons/emailIcon.png" alt=""> <a href="Communication@akdital.ma">Communication@akdital.ma</a></div></li>
                <li><div><img src="icons/websiteIcon.png" alt=""> <a href="www.cliniquepanorama.ma">www.cliniquepanorama.ma</a></div></li>
            </ul>
        </div>
        <div class="mapcontainer">
            <div class="mapframe">
              <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d13304.336588744867!2d-7.653288126291283!3d33.52519777411817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda62df7f0b84885%3A0x16f1c860ea74a73f!2sClinique%20PANORAMA%20SIDI%20MAAROUF%20-%20AKDITAL!5e0!3m2!1sen!2sma!4v1721054611709!5m2!1sen!2sma" width="350" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
      
          </div>
        <div class="social-links-horr">
            <div class="Horaires">
                <h2>NOS HORAIRES DE TRAVAIL</h2>
                <p>
                    Lundi- Dimanche  24H/24    
                    7J/7
                </p>
            </div>
            <div class="social-links text-center" >
              <a href="#" class="btn btn-outline-primary mx-5"><i class="fab fa-facebook-f"></i></a>
              <a href="#" class="btn btn-outline-primary mx-5"><i class="fab fa-instagram"></i></a>
              <a href="#" class="btn btn-outline-primary mx-5"><i class="fab fa-youtube"></i></a>
              <a href="#" class="btn btn-outline-primary mx-5"><i class="fab fa-linkedin-in"></i></a>
          </div>
        </div>
        
        
    </div>
  </footer>

  
    </body>
</html>