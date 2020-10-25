  <!-- main -->
  <main class="d-flex justify-content-center form_container">
    <div class="card bg-ligh border-dark mt-4 mb-5 p-4">
      <div class="mb-3">Profil utilisateur</div>

      <?php
        require_once "view/formView.php";
        $form = new Form("");
        // // just to test formView
        //   $form->setRadio('Civilité', ['Mr', 'Mme', 'Mlle']);
        //   $form->setCheckBox('Valider');
        // // end test
        // $form->setText('u_id','reserved');
        $form->setText('u_civility','Civilité', $user->getU_civility());
        $form->setText('u_firstname','Nom', $user->getU_firstname());
        $form->setText('u_lastname','Prénom', $user->getU_lastname());
        $form->setText('u_birthdate','Date de naissance', $user->getU_birthdate());
        $form->setText('u_email','Email', $user->getU_email());
        $form->setText('u_password','Mot de passe', $user->getU_password());
        $form->setText('u_address_line1','Adresse', $user->getU_address_line1());
        $form->setText('u_address_line2','Adresse', $user->getU_address_line2());
        $form->setText('u_zipcode','Code Postal', $user->getU_address_line2());
        $form->setText('u_city','Ville', $user->getU_city());
        $form->setText('u_country','Pays', $user->getU_country());
        $form->setText('u_creation_date','reserved', $user->getU_creation_date());
        $form->setSubmit('profil','Enregistrer', '');

        $form->showForm();
      ?>

    </div>
  </main>

  <!-- end main -->
