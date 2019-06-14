<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier contient les réglages de configuration suivants : réglages MySQL,
 * préfixe de table, clés secrètes, langue utilisée, et ABSPATH.
 * Vous pouvez en savoir plus à leur sujet en allant sur
 * {@link http://codex.wordpress.org/fr:Modifier_wp-config.php Modifier
 * wp-config.php}. C’est votre hébergeur qui doit vous donner vos
 * codes MySQL.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en "wp-config.php" et remplir les
 * valeurs.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'wpEval' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'root' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', '0000' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'localhost' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Type de collation de la base de données.
  * N’y touchez que si vous savez ce que vous faites.
  */
define('DB_COLLATE', '');

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clefs secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'T,Z`6}`CdSDMPir >Z./vC6}~Wa]:@ER-<}=AP~=,n~Tz+q2p8F&U2m)CyYnF%Vp' );
define( 'SECURE_AUTH_KEY',  'v!HXd2pdtKS^y$ZG0!1z,!FcUSFzAcBYv|HixC&5 $?_2K@{{<(HG5j4gw(U|ogg' );
define( 'LOGGED_IN_KEY',    '/zh%t(./irFU&v}KW8h`o6 }>3E.j#:c/l6H/;6P4(.3>)rWQK?,WT`<BD<5<Nv?' );
define( 'NONCE_KEY',        'r[3BJGYda!w~v2$~{+T1i(l7jUg,?0+>4ysQwt1I^Pjba-uYs$: =<IqgqtpN=;/' );
define( 'AUTH_SALT',        '(8{aF`QX(KQ4@f^V3P4:+%a0n<8l*eRB%^L[*f:1a*SO}PSY],8NwF}t[Ls0J5Z8' );
define( 'SECURE_AUTH_SALT', 'GtNBqQ& <AB?7+(;u[XqMjkiuTk(Wo?3X @:h$0GiC0WP7+ef4:UH`, MIjf3T_~' );
define( 'LOGGED_IN_SALT',   ':HP01ogf]vCgo(]DtP}CR<UUMI9~wT%fd-XXXreclUU?=L|ay<E/N&O&@8o<d#<c' );
define( 'NONCE_SALT',       '-Cy<xvGKxUc)n`D&3+yEf1A7DmvF&yeI9YE#_R` Gm4?!=zdE2:OYlSk J7WP&>3' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'wp_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortemment recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once(ABSPATH . 'wp-settings.php');
