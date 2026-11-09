<?php /** Package vue — page publique, aucune logique métier */ ?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e(APP_NAME) ?> — Accueil</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="public/css/style.css" rel="stylesheet">
</head>
<body>

<section class="landing-hero">
<div class="bg-carousel">
    <img src="public/img/haiti.jpg" alt="">
    <img src="public/img/bat.jpg"alt="">
    <img src="public/img/drop.jpg" alt="">
    <img src="public/img/imag3.jpeg" alt="">
  </div>
  <div class="hero-slide hero-slide-1"></div>
  <div class="hero-slide hero-slide-2"></div>
  <div class="hero-slide hero-slide-3"></div>
  <div class="hero-slide hero-slide-4"></div>

  <nav class="landing-nav">
    <div class="brand">
      <img src="public/img/logo-pnh.svg" alt="Logo PNH">
      POLICE NATIONALE D'HAÏTI
  
    <a href="index.php?page=login" class="btn-navy">
      <i class="bi bi-shield-lock me-2"></i>Accéder à la plateforme
    </a>
  </nav>

  <div class="hero-content">
    <div class="hero-badge float-slow"><span class="pulse-dot"></span>&nbsp; Système de gestion policière — En service</div>
    <h1>Servir, Protéger et <span>Rassurer</span> la population haïtienne</h1>
    <p class="lead" class="color"  --text-dark >
      La Police Nationale d'Haïti modernise la gestion de ses commissariats : personnel, plaintes,
      gardes à vue, interventions et équipements, désormais centralisés dans un système d'information sécurisé.
    </p>
    <div class="hero-actions">
      <a href="index.php?page=login" class="btn-navy btn-lg">Accéder à la plateforme</a>
      <a href="#services" class="btn-outline-light-custom btn-lg">Découvrir les services</a>
    </div>
  </div>

  <div class="stats-strip">
    <div class="stat"><h3>1995</h3><span>Année de création</span></div>
    <div class="stat"><h3>15 000+</h3><span>Agents en fonction</span></div>
    <div class="stat"><h3>11M+</h3><span>Habitants desservis</span></div>
    <div class="stat"><h3>10</h3><span>Départements couverts</span></div>
  </div>
  <div style="height:70px"></div>
</section>

<section class="section-light" id="services">
  <div class="text-center">
    <h2 class="section-title">Nos services</h2>
    <p class="section-sub mx-auto">
      Une institution au service de la sécurité publique, appuyée par des outils numériques modernes.
    </p>
  </div>
  <div class="row g-4">
    <div class="col-md-4">
      <div class="service-card">
        <div class="service-icon"><i class="bi bi-person-badge"></i></div>
        <h5 class="fw-bold">Gestion du personnel</h5>
        <p class="text-muted mb-0">Suivi des matricules, grades, affectations, rotations et mutations des agents.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <div class="service-icon"><i class="bi bi-file-earmark-text"></i></div>
        <h5 class="fw-bold">Traitement des plaintes</h5>
        <p class="text-muted mb-0">Enregistrement, suivi et clôture des plaintes citoyennes en toute traçabilité.</p>
      </div>
    </div>
    <div class="col-md-4">
      <div class="service-card">
        <div class="service-icon"><i class="bi bi-shield-check"></i></div>
        <h5 class="fw-bold">Sécurité &amp; interventions</h5>
        <p class="text-muted mb-0">Rapports d'opérations, gardes à vue et gestion de l'armement en temps réel.</p>
      </div>
    </div>
  </div>
</section>

<section class="section-navy">
  <div class="text-center mb-5">
    <h2 class="section-title">Nos commissariats</h2>
    <p class="section-sub mx-auto text-white-50">
      Un réseau d'unités présentes sur l'ensemble du territoire national.
    </p>
  </div>
  <div class="row g-4">
    <!-- Image 1 -->
    <div class="col-md-4">
      <div class="gallery-card">
        <img src="public/img/img1.jpeg" alt="Commissariat - façade"
             class="img-fluid"
             data-bs-toggle="modal" data-bs-target="#modalImg1">
        <div class="gallery-caption">Commissariat Central — Port-au-Prince</div>
      </div>
    </div>
    <!-- Image 2 -->
    <div class="col-md-4">
      <div class="gallery-card">
        <img src="public/img/imag4.jpeg" alt="Patrouille et véhicules de police"
             class="img-fluid"
             data-bs-toggle="modal" data-bs-target="#modalImg2">
        <div class="gallery-caption">Unité de patrouille</div>
      </div>
    </div>
    <!-- Image 3 -->
    <div class="col-md-4">
      <div class="gallery-card">
        <img src="public/img/imag3.jpeg" alt="Salle d'accueil du commissariat"
             class="img-fluid"
             data-bs-toggle="modal" data-bs-target="#modalImg3">
        <div class="gallery-caption">Accueil &amp; enregistrement des plaintes</div>
      </div>
    </div>
  </div>
</section>

<!-- Modales -->
<div class="modal fade" id="modalImg1" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="public/img/img1.jpeg" class="img-fluid w-100" alt="Image en grand">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalImg2" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="public/img/imag4.jpeg" class="img-fluid w-100" alt="Image en grand">
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalImg3" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="public/img/imag3.jpeg" class="img-fluid w-100" alt="Image en grand">
      </div>
    </div>
  </div>
</div>


<section class="contact-strip">
  <div class="row g-4">
    <div class="col-md-4">
      <div class="contact-item">
        <i class="bi bi-geo-alt"></i>
        <div><strong>Adresse</strong><br><span class="text-white-50">Rue du Centre, Port-au-Prince, Haïti</span></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="contact-item">
        <i class="bi bi-telephone"></i>
        <div><strong>Urgence</strong><br><span class="text-white-50">114 &nbsp;|&nbsp; +509 2222-1111</span></div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="contact-item">
        <i class="bi bi-envelope"></i>
        <div><strong>Contact</strong><br><span class="text-white-50">[pnhhaiti@gmail.com]</span></div>
      </div>
    </div>
  </div>
</section>


<footer class="landing-footer">
  &copy; <?= date('Y') ?> Police Nationale d'Haïti — Tous droits réservés.
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
