<?php
/**
 * @file app.php
 *
 * just starting to test out Untapped
 * API options
 *
 * goal is to get a list of beers,
 * sortable by ABV, given a username
 */

class Untapper
{

  private $username;
  private $beers;

  const API_KEY = '12345';

  public function __construct($username)
  {
    $this->_username = $username; // @todo get this from the form
    $this->_beers = $this->get_beers(self::API_KEY, $this->_username);
    $this->render_markup($this->_username, $this->_beers, $data = array('label' => 'ABV'));
  }


  /**
   * Retrieve a list of beers from Untappd.
   *
   * @param $key
   *    API key for Untapped
   * @param $username
   *    An untappd username
   *
   * @return $beers
   *    Array of the user's beers, sorted by ABV.
   */
  public function get_beers($key, $username)
  {
    // @todo after getting API access, probably split off a function to connect
    // @todo parse the returned object, maybe structure something like this
    $beers = array(
      0 => array('name' => 'Budweiser', 'abv' => '3.2'),
      1 => array('name' => 'Dangerous Man Imperial Hemp', 'abv' => '10.1')
    );
    return $beers;
  }


  /**
   * Return HTML for the page.
   *
   * @param $username
   *    The user's... name
   * @param $beers
   *    List of beers from the API call.
   * @param $data
   *    Metadata about the query (label etc).
   *
   * @return @void
   */
  protected function render_markup($username, $beers, $data)
  {
    $output  = '<h3>' . $username . '\'s' . ' beers' . '</h3>';
    $output .= '<table id="beer-results">';
    $output .= '<thead><th>Name</th><th data-sort="int"><a href="#">'. $data['label'] .'</a></th></thead><tbody>';
    foreach ($beers as $beer) {
      $output .= '<tr><td>' . $beer['name'] . '</td><td data-sort-value="'. $beer['abv'] .'">' . $beer['abv'] . '%</td></tr>';
    }
    $output .= '</tbody></table>';
    echo $output;
  }

}

$username = 'hey_germano';
new Untapper($username);

?>
