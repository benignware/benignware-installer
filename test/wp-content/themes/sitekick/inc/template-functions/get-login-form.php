<?php

namespace benignware\sitekick {
  use function benignware\bootstrap_hooks\get_markup;
  use \DOMXPath;
  use \DOMDocument;

  function get_login_form($args = []) {
    global $_GET;
  
    ob_start();
    wp_login_form($args);
    $content = ob_get_clean();
    $content = get_markup($content);
      
    // Inject hidden input for denoting frontend
    $content = preg_replace(
      '~(<form[^>]+>)~',
      "$1\n<input type=\"hidden\" name=\"frontend\" value=\"1\"/>",
      $content
    );

    if (!isset($_REQUEST['error'])) {
      return $content;
    }
  
    $error = json_decode(base64_decode($_REQUEST['error']));
      
    if (isset($error->message)) {
      $alert = sprintf('<div class="alert alert-danger">%s</div>', $error->message);
      
      $content = preg_replace('~(<form[^>]+>)~', "$1\n$alert", $content);

      return $content;
    }

    $doc = new DOMDocument();
    @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $content );
    $doc_xpath = new DOMXpath($doc);

    if (isset($error->fields)) {
      foreach ($error->fields as $field => $message) {
        $input = $doc_xpath->query(sprintf('//input[@name="%s"]', $field))->item(0);

        if (!$input) {
          continue;
        }

        $feedback = $doc->createElement('span');
        $feedback->setAttribute('class', 'invalid-feedback d-block');
        $feedback->appendChild($doc->createTextNode($message));

        $classes = array_unique(array_filter(explode(' ', $input->getAttribute('class'))));
        $classes[] = 'is-invalid';
        $classes = apply_filters('sitekick-invalid-class', $classes, $error);
        $input->setAttribute('class', implode(' ', $classes));

        if ($input->nextSibling) {
          $input->parentNode->insertBefore($feedback, $input->nextSibling);
        } else {
          $input->parentNode->appendChild($feedback);
        }
      }
    }
    
  
    $content = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());
  
    return $content;
  }
}
