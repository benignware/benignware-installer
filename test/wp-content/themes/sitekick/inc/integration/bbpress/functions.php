<?php

function sitekick_bbp_edit_user_display_name() {
  ob_start();
  bbp_edit_user_display_name();
  $content = ob_get_clean();

  // Parse DOM
  $doc = new DOMDocument();
  @$doc->loadHTML('<?xml encoding="utf-8" ?>' . $content );
  $doc_xpath = new DOMXpath($doc);

  $select = $doc_xpath->query('//select')->item(0);

  if ($select) {
    $select->setAttribute('class', $select->getAttribute('class') . ' form-select');
  }

  $content = preg_replace('~(?:<\?[^>]*>|<(?:!DOCTYPE|/?(?:html|head|body))[^>]*>)\s*~i', '', $doc->saveHTML());

  echo $content;
}