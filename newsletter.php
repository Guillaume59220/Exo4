<?php
require_once 'idiorm.php';

ORM::configure('mysql:host=localhost;dbname=newsletter');
ORM::configure('username', 'root');
ORM::configure('password', '');

header('Content-type: application/json');


    //Detection de POST
    if(!empty($post)) :

        extract($_POST);

        if(!empty($email)) :

            if(!filter_var($eamil, filter_validate_email)) :

                $erreurs['isEmailInvalid'] = true;
            
            else :

                $isEmailInDb = ORM::for_table('contact')
                                -> where('email_contact', $email)
                                ->count();

                if(!$isEmailInDb) :

                    $contact = ORM::for_table('contact')->create();
                    $contact->prenom_contact    = $prenom;
                    $contact->nom_contact       = $nom;
                    $contact->email_contact     = $email;
                    $contact->save();

                else :

                    $erreurs['isEmailInDb'] = true;

                endif;

            endif;

        else : 

            $erreurs['isMailEmpty'] = true;

        endif;
        
    
    else :
        echo json_encode([
            'nodata' => 'Aucune donn&eacute d&eacutetect&eacute.'
        ]);
    endif;

?>