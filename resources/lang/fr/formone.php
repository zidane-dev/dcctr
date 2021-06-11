<?php

    function fillSlug($string){
        return $string;
    }
    $slug = fillSlug("Unite");
    
return [

    

    #### Index
    'add' => 'Nouveau',
    'action' => 'Actions',
    'retour' => 'Retour',
    #### Actions buttons
    'title edit' => 'Modifier',
    'title supprimer' => 'Supprimer',
    ####### - (Index) Modal

    'modal validation supprision' => 'Êtes-vous sûr(e) de vouloir poursuivre cette action ?',
    'modal validation close' => 'Retour',
    'modal validation confirm' => 'Confirmer',

    #### Create et Edit

    'btn_add_edit' => 'Sauvegarder',
    
    ##### FormRequest

    'regex_fr' => 'Le champ français doit être rempli en français.',
    'regex_ar' => 'Le champ arabe doit être rempli en arabe.',

    'champ_fr required' => 'Le champ en français est obligatoire.',
    'champ_ar required' => 'Le champ en arabe est obligatoire.',

    ##################################################

    
    // 'add champ' => $slug, // Add a NEW red badge
    'add data' => "Nouveau ".$slug, // Add a NEW red badge
    // 'nom_champ' => $slug,
    // 'modal supprimer' => "Supprimer " . $slug,

    // // fichiers neutres x nombre de pronoms qu'il faut, switch case avant pour voyelles, tableau pour feminin masuclin
    // 'nom_champ_fr' => "Nom d'RSSRCE  (FR)",
    // 'nom_champ_ar' => "Nom d'RSSRCE  (AR)",
    // 'form.title' => "Veuillez saisir le nom de  d'RSSRCE ",

    'champ_fr required' => 'Le champ en français est obligatoire.',
    'champ_fr max' => "Le champ français ne doit pas dépasser 255 caractères.",
    'champ_fr unique' => "Ce nom existe déjà.",

    'champ_ar required' => 'الحقل بالعربية إلزامي.',
    'champ_ar max' => 'يجب ألا يتجاوز الحقل بالعربية 255 حرفًا.',
    'champ_ar unique' => 'هذا الاسم مستخدم مسبقا.',  //"L'élément du champ arabe est déjà.",

    // 'champ success in add' => "L'élément a été ajouté avec succès",

    // 'edit champ' => "Modifier cette ligne.",
    // 'champ success in edit' => "L'élément a été modifié avec succès",

    
    // 'champ success in supprimer' => " l'RSSRCE  a été supprimé avec succès",

     ##################################################

     'empty' => 'Rien à voir ici ...'
];
    