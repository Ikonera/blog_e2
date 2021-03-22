<?php

    require "./model/VerificationManager.class.php";
    require "./model/ArticleManager.class.php";
    require "./model/UserManager.class.php";
    require "./model/CategoriesManager.class.php";
    
    $verificationManager = new VerificationManager;
    
    $articleManager = new ArticleManager;
    $userManager = new UserManager;
    $categoriesManager = new CategoriesManager;
    
    
    $articleManager->setNewArticle();
    
