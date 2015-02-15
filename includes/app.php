<?php
/**
 * @file app.php
 */

include('keys.inc');

class Untapper
{

  private $user;
  private $beers;
  private $table;

  public function __construct($username)
  {
    // Given a username, look up their user info and beers.
    $response = self::fetch_untappd_info($username);
    $this->_user = $response['user'];
    $this->_beers = $response['beers'];

    // If they've got beers, show em in a table.
    if (!empty($this->_beers)) {
      $this->_table = $this->render_table($this->_beers);
    }

    // Assemble the pieces and echo HTML.
    $this->render($this->_user, $this->_table);
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
  public function format_beers($beers)
  {
    if (empty($beers->response->beers->items)) {
      return;
    }

    foreach ($beers->response->beers->items as $beer) {
      $filteredBeers[] = array(
        'brewery' => $beer->brewery->brewery_name,
        'name' => $beer->beer->beer_name,
        'abv' => $beer->beer->beer_abv,
        'style' => $beer->beer->beer_style,
        'rating' => $beer->rating_score,
        'link' => $beer->brewery->contact->url,
        'logo' => $beer->brewery->brewery_label,
        'state' => $beer->brewery->location->brewery_state
      );
    }

    // Sort by ABV, high to low.
    usort($filteredBeers, function($a, $b) {
      return $b['abv'] > $a['abv'] ? 1 : -1;
    });

    return $filteredBeers;
  }


  /**
   * Retrieve a list of beers from Untappd.
   *
   * @param $username
   *    An untappd username
   *
   * @return $beers
   *    Array of the user's beers, sorted by ABV.
   */
  protected function fetch_untappd_info($username)
  {
    include('UntappdPHP/lib/untappdPHP.php');
    $ut = new UntappdPHP(CLIENT_ID, CLIENT_SECRET, BASE_URL);

    $beers = $ut->get('/user/beers/' . $username . '?limit=50');
    $user = $ut->get('/user/info/' . $username);

    $info = array('beers' => $beers, 'user' => $user);

    // @todo return different error if API limit hit (see header)
    // or maybe could it email me? that'd be slick
    /*if ($response['beers']->meta->code !== 200) {
      return;
    }*/

    return $info;
  }


  /**
   * Return HTML for the table.
   *
   * @param $beers
   *    List of beers from the API call.
   *
   * @return $output
   *    String of HTML.
   */
  protected function render_table($beers)
  {
    $filteredBeers = self::format_beers($beers);
    $table_headers = $output = '';

    if (empty($filteredBeers)) {
      $output = '<p>Is the username correct?
        <a href="https://www.google.com/maps/search/bars+near+current+location">Do you need to go drinking</a>?</p>';
      return $output;
    }

    $columns = array(
      '' => '',
      'Brewery' => 'string',
      'Name' => 'string',
      'State' => 'string',
      'ABV' => 'float',
      'Style' => 'string',
      'Rating' => 'float'
    );
    foreach ($columns as $name => $dataType) {
      $classes = strtolower($name);
      if ($name == 'ABV') {
        $classes .= ' sorting-asc';
      }
      if (empty($name)) {
        $classes .= 'image';
      }
      $table_headers .= '<th class="'. $classes . '" data-sort="'. $dataType .'"><a href="#">'. $name .'</a></th>';
    }

    $output .= '<p>Showing most recent '. count($filteredBeers) .' beers. <!--<a href="#show-100">Show 100</a>.--></p>'; // @todo hookup "show 100"
    $output .= '<table id="beer-results">';
    $output .= '<thead>'. $table_headers .'</thead><tbody>';
    foreach ($filteredBeers as $beer) {
      $output .= '<tr>';
      $output .= '<td class="image"><a href="'. $beer['link'] .'"><img height="50" width="50" src="'. $beer['logo'] .'"></a></td>';
      $output .= '<td class="brewery"><a href="'. $beer['link'] .'">'. $beer['brewery'] .'</a></td>';
      $output .= '<td class="name">' . $beer['name'] . '</td>';
      $output .= '<td class="state">' . $beer['state'] . '</td>';
      $output .= '<td class="abv" data-sort-value="'. $beer['abv'] .'">' . $beer['abv'] . '%</td>';
      $output .= '<td class="style">' . $beer['style'] . '</td>';
      $output .= '<td class="rating">' . $beer['rating'] . '</td>';
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
   * @param $user
   *   Object. The queried Untappd user.
   * @param $table
   *   String of HTML for the main results table.
   *
   * @return @void
   */
  protected function render($user, $table)
  {
    $output = '';
    if (!empty($user->response->user)) {
      $output .= '<div class="user-photo" style="background-image: url('. $user->response->user->user_avatar .')"></div>';
      $output .= '<h3 class="user">' . $user->response->user->user_name . '\'s' . ' booziest beers' . '</h3>';
    }
    else {
      $output .= '<h3 class="no-user">No beers found.</h3>';
    }

    $output .= $table;

    echo $output;
  }

}

$username = $_POST['username'];
new Untapper($username);

?>
