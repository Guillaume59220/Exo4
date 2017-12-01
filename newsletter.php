<?php
require_once 'idiorm.php';

ORM::configure('mysql:host=localhost;dbname=newsletter');
ORM::configure('username', 'root');
ORM::configure('password', '');

header('Content-type: application/json');


    //Detection de POST
    if(!empty($_POST)) :

        extract($_POST);

        if(!empty($email)) :

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) :

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

        if(!isset($erreurs)) :
            echo json_encode(['success' => true]);

        else :

            echo json_encode([
                'success' => false,
                'erreurs' => $erreurs
            ]);
    
        
        endif;
    
    else :
        echo json_encode([
            'nodata' => 'Aucune donn&eacute d&eacutetect&eacute.'
        ]);
    endif;

?>