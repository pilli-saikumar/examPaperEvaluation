<?php
function authenticateUser($pageType=''){
    // if($pageType == 'login'){
    //     if(isset($_SESSION['id']) && empty($_SESSION['id'])){
    //         return true;
    //     }
    //     else{
    //         redirect('dashboard.php');
    //     }
    // }
    // elseif($pageType == 'dashboard'){
    //     if(isset($_SESSION['id']) && !empty($_SESSION['id'])){
    //         return true;
    //     }
    //     else{
    //         redirect('index.php');
    //     }
    // }
    return true;
}

function redirect($url=''){
    header('location:'.$url);
}
?>