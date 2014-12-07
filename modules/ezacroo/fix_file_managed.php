<?php
  $uri_list = db_select('file_managed', 'f')
  ->fields('f', array('fid', 'uri'))
  ->execute()
  ->fetchAll();
  
  foreach ($uri_list as $uri_rec) {
    $fid = $uri_rec->fid;
    $uri = $uri_rec->uri;
    $uri_new = str_replace("files/", "private://", $uri, &$count);
    if ($count = 1) {
       $num_updated = db_update('file_managed')
       ->fields(array('uri' => $uri_new))
       ->condition('fid', $fid, '=')
       ->execute();
       if ($num_updated <> 1) drupal_set_message("fid $fid $uri_new - $num_updated");
    }
  }
?>