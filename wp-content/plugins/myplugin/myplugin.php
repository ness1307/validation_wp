<?php

/*
Plugin Name: myplugin
Description: Un plugin d'évaluation.
Version: 0.1.0.4.2.1.4.2
Author: Ganfald le rouge
License: GNU GPL
*/



function accueil() {
    return "Voici tous ce que vous pouvez trouver dans mon magazin de 
    musique. Parcourez les différentes catégories pour voir les articles qui contient.";
}

add_shortcode('themeMusic', 'accueil');


function afficherCleDeSol() {
    return "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/GClef.svg/320px-GClef.svg.png'>"; 
}

add_shortcode('note', 'afficherCleDeSol');

// Article casque/écouteur

function casqueAudio() {
    return "Un casque audio est un dispositif qui se place contre les oreilles et sert à restituer des contenus sonores.";
}

add_shortcode('introCasque', 'casqueAudio');



function afficherCasque() {
    return "<img src='https://upload.wikimedia.org/wikipedia/commons/thumb/4/40/Headphones_1.jpg/1280px-Headphones_1.jpg'>"; 
}

add_shortcode('imageCasque', 'afficherCasque');


function afficherAudio() {
    return "<h1> Casque Audio 2 </h1>.";
}

add_shortcode('titreCasque', 'afficherAudio');

