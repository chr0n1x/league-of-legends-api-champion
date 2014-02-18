<?php

namespace Riot\Api;

use Httpful\Response;

use Riot\Api;

class Champion extends Api {

  const VERSION  = 'v1.1';
  const ENDPOINT = 'champion';

  /**
   * @var array
   */
  protected $champions = array();

  /**
   * @var Httpful\Response
   */
  protected $response;

  /**
   * {@inheritDoc}
   */
  public function defaultAction() {

    return $this->champions();

  } // defaultAction

  /**
   * {@inheritDoc}
   */
  public function availableRegions() {

    return array( 'br', 'eune', 'euw', 'lan', 'las', 'na' );

  } // availableRegions

  /**
   * @param bool $force default false - force regeneration of obj cache
   * @return array
   */
  public function champions( $force = false ) {

    if ( $force || empty( $this->champions ) ) {
      $this->response  = $this->request( $this->buildEndpointUri() );
      $this->champions = $this->championsFromResponse( $this->response );
    }

    return $this->champions;

  } // champions

  /**
   * @return array
   */
  public function freeToPlay() {

    return $this->filterByIndex( 'freeToPlay' );

  } // freeToPlay

  /**
   * @param string $index
   * @param bool $sort defaults false
   * @param bool $reverse defaults false
   * @return array
   * @throws \InvalidArgumentException When empty index is given
   */
  public function filterByIndex( $index, $sort = false, $reverse = false ) {

    if ( empty( $index ) ) {
      throw new \InvalidArgumentException( 'Bad index given' );
    }

    $champions = $this->champions();
    $results   = array();

    foreach ( $champions as $champion ) {
      if ( isset( $champion->{$index} ) && $champion->{$index} ) {
        $results[] = $champion;
      }
    }

    if ( $sort ) {

      if ( $reverse ) {
        arsort( $results );
      }
      else {
        sort( $results );
      }

    } // if sort

    return $results;

  } // filterByIndex

  /**
   * @param Httpful\Response $response
   * @return array
   */
  private function championsFromResponse( Response $response ) {

    if ( !isset( $response->body ) || !isset( $response->body->champions ) ) {
      throw new \InvalidArgumentException( 'Failed to extract champion data from response.' );
    }

    return (array)$response->body->champions;

  } // championsFromResponse

} // Champion
