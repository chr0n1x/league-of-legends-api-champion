<?php

namespace Riot\Api;

use Riot\Api;

class Champion extends Api {

  const VERSION = 'v1.1';
  const ENDPOINT = 'champion';

  public function defaultAction() {

    return $this->champions();

  } // defaultAction

  public function champions() {

    return $this->request( $this->buildEndpointUri() );

  } // champions

  public function availableRegions() {

    return array( 'br', 'eune', 'euw', 'lan', 'las', 'na' );

  } // availableRegions

} // Champion
