<?php
// echo 'LOCAL';
// exit;
/*
   * Add the MailHog to your wordpress projects
   * By Khalid Ahmada
   * MailHog @see https://github.com/mailhog/MailHog
   */

//   class WP_MAILHOG
//   {

//     function __construct()
//     {
//       // Config only on local
//       if ($this->isLocal()) {
//         $this->AddSMTP();
//       }

//     }


//     /**
//      * Config Your local rule
//      * default is check if the host is *.test or  *.local
//      * @return bool
//      */
//     private function isLocal()
//     {

//       // if (defined('WP_HOME')) {
//       //   if (strpos(WP_HOME, '.test') !== false ||
//       //     strpos(WP_HOME, '.local') !== false
//       //   ) {
//       //     return true;
//       //   }
//       // }

//       // return false;
//       return true;

//     }

//     /*
//      * Wordpress default hook to config php mail
//      */
//     private function AddSMTP()
//     {
//       add_action('phpmailer_init', array($this, 'configEmailSMTP'));
//     }


//     /*
//      * Config MailTramp SMTP
//      */
//     public function configEmailSMTP(PHPMailer $phpmailer)
//     {
//       $phpmailer->IsSMTP();
//       $phpmailer->Host='127.0.0.1';
//       $phpmailer->Port=1025;
//       $phpmailer->Username='';
//       $phpmailer->Password='';
//       $phpmailer->SMTPAuth=true;

//     }
//   }

// new WP_MAILHOG();

// Setup phpmailer
add_action( 'phpmailer_init', function($phpmailer) {
  $phpmailer->Host = 'mailhog';
  $phpmailer->Port = 1025;
  $phpmailer->IsSMTP();
  // new WP_MAILHOG();
});
