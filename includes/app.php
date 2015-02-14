<?php
/**
 * @file app.php
 */

include('keys.inc');

class Untapper
{

  private $username;
  private $beers;
  private $table;

  public function __construct($username)
  {
    $this->_username = $username;
    $this->_beers = $this->get_beers($this->_username);
    $this->_table = $this->render_table($this->_username, $this->_beers, $data = array('label' => 'ABV'));
    $this->render($this->_table);
  }


  /**
   * Format the list of beers from Untappd.
   *
   * @param $username
   *    An untappd username
   *
   * @return $beers
   *    Array of the user's beers, ordered by ABV.
   */
  public function get_beers($username)
  {
    $beers = array();
    $response = self::fetch_beers($username);

    // @todo return different error if API limit hit (see header)
    // @todo better error message. something funny.
    // @todo clear error if user doesn't exist.
    if ($response->meta->code !== 200) {
      echo 'Error code ' . $response->meta->code;
      return;
    }

    foreach ($response->response->beers->items as $beer) {
      $beers[] = array(
        'brewery' => $beer->brewery->brewery_name,
        'name' => $beer->beer->beer_name,
        'abv' => $beer->beer->beer_abv,
        'rating' => $beer->rating_score
      );
    }

    // Sort by ABV, high to low.
    usort($beers, function($a, $b) {
      return $b['abv'] > $a['abv'] ? 1 : -1;
    });

    return $beers;
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
  protected function fetch_beers($username)
  {
    include('UntappdPHP/lib/untappdPHP.php');
    $ut = new UntappdPHP(CLIENT_ID, CLIENT_SECRET, BASE_URL);
    $info = $ut->get('/user/beers/' . $username . '?limit=50');
    return $info;
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
  protected function render_table($username, $beers, $data)
  {
    $table_headers = '';
    $columns = array(
      'Brewery' => 'string',
      'Name' => 'string',
      'ABV' => 'float',
      'Rating' => 'float'
    );
    foreach ($columns as $name => $dataType) {
      $table_headers .= '<th data-sort="'. $dataType .'"><a href="#">'. $name .'</a></th>';
    }

    $output  = '<h3>' . $username . '\'s' . ' booziest beers' . '</h3>'; // @todo more user info
    // @todo show a link to re-enable the form for searching another username
    // @todo dynamic result count. don't show table if no results.
    $output .= '<p>Showing most recent 50 beers. <!--<a href="#show-100">Show 100</a>.--></p>'; // @todo hookup "show 100"
    $output .= '<table id="beer-results">';
    $output .= '<thead>'. $table_headers .'</thead><tbody>'; // @todo add an arrow icon on the sorted column
    foreach ($beers as $beer) {
      $output .= '<tr>';
      $output .= '<td>' . $beer['brewery'] . '</td>'; // @todo show images too // @todo link to brewery site
      // @todo add state
      $output .= '<td>' . $beer['name'] . '</td>';
      $output .= '<td data-sort-value="'. $beer['abv'] .'">' . $beer['abv'] . '%</td>';
      // @todo add style
      $output .= '<td>' . $beer['rating'] . '</td>';
      $output .= '</tr>';
    }
    $output .= '</tbody></table>';

    return $output;
  }


  /**
   * @todo make a way to show the users friends and show their booziest beers.
   */
  protected function compare_pals()
  {

  }


  /**
   * Pull together all the components and echo the output.
   *
   * @param $table
   *   String of HTML for the main results table.
   *
   * @return @void
   */
  protected function render($table)
  {
    $output = $table;
    echo $output;
  }

}

$username = $_POST['username'];
new Untapper($username);

?>
