<?php
require_once 'idiorm.php';

header('Content-type: application/json');


    //Detection de POST
    if(!empty($post)) :

        extract($_POST);

        if(!empty($email)) :

            if(!filter_var($eamil, filter_validate_email)) :

                $erreurs['isEmailInvalid'] = true;

            endif;

        else : 

            $erreurs['isMailEmpty'] = true;

        endif;
        
    
    else :
        echo json_encode([
            'nodata' => 'Aucune  donn&eacutees d&eacutetect&eacutees.'
        ]);
    endif;

?>