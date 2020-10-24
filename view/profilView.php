  <!-- main -->
  <main class="d-flex justify-content-center form_container">
    <div class="card bg-ligh border-dark mt-4 mb-5 p-4">
      <div class="mb-3">Profil utilisateur</div>

      <?php
        require_once "view/formView.php";
        $form = new Form("");

        $form->setText('u_id','reserved');
        $form->setText('u_civility','Civilité');
        $form->setText('u_firstname','Nom');
        $form->setText('u_lastname','Prénom');
        $form->setText('u_birthdate','Date de naissance');
        $form->setText('u_email','Email');
        $form->setText('u_password','Mot de passe');
        $form->setText('u_address_line1','Adresse');
        $form->setText('u_address_line2','Adresse');
        $form->setText('u_zipcode','Code Postal');
        $form->setText('u_city','Ville');
        $form->setText('u_country','Pays');
        $form->setText('u_creation_date','reserved');
        $form->setSubmit('profil','Enregistrer');

        $form->showForm();
      ?>

    </div>
  </main>

  <!-- end main -->
